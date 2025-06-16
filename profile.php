<?php
session_start();

require_once 'adminController/config.php';
require_once 'adminController/CourseHandler.php';
require_once 'adminController/Course_videoHandler.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // توجيه إلى صفحة تسجيل الدخول
    exit();
}
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['email'];
$user_name = $_SESSION['name'] ?? 'غير معروف'; // اسم المستخدم من الجلسة


// جلب الدورات المكتملة
$courseHandler = new CourseHandler($pdo);
$completedCourses = $courseHandler->getCompletedCourses($user_id);

// جلب الدورات غير المكتملة
$incompleteCourses = $courseHandler->getIncompleteCourses($user_id);

// جلب الفيديوهات التابعة لكل دورة
$videoHandler = new Course_videoHandler($pdo);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي - منصتنا سطور التعليمية</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* تنسيقات CSS هنا */
        .content {
            padding: 20px;
        }
        .user-info, .courses-section {
            margin-bottom: 30px;
        }
        .user-info h2, .courses-section h2 {
            margin-top: 0;
        }
        .course-list {
            list-style: none;
            padding: 0;
        }
        .course-item {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .course-item h3 {
            margin-top: 0;
        }
        .video-list {
            margin-top: 10px;
            padding-left: 20px;
        }
        .video-list li {
            margin-bottom: 5px;
        }
        .status.completed {
            color: green;
            font-weight: bold;
        }
        .status.incomplete {
            color: orange;
            font-weight: bold;
        }
      

        .profile-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #007bff;
            margin: 0 auto 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .profile-info {
            text-align: center;
        }

        .profile-info p {
            margin: 10px 0;
            font-size: 18px;
            color: #333;
        }
        
    </style>
        <link rel="stylesheet" href="styles.css">

</head>
<body>
    <header>
        <div class="navbar">
            <h1>منصتنا سطور التعليمية</h1>
            <nav>
                <ul>
                    <li><a href="index.php">الصفحة الرئيسية</a></li>
                    <li><a href="about.html">من نحن</a></li>
                    <li><a href="courses.php">الدورات</a></li>
                    <li><a href="blog.php">المدونة</a></li>
                    <li><a href="contact.php">اتصل بنا</a></li>
                    <li><a href="profile.php">الملف الشخصي</a></li>
                    <li><a href="completed-courses.php">الدورات المكتملة</a></li>
                    <li><a href="incomplete-courses.php">الدورات غير المكتملة</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="content">
            <div class="user-info">
                <h2>الملف الشخصي</h2>
             </div>
            <div class="profile-container">
        <!-- دائرة صورة المستخدم -->
        <div class="profile-picture">
            <?= substr($user_name, 0, length: 1) ?> <!-- الحرف الأول من اسم المستخدم -->
        </div>

        <!-- معلومات المستخدم -->
        <div class="profile-info">
        <p>اسم المستخدم: <?= htmlspecialchars($_SESSION['name'] ?? 'غير معروف') ?></p>
                <p>البريد الإلكتروني: <?= htmlspecialchars($user_email) ?></p>
           </div>
    </div>

            <div class="courses-section">
                <h2>الدورات المكتملة</h2>
                <ul class="course-list">
                    <?php if (!empty($completedCourses)): ?>
                        <?php foreach ($completedCourses as $course): ?>
                            <li class="course-item">
                                <h3><?= htmlspecialchars($course['name']) ?></h3>
                                <p><?= htmlspecialchars($course['description']) ?></p>
                                <ul class="video-list">
                                    <?php
                                    $videos = $videoHandler->getVideosByCourse($course['id']);
                                    foreach ($videos as $video):
                                        ?>
                                        <li>
                                            <?= htmlspecialchars($video['title']) ?> - <span class="status completed">✔️ مكتمل</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>لا توجد دورات مكتملة.</p>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="courses-section">
                <h2>الدورات غير المكتملة</h2>
                <ul class="course-list">
                    <?php if (!empty($incompleteCourses)): ?>
                        <?php foreach ($incompleteCourses as $course): ?>
                            <li class="course-item">
                                <h3><?= htmlspecialchars($course['name']) ?></h3>
                                <p><?= htmlspecialchars($course['description']) ?></p>
                                <ul class="video-list">
                                    <?php
                                    $videos = $videoHandler->getVideosByCourse($course['id']);
                                    foreach ($videos as $video):
                                        ?>
                                        <li>
                                            <?= htmlspecialchars($video['title']) ?> - <span class="status incomplete">⌛ غير مكتمل</span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>لا توجد دورات غير مكتملة.</p>
                    <?php endif; ?>
                </ul>
            </div>
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