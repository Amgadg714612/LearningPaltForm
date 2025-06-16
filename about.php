<?php
require_once 'adminController/config.php';
require_once 'adminController/CourseHandler.php';

session_start(); // بدء الجلسة
// إنشاء كائن من CourseHandler
$courseHandler = new CourseHandler($pdo);
// جلب جميع الدورات من قاعدة البيانات
$courses = $courseHandler->getAllCourses();
require_once 'adminController/CourseHandler.php';
require_once 'adminController/VideoHandler.php'; // سننشئ هذا الكلاس لاحقًا
// إنشاء كائن من CourseHandler
// $courseHandler = new CourseHandler($pdo);
// $course = $courseHandler->getCourseById(5); 
// // إنشاء كائن من VideoHandler
// $videoHandler = new VideoHandler($pdo);
// إنشاء كائن من CourseHandler
$courseHandler = new CourseHandler($pdo);
// جلب جميع الدورات من قاعدة البيانات
$courses = $courseHandler->getAllCourses();
// إنشاء كائن من VideoHandler
$videoHandler = new VideoHandler($pdo);

// // جلب الفيديو المرتبط بالدورة
// $video = $videoHandler->getVideoByCourseId($course['id']);
?>



<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>من نحن - منصتنا سطر التعليمية</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1>منصتنا سطر التعليمية</h1>
            <nav>
                <ul>
                    <li><a href="index.php">الصفحة الرئيسية</a></li>
                    <li><a href="about.php">من نحن</a></li>
                    <li><a href="courses.php">الدورات</a></li>
                    <li><a href="blog.php">المدونة</a></li>
                    <li><a href="contact.php">اتصل بنا</a></li>
                    
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- إذا كان المستخدم قد سجل دخوله، نعرض زر الملف الشخصي -->
                    <li><a href="completed-courses.php">الدورات المكتملة</a></li>
                    <li><a href="incomplete-courses.php">الدورات غير المكتملة</a></li>
                    <li><a href="profile.php" class="btn btn-primary">الملف الشخصي</a></li>
                <?php else: ?>
                    <!-- إذا لم يكن المستخدم قد سجل دخوله، نعرض زر تسجيل الدخول -->
                    <li><a href="login.php" class="btn btn-success">تسجيل الدخول</a></li>
                <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="content">
            <h2>من نحن</h2>
            <p>نحن منصة تعليمية تهدف إلى توفير أفضل الدورات التعليمية لتطوير مهارات الأفراد.</p>
            <p>فريقنا يتكون من خبراء في مختلف المجالات يعملون معًا لتقديم محتوى تعليمي عالي الجودة.</p>
            <p>عبدالرحمن خالد علي مشيخي 202205020</p>
            <p>البدر علي غليسي202203418 </p>
            <p> معاذ حسن هاشمي 202207189</p>
            <a href="https://x.com/LZom0CNlKFL4OQk"> My account on the X
                I’m abdulrahman, a developer & programmer </a>

            <img src = "HHHTTT.jpg" alt = "Test Image" width = "150" height = "100"/>
          
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 منصتنا سطر التعليمية. جميع الحقوق محفوظة.</p>
            <p>تواصل معنا عبر: abdulrahmankalaed81@gmail.com</p>
        </div>
    </footer>
</body>
</html>
