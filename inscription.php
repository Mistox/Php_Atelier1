<?php
require_once 'lib/config.php';
require_once 'lib/tools.php';
require_once 'lib/pdo.php';
require_once 'lib/user.php';
require_once __DIR__ . "/lib/session.php";
require_once 'templates/header.php';

$errors = [];
$messages = [];

// afficher si l'utilisateur s'est inscrit avec succès
if (isset($_POST['addUser'])) {
    $user = addUser($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password']);
    if($user) {
        $messages[] = "Merci pour votre inscription";
    } else {
        $errors[] = "Une erreur s'est produite lors de votre inscription";
    }

    
}

?>
    <h1>Inscription</h1>


    <?php 
        if ($errors) {
            echo "<div class='alert alert-danger'>";
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
        if ($messages) {
            echo "<div class='alert alert-success'>";
            foreach ($messages as $message) {
                echo "<p>$message</p>";
            }
            echo "</div>";
        }
    ?>

    <form method="POST">
        <div class="mb-3">
            <label for="first_name" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="first_name" name="first_name">
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="last_name" name="last_name">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de psse</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <input type="submit" name="addUser" class="btn btn-primary" value="Enregistrer">

    </form>

    <?php
require_once 'templates/footer.php';
?>