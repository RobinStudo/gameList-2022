<?php
require_once './components/data.php';
require_once './components/functions.php';

$id = $_GET['id'] ?? 0;

$query = <<<SQL
    SELECT 
        game.id, game.title, game.poster, game.released_at, game.description,
        IFNULL(GROUP_CONCAT(DISTINCT genre.name SEPARATOR " - "), "Non connu") AS genre,
        company_editor.name AS editor,
        GROUP_CONCAT(DISTINCT company_developer.name SEPARATOR " - ") AS developer,
        GROUP_CONCAT(DISTINCT platform.name SEPARATOR " - ") AS platforms,
        COUNT(review.game_id) AS counterRecommandation
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
    header('Location: /index.php');
    die();
}

require_once './components/header.php';
?>

<div class="game">
    <div class="game-preview">
        <img src="<?php echo $game['poster'] ?? getDefaultGamePoster(); ?>" alt="<?php echo $game['title']; ?>">
        <div class="game-preview__details">
            <div></div>
            <h1><?php echo $game['title']; ?></h1>
            <ul>
                <li>
                    <i class="fa-solid fa-users-gear"></i>
                    <?php echo $game['editor'] ?? 'Indépendant'; ?> / <?php echo $game['developer'] ?? 'Non connu'; ?>
                </li>
                <li>
                    <i class="fa-solid fa-thumbs-up"></i>
                    <?php echo $game['counterRecommandation']; ?>
                </li>
                <li>
                    <i class="fa-solid fa-calendar-days"></i>
                    <?php echo $game['released_at'] ?? 'TBC'; ?>
                </li>
            </ul>
        </div>
    </div>

    <div class="game-details">
        <p>
            <?php echo $game['description']; ?>
        </p>

        <aside>
            <div>
                <i class="fa-solid fa-tag"></i>
                <?php echo $game['genre']; ?>
            </div>
            <div>
                <i class="fa-solid fa-gamepad"></i>
                <?php echo $game['platforms'] ?? 'Non connu'; ?>
            </div>
        </aside>
    </div>
</div>

<?php
require_once './components/footer.php';
?>