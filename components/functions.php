<?php
// ----- Database Quieres -----
function findGames(string $order = NULL, int $limit = NULL): array
{
    global $db;

    $query = <<<SQL
        SELECT 
            game.id, game.title, game.poster, 
            IFNULL(GROUP_CONCAT(genre.name SEPARATOR " - "), "Non connu") AS genre, 
            COUNT(DISTINCT review.user_id) AS counterRecommandation 
        FROM game
            LEFT JOIN review ON game.id = review.game_id AND review.is_recommanded = 1
            LEFT JOIN game_genre ON game.id = game_genre.game_id
            LEFT JOIN genre ON game_genre.genre_id = genre.id
        GROUP BY game.id
    SQL;

    if($order === 'rand') {
        $query .= ' ORDER BY RAND()';
    }else if($order === 'recommandation'){
        $query .= ' ORDER BY counterRecommandation DESC';
    }

    if($limit !== NULL){
        $query .= ' LIMIT :limit';
    }

    $stmt = $db->prepare($query);

    if($limit !== NULL){
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}

function findGame(int $id): ?array
{
    global $db;

    $query = <<<SQL
        SELECT 
            game.id, game.title, game.poster, game.released_at, game.description,
            IFNULL(GROUP_CONCAT(DISTINCT genre.name SEPARATOR " - "), "Non connu") AS genre,
            company_editor.name AS editor,
            GROUP_CONCAT(DISTINCT company_developer.name SEPARATOR " - ") AS developer,
            GROUP_CONCAT(DISTINCT platform.name SEPARATOR " - ") AS platforms,
            COUNT(DISTINCT review.user_id) AS counterRecommandation
        FROM game
            LEFT JOIN review ON game.id = review.game_id AND review.is_recommanded = 1
            LEFT JOIN game_genre ON game.id = game_genre.game_id
            LEFT JOIN genre ON game_genre.genre_id = genre.id
            LEFT JOIN company company_editor ON game.editor_id = company_editor.id
            LEFT JOIN developer ON game.id = developer.game_id
            LEFT JOIN company company_developer ON developer.company_id = company_developer.id
            LEFT JOIN game_platform ON game.id = game_platform.game_id
            LEFT JOIN platform ON game_platform.platform_id = platform.id
        WHERE game.id = :id
        GROUP BY game.id;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('id', $id);
    $stmt->execute();
    $game = $stmt->fetch();
    if($game === false){
        return null;
    }

    return $game;
}

function insertReview(array $review): bool
{
    global $db;
    $query = <<<SQL
        INSERT INTO review (game_id, user_id, is_recommanded, comment)
            VALUES (:gameId, :userId, :isRecommanded, :comment);
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('gameId', $review['gameId'], PDO::PARAM_INT);
    $stmt->bindValue('userId', $review['userId'], PDO::PARAM_INT);
    $stmt->bindValue('isRecommanded', $review['isRecommanded'], PDO::PARAM_INT);
    $stmt->bindValue('comment', $review['comment']);

    try{
        $stmt->execute();
        return true;
    }catch(Exception $e){
        return false;
    }
}

function insertUser(string $username, string $email, string $password): bool
{
    global $db;
    $query = <<<SQL
        INSERT INTO user (username, email, password, roles, created_at)
            VALUES (:username, :email, :password, '[]', NOW());
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('username', $username);
    $stmt->bindValue('email', $email);
    $stmt->bindValue('password', $password);

    try{
        $stmt->execute();
        return true;
    }catch(Exception $exception){
        return false;
    }
}

function checkUserReviewedGame(int $gameId, int $userId): bool
{
    global $db;
    $query = <<<SQL
        SELECT COUNT(game_id) AS counterReview FROM review 
        WHERE game_id = :gameId AND user_id = :userId;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('gameId', $gameId, PDO::PARAM_INT);
    $stmt->bindValue('userId', $userId, PDO::PARAM_INT);

    $stmt->execute();
    $result = $stmt->fetchColumn();

    if($result === 0){
        return false;
    }

    return true;
}

function checkExistingUserEmail(string $email): bool
{
    global $db;
    $query = <<<SQL
        SELECT COUNT(email) AS counterEmail FROM user 
        WHERE email = :email;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('email', $email);

    $stmt->execute();
    $result = $stmt->fetchColumn();

    if($result === 0){
        return false;
    }

    return true;
}

function findUserByEmail(string $email): ?array
{
    global $db;
    $query = <<<SQL
        SELECT * FROM user WHERE email = :email;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('email', $email);
    $stmt->execute();

    $user = $stmt->fetch();
    if($user === false){
        return null;
    }

    return $user;
}

function findUserById(int $id): ?array
{
    global $db;
    $query = <<<SQL
        SELECT * FROM user WHERE id = :id;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch();
    if($user === false){
        return null;
    }

    return $user;
}

// ----- Flash Messages -----
function addFlash(string $type, string $message): void
{
    $messages = $_SESSION['messages'] ?? [];

    $messages[] = [
        'type' => $type,
        'content' => $message,
    ];

    $_SESSION['messages'] = $messages;
}

function getAllFlashes(): array
{
    $messages = $_SESSION['messages'] ?? [];
    unset($_SESSION['messages']);
    return $messages;
}

// ----- Form -----
function checkRegisterData(string $username, string $email, string $password, bool $cgu): array
{
    $errors = [];

    // Check username
    if(strlen($username) < 3){
        $errors[] = 'Votre nom d\'utilisateur doit contenir au moins 3 caractères';
    }else if(strlen($username) > 24){
        $errors[] = 'Votre nom d\'utilisateur doit contenir au maximum 24 caractères';
    }

    if(!ctype_alnum($username)){
        $errors[] = 'Votre nom d\'utilisateur doit contenir uniquement des caractères alphanumériques';
    }

    // Check email
    if(empty($email)){
        $errors[] = 'Vous devez saisir votre adresse e-mail';
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Vous devez saisir une adresse e-mail valide';
    }else if(checkExistingUserEmail($email)){
        $errors[] = 'Cette adresse e-mail est déjà utilisée';
    }

    // Check password
    if(strlen($password) < 8){
        $errors[] = 'Votre mot de passe doit contenir au moins 8 caractères';
    }else if(strlen($password) > 30){
        $errors[] = 'Votre mot de passe doit contenir au maximum 30 caractères';
    }

    $regex = '/(?=.{0,}[a-z])(?=.{0,}[^a-zA-Z0-9])(?=.{0,}\d)/';
    if(preg_match($regex, $password) === 0){
        $errors[] = 'Votre mot de passe doit contenir au moins un chiffre, une lettre et un caractère spécial';
    }

    // Check CGU
    if($cgu === false){
        $errors[] = 'Vous devez accepter nos CGU';
    }

    return $errors;
}

// ----- Security -----
function login(int $userId): void
{
    $_SESSION['authenticated'] = true;
    $_SESSION['userId'] = $userId;
}

function logout(): void
{
    $_SESSION['authenticated'] = false;
    unset($_SESSION['userId']);
}

function isLoggedIn(): bool
{
    return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
}

function reloadUserFormDatabase(): ?array
{
    if(empty($_SESSION['userId'])){
        return null;
    }

    return findUserById($_SESSION['userId']);
}

// ----- Utils -----
function getDefaultGamePoster(): string
{
    return 'https://www.onlylondon.properties/application/modules/themes/views/default/assets/images/image-placeholder.png';
}

