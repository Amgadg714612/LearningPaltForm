<?php
include_once 'CourseVideo.php';
class Course_videoHandler {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // إضافة فيديو جديد باستخدام الإجراء المخزن
    public function addVideo(Course_video $video) {
        $sql = "CALL AddCourseVideo(:course_id, :title, :video_url)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':course_id' => $video->course_id,
            ':title' => $video->title,
            ':video_url' => $video->video_url
        ]);
        return $this->pdo->lastInsertId();
    }

    // باقي الدوال (تعديل، حذف، عرض) تبقى كما هي
    public function updateVideo($id, $title, $video_url) {
        $sql = "UPDATE course_videos SET title = :title, video_url = :video_url WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':video_url' => $video_url
        ]);
        return $stmt->rowCount();
    }

    public function deleteVideo($id) {
        $sql = "DELETE FROM course_videos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    public function getAllVideos() {
        $sql = "SELECT * FROM course_videos";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVideosByCourse($course_id) {
        $sql = "SELECT * FROM course_videos WHERE course_id = :course_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':course_id' => $course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVideoById($id) {
        $sql = "SELECT * FROM course_videos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>