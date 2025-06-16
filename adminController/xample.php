<?php
require 'config.php';

// مثال لإضافة دورة جديدة
$stmt = $pdo->prepare("INSERT INTO courses (name, description, teacher_id, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
$stmt->execute(['دورة الرياضيات', 'وصف الدورة', 1, '2023-10-01', '2023-12-01']);

echo "تمت إضافة الدورة بنجاح!";
?>