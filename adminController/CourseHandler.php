<?php
require 'config.php';
require_once 'Course.php';

class CourseHandler {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addCourse(Course $course) {
        $sql = "INSERT INTO courses (name, description, teacher_id, start_date, end_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $course->getName(),
            $course->getDescription(),
            $course->getTeacherId(),
            $course->getStartDate(),
            $course->getEndDate()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function updateCourse(Course $course) {
        $sql = "UPDATE courses SET name = ?, description = ?, teacher_id = ?, start_date = ?, end_date = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $course->getName(),
            $course->getDescription(),
            $course->getTeacherId(),
            $course->getStartDate(),
            $course->getEndDate(),
            $course->getId()
        ]);
        return $stmt->rowCount();
    }

    public function deleteCourse($id) {
        $sql = "DELETE FROM courses WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    public function getAllCourses() {
        $sql = "SELECT * FROM courses";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id) {
        $sql = "SELECT * FROM courses WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCompletedCourses($user_id) {
        $sql = "
            SELECT c.id, c.name, c.description
            FROM courses c
            WHERE c.id IN (
                SELECT course_id
                FROM course_videos
                GROUP BY course_id
                HAVING COUNT(*) = (
                    SELECT COUNT(*)
                    FROM user_video_progress
                    WHERE student_id = ? AND completed = 1 AND course_id = c.id
                )
            )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * جلب الدورات غير المكتملة لمستخدم معين
     *
     * @param int $user_id
     * @return array
     */
    public function getIncompleteCourses($user_id) {
        $sql = "
            SELECT c.id, c.name, c.description
            FROM courses c
            WHERE c.id IN (
                SELECT course_id
                FROM course_videos
                GROUP BY course_id
                HAVING COUNT(*) > (
                    SELECT COUNT(*)
                    FROM user_video_progress
                    WHERE student_id = ? AND completed = 1 AND course_id = c.id
                )
            )
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>