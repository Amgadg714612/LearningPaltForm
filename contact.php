<?php
session_start();

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>اتصل بنا - منصتنا سطور التعليمية</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script>
        function showConfirmation(event) {
            event.preventDefault(); // منع الإرسال الافتراضي
            document.getElementById("confirmationMessage").style.display = "block";
            document.getElementById("contactForm").reset(); // إعادة تعيين النموذج
        }
    </script>
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
            <h2>اتصل بنا</h2>
            <form id="contactForm" action="#" method="post" onsubmit="showConfirmation(event)">
                <label for="name">الاسم:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="message">الرسالة:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
                
                <button type="submit">إرسال</button>
            </form>
            
            <p id="confirmationMessage" style="display: none; color: green; margin-top: 10px;">
                تم إرسال رسالتك بنجاح! سنقوم بالرد عليك قريبًا.
            </p>
        </section>
    </main>
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 منصتنا سطور التعليمية. جميع الحقوق محفوظة.</p>
            <p>تواصل معنا عبر:</p>
            <p>📧 البريد الإلكتروني: <a href="mailto:abdulrahmankalaed81@gmail.com">abdulrahmankalaed81@gmail.com</a></p>
            <p>📞 الهاتف: <a href="tel:+966551698137">+20 123 456 7890</a></p>
            <p>📱 تابعنا على:</p>
            <ul>
                <li><a href="https://facebook.com" target="_blank">فيسبوك</a></li>
                <li><a href="https://twitter.com" target="_blank">تويتر</a></li>
                <li><a href="https://linkedin.com" target="_blank">لينكد إن</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
