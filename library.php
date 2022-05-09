<?php
require_once './components/data.php';
require_once './components/functions.php';
require_once './components/header.php';

$query = <<<SQL
    SELECT 
        game.id, game.title, game.poster, 
        IFNULL(GROUP_CONCAT(genre.name SEPARATOR " - "), "Non connu") AS genre, 
        COUNT(review.game_id) AS counterRecommandation 
    FROM game
        LEFT JOIN review ON game.id = review.game_id AND review.is_recommanded = 1
        LEFT JOIN game_genre ON game.id = game_genre.game_id
        LEFT JOIN genre ON game_genre.genre_id = genre.id
    GROUP BY game.id;
SQL;


$stmt = $db->query($query);
$games = $stmt->fetchAll();
$defaultPicture = 'https://www.onlylondon.properties/application/modules/themes/views/default/assets/images/image-placeholder.png';
?>

<h1>Bibliothéque</h1>

<div class="auto-grid">
    <?php foreach($games as $game){ ?>
        <a href="/single.php?id=<?php echo $game['id']; ?>" class="card">
            <?php if($game['counterRecommandation'] >= 1){ ?>
                <div class="card-badge">
                    <i class="fas fa-thumbs-up"></i>
                    <?php echo $game['counterRecommandation']; ?>
                </div>
            <?php } ?>
            <img src="<?php echo $game['poster'] ?? $defaultPicture; ?>" alt="<?php echo $game['title']; ?>" class="card-image">
            <div class="card-title">
                <h2><?php echo $game['title']; ?></h2>
                <span><?php echo $game['genre']; ?></span>
            </div>
        </a>
    <?php } ?>
</div>

<?php
require_once './components/footer.php';
?>