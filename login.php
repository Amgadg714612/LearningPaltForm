<?php
session_start(); // بدء الجلسة
require_once 'adminController/UserHandler.php'; // تضمين كلاس UserHandler
// إذا تم إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // إنشاء كائن من UserHandler
    $userHandler = new UserHandler($pdo);
    // محاولة تسجيل الدخول
    $user = $userHandler->login($email, $password);
    if ($user) {
        // تخزين بيانات المستخدم في الجلسة
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['role'] = $user->getrole();
        // توجيه المستخدم بناءً على دوره
        if ($user->getrole() === 'admin') {
            header('Location:adminController/admin.php'); // لوحة تحكم المسؤول
        } else {
            header('Location:index.php'); // لوحة تحكم الطالب
        }
        exit();
    } else {
        // عرض رسالة خطأ
        $error_message = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style> 
          .login-container {
                background-color: white;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 400px;
                text-align: center;
                margin: 50px auto;
            }
            .input-field {
                margin-bottom: 20px;
                text-align: left;
            }
            .input-field label {
                display: block;
                font-size: 1.1em;
                color: #555;
                margin-bottom: 5px;
            }
            .input-field input {
                width: 100%;
                padding: 10px;
                font-size: 1em;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #fff;
                color: #333;
                transition: border-color 0.3s ease;
            }
            .input-field input:focus {
                border-color: #286a99;
            }
            .login-button {
                width: 100%;
                padding: 10px;
                background-color: #286a99;
                color: white;
                font-size: 1.2em;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            .login-button:hover {
                background-color: #1e4d72;
            }
            .register-link {
                display: block;
                text-align: center;
                margin-top: 20px;
                font-size: 1em;
            }
            .register-link a {
                color: #286a99;
                text-decoration: none;
                font-weight: bold;
            }
            .register-link a:hover {
                color: #1e4d72;
            }
    </style>
        <link rel="stylesheet" href="styles.css">

</head>
<body>
    <div class="login-container">
        <h2 id="login-title">تسجيل الدخول</h2>
        <form id="loginForm" method="POST" action="login.php">
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

            <!-- زر تسجيل الدخول -->
            <button type="submit" class="login-button" id="login-button">تسجيل الدخول</button>
        </form>

        <!-- رسالة الخطأ -->
        <?php if (isset($error_message)): ?>
            <p id="error-message" style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <!-- رابط التسجيل -->
        <div class="register-link">
            <p id="register-text">ليس لديك حساب؟ <a href="register.php" id="register-link">إنشاء حساب جديد</a></p>
        </div>
    </div>
</body>
</html>