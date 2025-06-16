<?php
session_start(); // بدء الجلسة
require_once 'adminController/config.php'; // ملف يحتوي على إعدادات اتصال قاعدة البيانات

$error_message = ''; // رسالة الخطأ

// إذا تم إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'student'; // القيمة الافتراضية هي "طالب"

    // التحقق من وجود مسؤول بالفعل
    if ($role === 'admin') {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = 'admin'");
        $stmt->execute();
        $admin_count = $stmt->fetchColumn();

        if ($admin_count > 0) {
            $error_message = "لا يمكن إنشاء أكثر من مسؤول واحد.";
        }
    }

    // إذا لم يكن هناك خطأ، قم بتسجيل المستخدم
    if (empty($error_message)) {
        // التحقق من أن البريد الإلكتروني غير مستخدم
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $email_exists = $stmt->fetchColumn();

        if ($email_exists) {
            $error_message = "البريد الإلكتروني مستخدم بالفعل.";
        } else {
            // تشفير كلمة المرور
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // إدخال المستخدم في قاعدة البيانات
            $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
            $stmt->execute([
                'email' => $email,
                'password' => $hashed_password,
                'role' => $role
            ]);

            // توجيه المستخدم إلى صفحة تسجيل الدخول
            header('Location: login.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل حساب جديد</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Register Page Specific Styles */
        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            margin: 50px auto;
            animation: fadeIn 1s ease-in-out;
        }

        .register-container h2 {
            color: #27548A;
            margin-bottom: 30px;
            animation: slideIn 0.5s ease-in-out;
        }

        .input-field {
            margin-bottom: 20px;
            text-align: right;
        }

        .input-field label {
            display: block;
            font-size: 1.1em;
            color: #183B4E;
            margin-bottom: 5px;
        }

        .input-field input {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            color: #183B4E;
            transition: border-color 0.3s ease;
        }

        .input-field input:focus {
            border-color: #27548A;
        }

        .register-button {
            width: 100%;
            padding: 10px;
            background-color: #27548A;
            color: white;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .register-button:hover {
            background-color: #183B4E;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 1em;
        }

        .login-link a {
            color: #27548A;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            color: #183B4E;
            text-decoration: underline;
        }

        #error-message {
            margin-top: 15px;
            padding: 10px;
            background-color: #ffebee;
            border-radius: 5px;
            animation: bounceIn 0.5s ease-in-out;
        }
    </style>
</head>
<body>
 
    <main>
        <div class="register-container">
            <h2 id="register-title">تسجيل حساب جديد</h2>
            <form id="registerForm" method="POST" action="register.php">
                <!-- حقل البريد الإلكتروني -->
                <div class="input-field">
                    <label for="email" id="email-label">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" placeholder="أدخل بريدك الإلكتروني" required>
                </div>

                <!-- حقل كلمة المرور -->
                <div class="input-field">
                    <label for="password" id="password-label">كلمة المرور</label>
                    <input type="password" id="password" name="password" placeholder="أدخل كلمة المرور" required>
                </div>

                <!-- زر التسجيل -->
                <button type="submit" class="register-button" id="register-button">تسجيل</button>
            </form>

            <!-- رسالة الخطأ -->
            <?php if (!empty($error_message)): ?>
                <p id="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <!-- رابط تسجيل الدخول -->
            <div class="login-link">
                <p id="login-text">هل لديك حساب بالفعل؟ <a href="login.php" id="login-link">تسجيل الدخول</a></p>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <p>جميع الحقوق محفوظة &copy; <?php echo date('Y'); ?></p>
            <ul>
                <li><a href="#">سياسة الخصوصية</a></li>
                <li><a href="#">شروط الاستخدام</a></li>
                <li><a href="#">اتصل بنا</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>