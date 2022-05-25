<?php
require_once './components/data.php';
require_once './components/header.php';

if(isset($_FILES['picture'])){
    if($_FILES['picture']['error'] === UPLOAD_ERR_OK){

        $maxSize = 2000000; // 2 Mo
        if($_FILES['picture']['size'] < $maxSize){

            $allowedMimeTypes = ['image/jpeg', 'image/png'];
            if(in_array($_FILES['picture']['type'], $allowedMimeTypes)){
                $oldPicture = getUserPicture($connectedUser, false);
                if($oldPicture !== null){
                    unlink($oldPicture);
                }

                $explodedName = explode('.', $_FILES['picture']['name']);
                $fileExt = strtolower(end($explodedName));

                $name = buildUserPictureName($connectedUser);
                $path = 'uploads/' . $name . '.' . $fileExt;

                move_uploaded_file($_FILES['picture']['tmp_name'], $path);
                addFlash('success', 'Votre image a bien été téléchargée');
                header('Location: ' . $_SERVER['REQUEST_URI']);
                die();
            }else{
                $error = 'Votre image doit être au format jpeg ou png';
            }

        }else{
            $error = 'Votre image ne doit pas dépasser 2Mo';
        }

    }else if($_FILES['picture']['error'] === UPLOAD_ERR_NO_FILE){
        $error = 'Veuillez sélectionner un fichier';
    }else{
        $error = 'Une erreur est survenue, veuillez réessayer';
    }
}
?>

<h1>Mon profil</h1>

<form method="post" enctype="multipart/form-data">
    <?php if(!empty($error)){ ?>
        <ul class="form-errors">
            <li><?php echo $error; ?></li>
        </ul>
    <?php } ?>

    <div class="form-field">
        <label for="picture">
            <img src="<?php echo getUserPicture($connectedUser); ?>"
                 alt="<?php echo $connectedUser['username']; ?>" class="user-picture">
        </label>
        <input type="file" name="picture" id="picture" accept="image/jpeg,image/png">
    </div>
    <div class="form-actions">
        <button class="button">Uploader</button>
    </div>
</form>

<?php
require_once './components/footer.php';
?>
