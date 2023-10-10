
<?php

/*
    * @param PDO $pdo
    * @param string $email
    * @param string $password
    * @return array|bool
*/
function getArticleById(PDO $pdo, int $id):array|bool
{
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();
    
    return $query->fetch(PDO::FETCH_ASSOC);
}

/*
    * @param PDO $pdo
    * @param int $limit
    * @param int $page
    * @return array|bool
*/
function getArticles(PDO $pdo, int $limit = null, int $page = null, int $id_category = null):array|bool
{
    if($limit === null && $page === null) {
        $sql = ($id_category === null) ? 
            "SELECT * FROM articles ORDER BY id DESC" : 
            "SELECT * FROM articles WHERE category_id = :id_category ORDER BY id DESC";
        $query = $pdo->prepare($sql);
    } else {
        $offset = ($page - 1) * $limit;
        $sql = ($id_category === null) ?
            "SELECT * FROM articles ORDER BY id DESC LIMIT :limit OFFSET :offset" :
            "SELECT * FROM articles WHERE category_id = :id_category ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $query = $pdo->prepare($sql);
        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->bindValue(":offset", $offset, PDO::PARAM_INT);
    }

    if($id_category !== null) {
        $query->bindValue(":id_category", $id_category, PDO::PARAM_INT);
    }
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/*
    * @param PDO $pdo
    * @return int|bool
*/
function getTotalArticles(PDO $pdo, int $id_category = null):int|bool
{
    $sql = ($id_category === null) ?
        "SELECT COUNT(id) as total FROM articles" :
        "SELECT COUNT(id) as total FROM articles WHERE category_id = :id_category";
    $query = $pdo->prepare($sql);
    if($id_category !== null) {
        $query->bindValue(":id_category", $id_category, PDO::PARAM_INT);
    }
    $query->execute();

    return $query->fetch(PDO::FETCH_ASSOC)['total'];
}

/*
    * @param PDO $pdo
    * @param string $title
    * @param string $content
    * @param string|null $image
    * @param int $category_id
    * @param int|null $id
    * @return bool
*/
function saveArticle(PDO $pdo, string $title, string $content, string|null $image, int $category_id, int $id = null):bool 
{
    if ($id === null) {
        $query = $pdo->prepare("INSERT INTO articles (title, content, image, category_id) VALUES (:title, :content, :image, :category_id)");

    } else {
        $query = $pdo->prepare("UPDATE articles SET title = :title, content = :content, image = :image, category_id = :category_id WHERE id = :id");
        $query->bindValue(":id", $id, PDO::PARAM_INT);
    }

    $query->bindValue(":title", $title);
    $query->bindValue(":content", $content);
    $query->bindValue(":image", $image);
    $query->bindValue(":category_id", $category_id, PDO::PARAM_INT);
   
    return $query->execute();
}

/*
    * @param PDO $pdo
    * @param int $id
    * @return bool
*/
function deleteArticle(PDO $pdo, int $id):bool
{
    $query = $pdo->prepare("DELETE FROM articles WHERE id = :id");
    $query->bindValue(":id", $id, PDO::PARAM_INT);
    $query->execute();

    return ($query->rowCount() > 0) ? true : false;
}