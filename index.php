<?php
require_once './components/data.php';
require_once './components/functions.php';
require_once './components/header.php';

shuffle($games);
?>

<section class="landing">
    <h1>GameList - Votre bibliothéque de jeux</h1>
</section>

<section>
    <h2>Recommandé pour vous</h2>

    <div class="auto-grid">
        <?php for($i = 0; $i < 3; $i++){ ?>
            <?php $game = $games[$i]; ?>
            <a href="/single.php?id=<?php echo $game['id']; ?>" class="card">
                <div class="card-badge">
                    <?php echo average($game['reviews']); ?>
                </div>
                <img src="<?php echo $game['poster']; ?>" alt="<?php echo $game['name']; ?>" class="card-image">
                <div class="card-title">
                    <h2><?php echo $game['name']; ?></h2>
                    <span><?php echo $game['category']; ?></span>
                </div>
            </a>
        <?php } ?>
    </div>
</section>

<?php
usort($games, function($a, $b){
    $averageA = average($a['reviews']);
    $averageB = average($b['reviews']);

    if($averageA > $averageB){
        return -1;
    }

    if($averageA < $averageB){
        return 1;
    }

    return 0;
});
?>
<section>
    <h2>Les succès du moment</h2>

    <div class="auto-grid">
        <?php for($i = 0; $i < 3; $i++){ ?>
            <?php $game = $games[$i]; ?>
            <a href="/single.php?id=<?php echo $game['id']; ?>" class="card">
                <div class="card-badge">
                    <?php echo average($game['reviews']); ?>
                </div>
                <img src="<?php echo $game['poster']; ?>" alt="<?php echo $game['name']; ?>" class="card-image">
                <div class="card-title">
                    <h2><?php echo $game['name']; ?></h2>
                    <span><?php echo $game['category']; ?></span>
                </div>
            </a>
        <?php } ?>
    </div>
</section>

<?php
require_once './components/footer.php';
?>