<?php
require_once './components/data.php';
require_once './components/functions.php';

$id = $_GET['id'] ?? 0;

foreach ($games as $gameData){
    if($gameData['id'] == $id){
        $game = $gameData;
        break;
    }
}

if(!isset($game)){
    header('Location: /index.php');
    die();
}

require_once './components/header.php';
?>

<div class="game">
    <div class="game-preview">
        <img src="<?php echo $game['poster']; ?>" alt="<?php echo $game['name']; ?>">
        <div class="game-preview__details">
            <div></div>
            <h1><?php echo $game['name']; ?></h1>
            <ul>
                <li>
                    <i class="fa-solid fa-users-gear"></i>
                    <?php echo $game['editor'] . ' / ' . $game['developer']; ?>
                </li>
                <li>
                    <i class="fa-solid fa-gauge-simple"></i>
                    <?php echo average($game['reviews']); ?>
                </li>
                <li>
                    <i class="fa-solid fa-calendar-days"></i>
                    <?php echo $game['releaseDate']; ?>
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
                <?php echo $game['category']; ?>
            </div>
            <div>
                <i class="fa-solid fa-gamepad"></i>
                <?php echo implode(', ', $game['platforms']); ?>
            </div>
        </aside>
    </div>
</div>

<?php
require_once './components/footer.php';
?>