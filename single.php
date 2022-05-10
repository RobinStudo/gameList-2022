<?php
require_once './components/data.php';
require_once './components/functions.php';

$id = (int) $_GET['id'] ?? 0;

$game = findGame($id);
if(!$game){
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