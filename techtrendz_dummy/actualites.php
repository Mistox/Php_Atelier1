<?php
require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/article.php";
require_once __DIR__ . "/lib/session.php";
require_once __DIR__ . "/templates/header.php";
require_once __DIR__ . "/lib/category.php";

if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
} else {
    $page = 1;
}

$articles = getArticles($pdo, 6, $page, $_GET['category'] ?? null);

$totalArticles = getTotalArticles($pdo, $_GET['category'] ?? null);

$totalPages = ceil($totalArticles / 6);

$categories = getCategories($pdo);

?>

<h1>TechTrendz Actualités</h1>

<div class="row">
    <?php foreach($categories as $category) : ?>
        <div class="">
            <a href="actualites.php?category=<?= $category['id'] ?>"><?= $category['name'] ?></a>
        </div>
    <?php endforeach; ?>
</div>

<div class="row text-center">

<?php
    // boucle foreach pour afficher les articles
    foreach($articles as $article) {
?>
        <div class="col-md-4 my-2 d-flex">
            <div class="card">
                <img src="<?= ($article['image'] === null) ? _ASSETS_IMAGES_FOLDER_ . "default-article.jpg" : _ARTICLES_IMAGES_FOLDER_ . htmlspecialchars($article['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($article['title']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($article['title']) ?></h5>
                    <a href="actualite.php?id=52" class="btn btn-primary">Lire la suite</a>
                </div>
            </div>
        </div>
<?php    
    }
?>

<!-- gestion de la pagination -->
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
    <li class="page-item <?= ($page ===  $i) ? 'active' : '' ?>"><a class="page-link" href="actualites.php?page=<?= $i ?> <?= (isset($_GET['category'])) ? '&category=' . $_GET['category'] : ''?>"><?= $i ?></a></li>
    <?php endfor; ?>
  </ul>
</nav>

</div>

<?php require_once __DIR__ . "/templates/footer.php"; ?>