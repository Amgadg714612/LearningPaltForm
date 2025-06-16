<?php
require_once 'adminController/config.php';
require_once 'adminController/CourseHandler.php';

session_start(); // بدء الجلسة
// إنشاء كائن من CourseHandler

if($_SESSION != null){
    $userRole= $_SESSION['role'] ;
    if ($userRole === 'admin') {
        header('Location:adminController/admin.php'); // لوحة تحكم المسؤول
    }
}

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
    <title>الصفحة الرئيسية - منصتنا سطور التعليمية</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

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
        <!-- قسم عرض الدورات مع الفيديوهات -->
        <section class="courses">
            <h2>الدورات المتاحة</h2>
            <div class="course-list " >
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <?php
                        // جلب الفيديو المرتبط بالدورة
                        $video = $videoHandler->getVideoByCourseId($course['id']);
                        ?>

                        <div class="course-item card ">
                            <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                            <p><?php echo htmlspecialchars($course['description']); ?></p>
                            <p>تاريخ البدء: <?php echo htmlspecialchars($course['start_date']); ?></p>
                            <p>تاريخ الانتهاء: <?php echo htmlspecialchars($course['end_date']); ?></p>
                            <?php if ($video): ?>
                                <iframe width="560" height="315" src="<?php echo htmlspecialchars($video['video_url']); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <?php else: ?>
                                <p>لا يوجد فيديو متاح لهذه الدورة.</p>
                            <?php endif; ?>
                            <br>
                            <a href="course-details.php?id=<?php echo $course['id']; ?>" class="btn">المزيد من التفاصيل</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>لا توجد دورات متاحة حاليًا.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- قسم عرض الدورات ---> 
        <section class="courses">
            <h2>الدورات المتاحة</h2>
            <div class="course-list">
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="course-item">
                            <h3><?php echo htmlspecialchars($course['name']); ?></h3>
                            <p><?php echo htmlspecialchars($course['description']); ?></p>
                            <p>تاريخ البدء: <?php echo htmlspecialchars($course['start_date']); ?></p>
                            <p>تاريخ الانتهاء: <?php echo htmlspecialchars($course['end_date']); ?></p>
                            <a href="course-details.php?id=<?php echo $course['id']; ?>" class="btn">المزيد من التفاصيل</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>لا توجد دورات متاحة حاليًا.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="features">
            <div class="feature">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>مدربون خبراء</h3>
                <p>تعلم من أفضل المدربين في مجالات مختلفة.</p>
            </div>
            <div class="feature">
                <i class="fas fa-laptop-code"></i>
                <h3>دورات متنوعة</h3>
                <p>اختر من بين مجموعة واسعة من الدورات.</p>
            </div>
            <div class="feature">
                <i class="fas fa-user-graduate">

                </i>
                <h3>شهادات معتمدة</h3>
                <p>احصل على شهادات معترف بها بعد إتمام الدورات.</p>
            </div>
        </section>
        <section class="testimonials">
            <h2>ماذا يقول طلابنا</h2>
            <div class="testimonial">
                <p>"هذه المنصة غيرت حياتي! الدورات ممتازة والمدربون رائعون."</p>
                <span>- محمد</span>
            </div>
            <div class="testimonial">
                <p>"أفضل تجربة تعليمية عبر الإنترنت. أوصي بها للجميع."</p>
                <span>- علياء</span>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 منصتنا سطور التعليمية. جميع الحقوق محفوظة.</p>
            <p>تواصل معنا عبر: info@eduplatform.com</p>
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>