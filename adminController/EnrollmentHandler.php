<?php
require_once 'config.php';

class EnrollmentHandler {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    // // تسجيل إكمال الفيديو
    // public function markVideoAsCompleted($student_id, $course_id, $video_id) {
    //     $sql = "UPDATE enrollments 
    //             SET last_lesson = ?, status = 'completed' 
    //             WHERE student_id = ? AND course_id = ?";
    //     $stmt = $this->pdo->prepare($sql);
    //     return $stmt->execute([$video_id, $student_id, $course_id]);
    // }
      // تسجيل إكمال الفيديو
      public function markVideoAsCompleted($student_id, $course_id, $video_id) {
        // التحقق من عدم تسجيل الفيديو مسبقًا
        $sql = "SELECT * FROM user_video_progress 
                WHERE student_id = ? AND course_id = ? AND video_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id, $course_id, $video_id]);
        $existingRecord = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRecord) {
            // إذا كان الفيديو مسجل مسبقًا، قم بتحديثه
            $sql = "UPDATE user_video_progress 
                    SET completed = 1, completed_at = CURRENT_TIMESTAMP 
                    WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$existingRecord['id']]);
        } else {
            // إذا لم يكن الفيديو مسجل مسبقًا، قم بإضافته
            $sql = "INSERT INTO user_video_progress (student_id, course_id, video_id, completed) 
                    VALUES (?, ?, ?, 1)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$student_id, $course_id, $video_id]);
        }
    }
    // الحصول على حالة التسجيل
    public function getEnrollmentStatus($student_id, $course_id) {
        $sql = "SELECT * FROM enrollments WHERE student_id = ? AND course_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student_id, $course_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>