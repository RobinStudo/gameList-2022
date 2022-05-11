<?php
// TODO - A supprimer après la refonte de la page
function average(array $array, int $precision = 1): float
{
    $avg = array_sum($array) / count($array);
    return round($avg, $precision);
}

// ----- Database Quieres -----
function findGames(string $order = NULL, int $limit = NULL): array
{
    global $db;

    $query = <<<SQL
        SELECT 
            game.id, game.title, game.poster, 
            IFNULL(GROUP_CONCAT(genre.name SEPARATOR " - "), "Non connu") AS genre, 
            COUNT(DISTINCT review.game_id) AS counterRecommandation 
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
            COUNT(DISTINCT review.game_id) AS counterRecommandation
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

// ----- Utils -----
function getDefaultGamePoster(): string
{
    return 'https://www.onlylondon.properties/application/modules/themes/views/default/assets/images/image-placeholder.png';
}



