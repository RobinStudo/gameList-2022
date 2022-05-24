<?php
require_once './components/data.php';

$id = (int) $_GET['id'] ?? 0;

$game = findGame($id);
if(!$game){
    header('Location: /index.php');
    die();
}

$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $action = $_POST['action'] ?? '';

    if($action === 'publishComment'){
        $review = [];

        $review['isRecommanded'] = isset($_POST['is_recommanded']);

        if(strlen($_POST['comment']) > 10 && strlen($_POST['comment']) < 500){
            $review['comment'] = htmlspecialchars($_POST['comment']);
        }else{
            $errors[] = 'Votre commentaire doit contenir entre 10 et 500 caractères';
        }

        if(count($errors) === 0){
            $review['gameId'] = $game['id'];
            $review['userId'] = $connectedUser['id'];

            if(!insertReview($review)){
                $errors[] = 'Une erreur inconnue est survenue, veuillez réessayer ultérieurement';
            }else{
                addFlash('success', 'Votre commentaire a bien été pris en compte');
                header('Location: ' . $_SERVER['REQUEST_URI']);
                die();
            }
        }
    }else if($action === 'addToLibrary'){
        if(checkGameInUserLibrary($game['id'], $connectedUser['id'])){
            deleteGameInLibrary($game['id'], $connectedUser['id']);
        }else{
            insertGameInLibrary($game['id'], $connectedUser['id']);
        }
    }
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

    <section>
        <?php if(isLoggedIn()){ ?>
            <form method="post">
                <input type="hidden" name="action" value="addToLibrary">
                <button class="button">Ajouter à ma bibliothéque</button>
            </form>
        <?php } ?>
    </section>

    <section>
        <?php if(isLoggedIn() && !checkUserReviewedGame($game['id'], $connectedUser['id'])){ ?>
            <h2>Laisser votre avis</h2>

            <form method="post">
                <ul class="form-errors">
                    <?php foreach($errors as $error){ ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>

                <div class="form-field">
                    <input type="checkbox" name="is_recommanded" id="isRecommandedInput" <?php echo isset($_POST['is_recommanded']) ? 'checked' : '' ?>>
                    <label for="isRecommandedInput">Recommandez-vous ce jeu ?</label>
                </div>

                <div class="form-field">
                    <label for="commentInput">Votre commentaire</label>
                    <textarea name="comment" id="commentInput" rows="10"><?php echo $_POST['comment'] ?? ''; ?></textarea>
                </div>

                <div class="form-actions">
                    <input type="hidden" name="action" value="publishComment">
                    <button class="button">Publier</button>
                </div>
            </form>
        <?php } ?>
    </section>
</div>

<?php
require_once './components/footer.php';
?>
