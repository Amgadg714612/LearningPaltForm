<?php
session_start();

require_once 'adminController/config.php';
require_once 'adminController/EnrollmentHandler.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // توجيه إلى صفحة تسجيل الدخول
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $video_id = $_POST['video_id'];

    // إنشاء كائن EnrollmentHandler
    $enrollmentHandler = new EnrollmentHandler($pdo);

    // تسجيل إكمال الفيديو
    $success = $enrollmentHandler->markVideoAsCompleted($student_id, $course_id, $video_id);

    if ($success) {
        header("Location: course-details.php?id=$course_id&message=تم تسجيل إكمال الفيديو بنجاح");
    } else {
        header("Location: course-details.php?id=$course_id&error=حدث خطأ أثناء تسجيل إكمال الفيديو");
    }
    exit();
}
?>