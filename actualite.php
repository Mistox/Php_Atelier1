<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/article.php";
require_once __DIR__ . "/lib/comment.php";
require_once __DIR__ . "/lib/session.php";
require_once __DIR__ . "/templates/header.php";


//@todo On doit récupérer l'id en paramètre d'url et appeler la fonction getArticleById récupérer l'article
$article = getArticleById($pdo, $_GET['id']);
$comments = getCommentsByArticleId($pdo, $_GET['id']);

if (isset($_POST['newComment'])) {
    $content = $_POST['content'];
    $articleId = $_POST['article_id'];
    $userId = $_POST['user_id'];

    newComment($pdo, $content, $articleId, $userId);

    header("Location: actualite.php?id=$articleId");
}
?>


<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
    <div class="col-10 col-sm-8 col-lg-6">
        <img src="<?= ($article['image'] === null) ? _ASSETS_IMAGES_FOLDER_ . "default-article.jpg" : _ARTICLES_IMAGES_FOLDER_ . htmlspecialchars($article['image']) ?>" class="d-block mx-lg-auto img-fluid" alt="<?= htmlspecialchars($article['title']) ?>" width="700" height="500" loading="lazy">
    </div>
    <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3"><?= htmlspecialchars($article['title']) ?></h1>
        <p class="lead"><?= htmlspecialchars($article['content']) ?></p>
    </div>
</div>

<div>
    <?php foreach (getCommentsByArticleId($pdo, $_GET['id']) as $comment) : ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($comment['email']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($comment['content']) ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div>
    <?php if (isset($_SESSION['user'])) : ?>
        <form method="POST">
            <input type="hidden" name="article_id" value="<?= $_GET['id'] ?>">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
            <div class="mb-3">
                <label for="content" class="form-label">Commentaire</label>
                <textarea class="form-control" name="content" id="content" rows="3"></textarea>
            </div>
            <button type="submit" name="newComment" class="btn btn-primary">Envoyer</button>
        </form>
    <?php else : ?>
        <p>Vous devez être connecté pour poster un commentaire !</p> 
        <a href="login.php">Se connecter</a> ou <a href="register.php">S'inscrire</a>
    <?php endif; ?>
</div>


<?php require_once __DIR__ . "/templates/footer.php"; ?>