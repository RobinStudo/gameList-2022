<?php
require_once './components/data.php';
require_once './components/functions.php';
require_once './components/header.php';
?>

<h1>Bibliothéque</h1>

<div class="auto-grid">
    <?php foreach($games as $game){ ?>
        <a href="#" class="card">
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

<?php
require_once './components/footer.php';
?>