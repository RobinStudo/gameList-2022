<?php
require_once './components/data.php';
require_once './components/functions.php';
require_once './components/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = htmlspecialchars($_POST['username'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $password = htmlspecialchars($_POST['password'] ?? '');
    $cgu = isset($_POST['cgu']);

    $errors = checkRegisterData($username, $email, $password, $cgu);
}
?>

<h1>Rejoignez la communauté</h1>

<form method="post">
    <div class="form-field">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username">
    </div>

    <div class="form-field">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email">
    </div>

    <div class="form-field">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
    </div>

    <div class="form-field">
        <input type="checkbox" name="cgu" id="cgu">
        <label for="cgu">J'accepte les CGU</label>
    </div>

    <div class="form-actions">
        <button class="button">Créer mon compte</button>
    </div>
</form>

<?php
require_once './components/footer.php';
?>
