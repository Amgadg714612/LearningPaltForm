<?php

require_once 'adminController/config.php';
require_once 'adminController/CourseHandler.php';
require_once 'adminController/Course_videoHandler.php';
session_start();
$courseHandler = new CourseHandler($pdo);
$videoHandler = new Course_videoHandler($pdo);

// جلب جميع الدورات
$courses = $courseHandler->getAllCourses();

// جلب أول فيديو لكل دورة
$uniqueCourses = [];
foreach ($courses as $course) {
    // التأكد من أن الدورة لم يتم عرضها من قبل
    if (!isset($uniqueCourses[$course['id']])) {
        $videos = $videoHandler->getVideosByCourse($course['id']);
        $course['first_video'] = !empty($videos) ? $videos[0] : null;
        $uniqueCourses[$course['id']] = $course;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدورات - منصتنا سطور التعليمية</title>
    <style>
        /* تنسيقات CSS هنا */
        .course-list {
            list-style: none;
            padding: 0;
        }
        .course-list li {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .course-list h3 {
            margin-top: 0;
        }
        .video-container {
            margin-top: 10px;
        }
        .video-container iframe {
            width: 100%;
            height: 315px;
            border: none;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <header>
        <div class="navbar">
            <h1>منصتنا سطور التعليمية</h1>
            <nav>
                <ul>
                    <li><a href="index.php">الصفحة الرئيسية</a></li>
                    <li><a href="about.php">من نحن</a></li>
                    <li><a href="courses.php">الدورات</a></li>
                    <li><a href="blog.php">المدونة</a></li>
                    <li><a href="contact.html">اتصل بنا</a></li>
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
            <h2>الدورات</h2>
            <ul class="course-list">
                <?php foreach ($uniqueCourses as $course): ?>
                    <li>
                        <h3><?= $course['name'] ?></h3>
                        <p><?= $course['description'] ?></p>
                        <?php if ($course['first_video']): ?>
                            <div class="video-container">
                                <h4>أول فيديو للدورة:</h4>
                                <iframe src="<?= $course['first_video']['video_url'] ?>" allowfullscreen></iframe>
                            </div>
                        <?php else: ?>
                            <p>لا يوجد فيديوهات لهذه الدورة بعد.</p>
                        <?php endif; ?>
                        <!-- زر التفاصيل -->
                        <a href="course-details.php?id=<?= $course['id'] ?>" class="btn">التفاصيل</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 منصتنا سطور التعليمية. جميع الحقوق محفوظة.</p>
            <p>تواصل معنا عبر: abdulrahmankalaed81@gmail.com</p>
        </div>
    </footer>
</body>
</html>