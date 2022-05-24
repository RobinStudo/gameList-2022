<?php
require_once './components/data.php';
require_once './components/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = findUserByEmail($email);
    if($user !== null){
        if(password_verify($password, $user['password'])){
            login($user['id']);
            addFlash('success', 'Vous êtes bien connecté');
            header('Location: index.php');
            die();
        }else{
            $error = 'Les identifants sont incorrectes';
        }
    }else{
        $error = 'Les identifants sont incorrectes';
    }
}
?>
<h1>Connexion</h1>

<form method="post">
    <?php if(!empty($error)){ ?>
        <ul class="form-errors">
            <li><?php echo $error; ?></li>
        </ul>
    <?php } ?>

    <div class="form-field">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="<?php echo $email ?? ''; ?>">
    </div>

    <div class="form-field">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="form-actions">
        <button class="button">Connexion</button>
    </div>
</form>
<?php
require_once './components/footer.php';
?>
