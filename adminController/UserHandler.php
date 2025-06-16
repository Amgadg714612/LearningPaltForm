<?php
require_once 'config.php'; 
require_once 'user.php';
class UserHandler {
    private $pdo;

    // Constructor
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // دالة للتحقق من صحة بيانات تسجيل الدخول
    public function login($email, $password) {
        // استعلام للبحث عن المستخدم باستخدام البريد الإلكتروني
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return new User(id: $user['id'], email: $user['email'], password: $user['password'],role: $user['role']);
        }
        return null; // إذا فشل تسجيل الدخول
    }
}
?>