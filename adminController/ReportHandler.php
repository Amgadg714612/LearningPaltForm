<?php
require_once 'config.php';
require_once 'Report.php';
require_once 'StudentReport.php';
require_once 'CourseReport.php';
require_once 'TeacherReport.php';

class ReportHandler {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // إضافة تقرير طالب
    public function addStudentReport(StudentReport $report) {
        $sql = "INSERT INTO reports (type, student_id, data) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$report->getType(), $report->getStudentId(), $report->getData()]);
        return $this->pdo->lastInsertId();
    }

  
    function generateCourseReports($pdo) {
        // جلب عدد الدورات التي يدرسها كل معلم
        $query = "SELECT t.name AS teacher_name, COUNT(c.id) AS course_count 
                  FROM teachers t 
                  LEFT JOIN courses c ON t.id = c.teacher_id 
                  GROUP BY t.id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // إضافة التقارير إلى جدول reports
        $reportHandler = new ReportHandler($pdo);
        foreach ($results as $result) {
            $data = "المعلم: " . $result['teacher_name'] . " - عدد الدورات: " . $result['course_count'];
            $report = new Report('course', null, null, $result['teacher_id'], $data);
            $reportHandler->addReport($report);
        }
    }

    function generateStudentReports($pdo) {
        // جلب عدد الطلاب المسجلين في كل دورة
        $query = "SELECT c.name AS course_name, COUNT(s.id) AS student_count 
                  FROM courses c 
                  LEFT JOIN students s ON c.id = s.course_id 
                  GROUP BY c.id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // إضافة التقارير إلى جدول reports
        $reportHandler = new ReportHandler($pdo);
        foreach ($results as $result) {
            $data = "دورة: " . $result['course_name'] . " - عدد الطلاب: " . $result['student_count'];
            $report = new Report('student', null, $result['course_id'], null, $data);
            $reportHandler->addReport($report);
        }
    }
    // إضافة تقرير دورة
    public function addCourseReport(CourseReport $report) {
        $sql = "INSERT INTO reports (type, course_id, data) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$report->getType(), $report->getCourseId(), $report->getData()]);
        return $this->pdo->lastInsertId();
    }

    // إضافة تقرير معلم
    public function addTeacherReport(TeacherReport $report) {
        $sql = "INSERT INTO reports (type, teacher_id, data) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$report->getType(), $report->getTeacherId(), $report->getData()]);
        return $this->pdo->lastInsertId();
    }

    // عرض جميع التقارير
    public function getAllReports() {
        $sql = "SELECT * FROM reports";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // حذف تقرير
    public function deleteReport($id) {
        $sql = "DELETE FROM reports WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}
?>