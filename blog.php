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


<?php
require_once 'adminController/config.php';
require_once 'adminController/PostHandler.php';

$postHandler = new PostHandler($pdo);
$posts = $postHandler->getAllPosts();

?>


<!DOCTYPE html>
<html lang="ar">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   
    <title>المدونة - منصتنا سطور التعليمية</title>
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
            <h2>المدونة</h2>
            <ul class="blog-list">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class=" card">
                        <li>
                            <h3>
                                <a href="post-details.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
                            <br>
                            <p>
                                <?php echo htmlspecialchars($post['content']); ?></p>
                            <?php if (!empty($post['image'])): ?>
                                <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <?php endif; ?>
                        
                        </li>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>لا توجد منشورات متاحة حاليًا.</li>
                <?php endif; ?>
            </ul>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <p>&copy; 2024 منصتنا  سطور التعليمية. جميع الحقوق محفوظة.</p>
            <p>تواصل معنا عبر: abdulrahmankalaed81@gmail.com</p>
        </div>
    </footer>
</body>
</html>
