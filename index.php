<?php
require_once './components/data.php';
require_once './components/functions.php';
require_once './components/header.php';
?>

<section class="landing">
    <h1>GameList - Votre bibliothéque de jeux</h1>
</section>

<section>
    <h2>Recommandé pour vous</h2>

    <div class="auto-grid">
        <?php foreach(findGames('rand', 3) as $game){ ?>
            <a href="/single.php?id=<?php echo $game['id']; ?>" class="card">
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
</section>

<section>
    <h2>Les succès du moment</h2>

    <div class="auto-grid">

    </div>
</section>

<?php
require_once './components/footer.php';
?>