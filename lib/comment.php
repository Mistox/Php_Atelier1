<?php
    function getCommentsByArticleId(PDO $pdo, int $id):array|bool
    {
        $query = $pdo->prepare("SELECT * FROM comments JOIN users ON comments.user_id = users.id WHERE article_id = :id ORDER BY created_at DESC");
        $query->bindValue(":id", $id, PDO::PARAM_INT);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    };

    function newComment(PDO $pdo, string $content, int $articleId, int $userId):bool
    {
        $query = $pdo->prepare("INSERT INTO comments (content, article_id, user_id) VALUES (:content, :article_id, :user_id)");
        $query->bindValue(":content", $content, PDO::PARAM_STR);
        $query->bindValue(":article_id", $articleId, PDO::PARAM_INT);
        $query->bindValue(":user_id", $userId, PDO::PARAM_INT);
        
        return $query->execute();
    };
?>