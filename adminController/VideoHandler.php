<?php
require_once 'config.php';

class VideoHandler {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // جلب الفيديو المرتبط بدورة معينة
    public function getVideoByCourseId($course_id) {
        $sql = "SELECT * FROM videos WHERE course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$course_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>