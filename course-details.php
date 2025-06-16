<?php
require_once 'adminController/config.php';
require_once 'adminController/CourseHandler.php';
require_once 'adminController/Course_videoHandler.php';

if (!isset($_GET['id'])) {
    header("Location: courses.php");
    exit();
}

$idvideo=0;
session_start(); // بدء الجلسة

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location:login.php"); // توجيه إلى صفحة تسجيل الدخول
    exit();
}
$course_id = $_GET['id'];
$courseHandler = new CourseHandler($pdo);
$videoHandler = new Course_videoHandler($pdo);

// جلب معلومات الدورة
$course = $courseHandler->getCourseById($course_id);

// جلب الفيديوهات المتاحة للدورة
$videos = $videoHandler->getVideosByCourse($course_id);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $course['name'] ?> - منصتنا سطور التعليمية</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* التنسيق العام */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }

        /* تنسيق صفحة تفاصيل الدورة */
        .course-details {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .course-details img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .video-list {
            list-style: none;
            padding: 0;
        }

        .video-item {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .video-item iframe {
            width: 100%;
            height: 200px;
            border: none;
            border-radius: 5px;
        }

        .video-item h3 {
            margin: 10px 0;
            font-size: 1.2em;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin-top: 10px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* تنسيق الفيديو البارز */
        .video-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .video-popup iframe {
            width: 80%;
            height: 80%;
            border: none;
            border-radius: 10px;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 30px;
            cursor: pointer;
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
                    <li><a href="index.html">الصفحة الرئيسية</a></li>
                    <li><a href="about.html">من نحن</a></li>
                    <li><a href="courses.php">الدورات</a></li>
                    <li><a href="blog.html">المدونة</a></li>
                    <li><a href="contact.html">اتصل بنا</a></li>
                    <li><a href="profile.html">الملف الشخصي</a></li>
                    <li><a href="completed-courses.html">الدورات المكتملة</a></li>
                    <li><a href="incomplete-courses.html">الدورات غير المكتملة</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
    <section class="course-details">
            <h1><?= $course['name'] ?></h1>
            <p><?= $course['description'] ?></p>
            <?php
            if ($course['image']!=null) {
              echo "<img src=".$course['image']+"alt="+$course['name']+">";
                
            }
            ?>
            
            <h2>الفيديوهات المتاحة</h2>
            <ul class="video-list">
                <?php if (!empty($videos)): ?>
                    <?php foreach ($videos as $video): ?>
                        <li class="video-item">
                            <h3><?= $video['title'] ?></h3>
                            <?php
                            $idvideo=$video['id'];
                            if ($video['video_url']!=null) {
                                echo $video['video_url'];
                              
                            }
                            ?>
                            <iframe frameborder="1" src="<?php echo htmlspecialchars($video['video_url']);?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"  allowfullscreen> </iframe>
                            <button class="btn" onclick="checkLoginAndShowVideo('<?= $video['video_url'] ?>', <?= $video['id'] ?>)">عرض الدرس</button>
                            <?php if (!empty($video['download_url'])): ?>
                                <a href="<?= $video['download_url'] ?>" class="download-link" download>تحميل الفيديو</a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>لا يوجد فيديوهات لهذه الدورة بعد.</p>
                <?php endif; ?>
            </ul>
        </section>
    </main>

    <!-- نافذة الفيديو البارزة -->
    <div id="videoPopup" class="video-popup">
        <span class="close-btn" onclick="closeVideo( <?=$idvideo ?>)">&times;</span>
        <iframe id="popupIframe" src="" allowfullscreen></iframe>
    </div>

      <!-- نموذج مخفي لتسجيل إكمال الفيديو -->
      <form id="markVideoForm" action="mark_video_completed.php" method="POST" style="display: none;">
        <input type="hidden" name="student_id" value="<?= $_SESSION['user_id'] ?>">
        <input type="hidden" name="course_id" value="<?= $course_id ?>">
        <input type="hidden" name="video_id" id="videoIdInput">
    </form>
    
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 منصتنا سطور التعليمية. جميع الحقوق محفوظة.</p>
            <p>تواصل معنا عبر: abdulrahmankalaed81@gmail.com</p>
        </div>
    </footer>

    <script>
        // حالة تسجيل الدخول (يتم تمريرها من PHP)
        const loggedIn = <?= $_SESSION["user_id"]? 'true' : 'false' ?>;
        // التحقق من تسجيل الدخول وعرض الفيديو
      var  videoshow=0;
        function checkLoginAndShowVideo(videoUrl, videoId) {
            if (loggedIn) {
                // إذا كان المستخدم مسجل الدخول، عرض الفيديو
                showVideo(videoUrl,videoId);
                videoshow=videoId;
                // تسجيل إكمال الفيديو
              // الاستماع إلى حدث انتهاء الفيديو
             
            } else {
                // إذا لم يكن مسجل الدخول، توجيهه إلى صفحة تسجيل الدخول
                window.location.href = 'login.php';
            }
        }

        // عرض الفيديو في نافذة منبثقة
        function showVideo(videoUrl,videoId) {
            const popup = document.getElementById('videoPopup');
                const iframe = document.getElementById('popupIframe');
                iframe.src = videoUrl;
                popup.style.display = 'flex';
            iframe.onended = () => {
                    markVideoAsCompleted(videoshow); 
                    alert("إكمال الفيدي");
                };
        }


        // إغلاق نافذة الفيديو
        function closeVideo(videoId) {
            const popup = document.getElementById('videoPopup');
            const iframe = document.getElementById('popupIframe');
            iframe.src = '';
            popup.style.display = 'none';
            alert(videoshow);
            markVideoAsCompleted(videoshow); 

        }

        // تسجيل إكمال الفيديو
        function markVideoAsCompleted(videoId) {
    const studentId = <?= $_SESSION['user_id'] ?>;
    const courseId = <?= $course_id ?>;
      document.getElementById('videoIdInput').value = videoId;
         // إرسال النموذج تلقائيًا
document.getElementById('markVideoForm').submit();
}
    </script>
</body>
</html>