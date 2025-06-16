<?php
require_once 'config.php';
require_once 'Student.php';

class StudentHandler {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // إضافة طالب جديد
    public function addStudent(Student $student) {
        $sql = "INSERT INTO students (name, email) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student->getName(), $student->getEmail()]);
        return $this->pdo->lastInsertId();
    }

    // تعديل طالب
    public function updateStudent(Student $student) {
        $sql = "UPDATE students SET name = ?, email = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$student->getName(), $student->getEmail(), $student->getId()]);
        return $stmt->rowCount();
    }

    // حذف طالب
    public function deleteStudent($id) {
        $sql = "DELETE FROM students WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    // عرض جميع الطلاب
    public function getAllStudents() {
        $sql = "SELECT * FROM students";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // عرض طالب واحد بواسطة الـ ID
    public function getStudentById($id) {
        $sql = "SELECT * FROM students WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>