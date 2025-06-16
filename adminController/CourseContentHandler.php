<?php
require_once 'config.php';
require_once 'CourseContent.php';

class CourseContentHandler {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    // إضافة محتوى جديد
    public function addContent(CourseContent $content) {
        $sql = "INSERT INTO course_content (course_id, title, content) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $content->getCourseId(),
            $content->getTitle(),
            $content->getContent()
        ]);
        return $this->pdo->lastInsertId();
    }
    // عرض محتوى الدورة
    public function getContentByCourseId($course_id) {
        $sql = "SELECT * FROM course_content WHERE course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // حذف محتوى
    public function deleteContent($id) {
        $sql = "DELETE FROM course_content WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
?>