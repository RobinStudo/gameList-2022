<?php
require_once './components/data.php';
require_once './components/header.php';
?>
<h1>Bibliothéque</h1>

<div class="auto-grid">
    <?php foreach(findGames() as $game){ ?>
        <a href="single.php?id=<?php echo $game['id']; ?>" class="card">
            <?php if($game['counterRecommandation'] >= 1){ ?>
                <div class="card-badge">
                    <i class="fas fa-thumbs-up"></i>
                    <?php echo $game['counterRecommandation']; ?>
                </div>
            <?php } ?>
            <img src="<?php echo $game['poster'] ?? getDefaultGamePoster(); ?>" alt="<?php echo $game['title']; ?>" class="card-image">
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
