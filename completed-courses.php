<?php
session_start();

require_once 'adminController/config.php';
require_once 'adminController/CourseHandler.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // توجيه إلى صفحة تسجيل الدخول
    exit();
}

$user_id = $_SESSION['user_id'];

// جلب الدورات المكتملة
$sql = "
    SELECT c.id AS course_id, c.name AS course_name, v.title AS video_title, uv.completed_at
    FROM courses c
    JOIN course_videos v ON c.id = v.course_id
    JOIN user_video_progress uv ON v.id = uv.video_id
    WHERE uv.student_id = ? AND uv.completed = 1
    AND c.id IN (
        SELECT course_id
        FROM course_videos
        GROUP BY course_id
        HAVING COUNT(*) = (
            SELECT COUNT(*)
            FROM user_video_progress
            WHERE student_id = ? AND completed = 1 AND course_id = c.id
        )
    )
    ORDER BY c.id, v.video_number";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $user_id]);
$completedCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدورات المكتملة - منصتنا سطور التعليمية</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* تنسيقات CSS هنا */
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
        .course-item h2 {
            margin-top: 0;
        }
        .completed-courses table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .completed-courses th, .completed-courses td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .completed-courses th {
            background-color: #f1f1f1;
        }
        .status.completed {
            color: green;
            font-weight: bold;
        }
    </style>
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
                    <li><a href="blog.html">المدونة</a></li>
                    <li><a href="contact.html">اتصل بنا</a></li>
                    <li><a href="profile.php">الملف الشخصي</a></li>
                    <li><a href="completed-courses.php">الدورات المكتملة</a></li>
                    <li><a href="incomplete-courses.php">الدورات غير المكتملة</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="content">
            <h2>الدورات المكتملة</h2>
            <ul class="course-list">
                <?php if (!empty($completedCourses)): ?>
                    <?php
                    $currentCourseId = null;
                    foreach ($completedCourses as $index => $course):
                        if ($currentCourseId !== $course['course_id']):
                            if ($currentCourseId !== null): // إغلاق الجدول والدورة السابقة إذا كانت موجودة
                                ?>
                                    </tbody>
                                </table>
                            </li>
                            <?php endif; ?>
                            <li class="course-item">
                                <h3><?= $course['course_name'] ?></h3>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>اسم الفيديو</th>
                                            <th>تاريخ الاكتمال</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php
                            $currentCourseId = $course['course_id'];
                        endif;
                        ?>
                                        <tr>
                                            <td><?= $course['video_title'] ?></td>
                                            <td><?= $course['completed_at'] ?></td>
                                        </tr>
                        <?php
                        // التحقق مما إذا كانت هذه هي الدورة الأخيرة
                        if ($index === count($completedCourses) - 1):
                            ?>
                                    </tbody>
                                </table>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>لا توجد دورات مكتملة.</p>
                <?php endif; ?>
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