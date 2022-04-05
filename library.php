<?php
require_once './components/data.php';
require_once './components/header.php';
?>

<h1>Bibliothéque</h1>

<div class="auto-grid">
    <?php foreach($games as $game){ ?>
        <?php
        $average = array_sum($game['reviews']) / count($game['reviews']);
        ?>

        <div class="card">
            <div class="card-badge">
                <?php echo $average; ?>
            </div>
            <img src="<?php echo $game['poster']; ?>" alt="<?php echo $game['name']; ?>" class="card-image">
            <div class="card-title">
                <h2><?php echo $game['name']; ?></h2>
                <span><?php echo $game['category']; ?></span>
            </div>
        </div>
    <?php } ?>
</div>

<?php
require_once './components/footer.php';
?>