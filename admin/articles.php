
<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
adminOnly();

require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/article.php";
require_once __DIR__ . "/templates/header.php";


//@todo décommenter ce code une fois toutes les fonctions codées

if (isset($_GET['page'])) {
  $page = (int)$_GET['page'];
} else {
  $page = 1;
}
$articles = getArticles($pdo, _ADMIN_ITEM_PER_PAGE_, $page);

$totalArticles = getTotalArticles($pdo);

$totalPages = ceil($totalArticles / _ADMIN_ITEM_PER_PAGE_);

?>

<!-- @todo coder la boucle foreach pour afficher les articles -->
<h1 class="display-5 fw-bold text-body-emphasis">Articles</h1>
<div class="d-flex gap-2 justify-content-left py-5">
  <a class="btn btn-primary d-inline-flex align-items-left" href="article.php">
    Ajouter un article
  </a>
</div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Titre</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <!--afficher tout les articles -->
    <?php foreach($articles as $article): ?>
    <tr>
      <th scope="row"> <?= htmlspecialchars($article['id']) ?></th>
      <td><?= htmlspecialchars($article['title']) ?></td>
      <td><a href="article.php?id=<?= htmlspecialchars($article['id']) ?>">Modifier</a>
        | <a href="article_delete.php?id=<?= htmlspecialchars($article['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">Supprimer</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- gestion de la pagination -->
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
    <li class="page-item <?= ($page ===  $i) ? 'active' : '' ?>"><a class="page-link" href="articles.php?page=<?= $i ?>"><?= $i ?></a></li>
    <?php endfor; ?>
  </ul>
</nav>


<?php require_once __DIR__ . "/templates/footer.php"; ?>