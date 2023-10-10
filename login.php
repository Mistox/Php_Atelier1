<?php
require_once 'lib/config.php';
require_once 'lib/session.php';
require_once 'lib/pdo.php';
require_once 'lib/user.php';
require_once 'templates/header.php';


$errors = [];
$messages = [];

// If user is already logged in, redirect to home page
if (isset($_POST['loginUser'])) {
    $user = verifyUserLoginPassword($pdo, $_POST['email'], $_POST['password']);

    if ($user) {
        $_SESSION['user'] = $user;
        header( ($user['role'] == 'admin') ? 'Location: ./admin/index.php' : 'Location: ./index.php');
    } else {
        $errors[] = "Email ou mot de passe incorrect";
    }
  }

?>
    <h1>Login</h1>

    <?php
        if ($errors) {
            echo "<div class='alert alert-danger'>";
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
    ?>

    <form method="POST">
        <div class="mb-3">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de psse</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <input type="submit" name="loginUser" class="btn btn-primary" value="Enregistrer">

    </form>

    <?php
require_once 'templates/footer.php';
?>