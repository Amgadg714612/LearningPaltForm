<?php
require_once 'config.php';
require_once 'Post.php';


class PostHandler {
    
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    // إضافة منشور جديد
    public function addPost(Post $post) {
        $sql = "INSERT INTO posts (title, content) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post->getTitle(), $post->getContent()]);
        return $this->pdo->lastInsertId();
    }    
    
    // تعديل منشور
    public function updatePost(Post $post) {
        $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$post->getTitle(), $post->getContent(), $post->getId()]);
        return $stmt->rowCount();
    }

    // حذف منشور
    public function deletePost($id) {
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }


    // عرض جميع المنشورات
    public function getAllPosts() {
        $sql = "SELECT * FROM posts";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // عرض منشور واحد بواسطة الـ ID
    public function getPostById($id) {
        $sql = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>