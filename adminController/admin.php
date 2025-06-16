<?php

// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//   header('Location:login.php'); // توجيه المستخدم إلى صفحة تسجيل الدخول
//   exit();
// }
require_once 'CourseHandler.php';
require_once 'Course.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_course'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $teacher_id = $_POST['teacher_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $course = new Course($name, $description, $teacher_id, $start_date, $end_date);
    $courseHandler = new CourseHandler($pdo);
    $courseId = $courseHandler->addCourse($course);

    if ($courseId) {
        echo "<script>alert('تمت إضافة الدورة بنجاح!');</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء إضافة الدورة!');</script>";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_course'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $teacher_id = $_POST['teacher_id'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];

  $course = new Course($name, $description, $teacher_id, $start_date, $end_date, $id);
  $courseHandler = new CourseHandler($pdo);
  $rowsAffected = $courseHandler->updateCourse($course);

  if ($rowsAffected) {
      echo "<script>alert('تم تعديل الدورة بنجاح!');</script>";
  } else {
      echo "<script>alert('حدث خطأ أثناء تعديل الدورة!');</script>";
  }
}

$courseHandler = new CourseHandler($pdo);
$courses = $courseHandler->getAllCourses();
require_once 'CourseContentHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_content'])) {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $courseContent = new CourseContent($course_id, $title, $content);
    $contentHandler = new CourseContentHandler($pdo);
    $contentId = $contentHandler->addContent($courseContent);

    if ($contentId) {
        echo "<script>alert('تمت إضافة المحتوى بنجاح!');</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء إضافة المحتوى!');</script>";
    }
}
require_once 'CourseContentHandler.php';

if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];
    $contentHandler = new CourseContentHandler($pdo);
    $contents = $contentHandler->getContentByCourseId($course_id);
}

if (isset($_GET['action']) && $_GET['action'] === 'delete_content' && isset($_GET['id'])) {
  $content_id = $_GET['id'];
  $course_id = $_GET['course_id'];

  $contentHandler = new CourseContentHandler($pdo);
  $rowsAffected = $contentHandler->deleteContent($content_id);

  if ($rowsAffected) {
      echo "<script>alert('تم حذف المحتوى بنجاح!');</script>";
      echo "<script>window.location.href = '?course_id=$course_id';</script>";
  } else {
      echo "<script>alert('حدث خطأ أثناء حذف المحتوى!');</script>";
  }
}
if (isset($_GET['action']) && $_GET['action'] === 'delete_content' && isset($_GET['id'])) {
  $content_id = $_GET['id'];
  $course_id = $_GET['course_id'];

  $contentHandler = new CourseContentHandler($pdo);
  $rowsAffected = $contentHandler->deleteContent($content_id);

  if ($rowsAffected) {
      echo "<script>alert('تم حذف المحتوى بنجاح!');</script>";
      echo "<script>window.location.href = '?course_id=$course_id';</script>";
  } else {
      echo "<script>alert('حدث خطأ أثناء حذف المحتوى!');</script>";
  }
}

// عرض الدورات المتاحة
$courseHandler = new CourseHandler($pdo);
$courses = $courseHandler->getAllCourses();

// عرض محتوى الدورة المحددة
if (isset($_GET['course_id'])) {
  $course_id = $_GET['course_id'];
  $contentHandler = new CourseContentHandler($pdo);
  $contents = $contentHandler->getContentByCourseId($course_id);
}


require_once 'Student.php';
require_once 'StudentHandler.php';

// معالجة إضافة طالب جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $student = new Student($name, $email);
    $studentHandler = new StudentHandler($pdo);
    $studentId = $studentHandler->addStudent($student);

    if ($studentId) {
        echo "<script>alert('تمت إضافة الطالب بنجاح!');</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء إضافة الطالب!');</script>";
    }
}

// معالجة حذف طالب
if (isset($_GET['action']) && $_GET['action'] === 'delete_student' && isset($_GET['id'])) {
    $student_id = $_GET['id'];

    $studentHandler = new StudentHandler($pdo);
    $rowsAffected = $studentHandler->deleteStudent($student_id);

    if ($rowsAffected) {
        echo "<script>alert('تم حذف الطالب بنجاح!');</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء حذف الطالب!');</script>";
    }
}

// عرض جميع الطلاب
$studentHandler = new StudentHandler($pdo);
$students = $studentHandler->getAllStudents();



require_once 'Post.php';
require_once 'PostHandler.php';
// معالجة إضافة منشور جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $post = new Post($title, $content);
    $postHandler = new PostHandler($pdo);
    $postId = $postHandler->addPost($post);

    if ($postId) {
        echo "<script>alert('تمت إضافة المنشور بنجاح!');</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء إضافة المنشور!');</script>";
    }
}

// معالجة حذف منشور
if (isset($_GET['action']) && $_GET['action'] === 'delete_post' && isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $postHandler = new PostHandler($pdo);
    $rowsAffected = $postHandler->deletePost($post_id);

    if ($rowsAffected) {
        echo "<script>alert('تم حذف المنشور بنجاح!');</script>";
    } else {
        echo "<script>alert('حدث خطأ أثناء حذف المنشور!');</script>";
    }
}

// عرض جميع المنشورات
$postHandler = new PostHandler($pdo);
$posts = $postHandler->getAllPosts();

require 'Report.php';
require 'ReportHandler.php';


// معالجة حذف تقرير
if (isset($_GET['action']) && $_GET['action'] === 'delete_report' && isset($_GET['id'])) {
  $report_id = $_GET['id'];

  $reportHandler = new ReportHandler($pdo);
  $rowsAffected = $reportHandler->deleteReport($report_id);

  if ($rowsAffected) {
      echo "<script>alert('تم حذف التقرير بنجاح!');</script>";
  } else {
      echo "<script>alert('حدث خطأ أثناء حذف التقرير!');</script>";
  }
}

// عرض جميع التقارير
$reportHandler = new ReportHandler($pdo);
$reports = $reportHandler->getAllReports();


require_once 'CourseHandler.php';
require_once 'CourseVideo.php';
require_once 'Course_videoHandler.php';
// إنشاء كائنات للتعامل مع الدورات والفيديوهات
$courseHandler = new CourseHandler($pdo);
$videoHandler = new Course_videoHandler($pdo);

// جلب قائمة الدورات والفيديوهات
$courses = $courseHandler->getAllCourses();
$videos = $videoHandler->getAllVideos();

// معالجة إضافة فيديو
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_video'])) {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $video_url = $_POST['video_url'];

    $video = new Course_video($course_id, null, $title, $video_url);
    $videoHandler->addVideo($video);

    // إعادة توجيه لتجنب إعادة إرسال النموذج
    header("Location: admin.php");
    exit();
}

// معالجة تعديل فيديو
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_video'])) {
    $video_id = $_POST['video_id'];
    $title = $_POST['title'];
    $video_url = $_POST['video_url'];

    $videoHandler->updateVideo($video_id, $title, $video_url);

    // إعادة توجيه لتجنب إعادة إرسال النموذج
    header("Location: admin.php");
    exit();
}

// معالجة حذف فيديو
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_video'])) {
    $video_id = $_POST['video_id'];

    $videoHandler->deleteVideo($video_id);

    // إعادة توجيه لتجنب إعادة إرسال النموذج
    header("Location: admin.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة تحكم المسؤول - منصة تعليمية</title>
  <style>
    body {
      margin: 0;
      font-family: 'Tajawal', sans-serif;
      background-color: rgb(221, 235, 157); /* لون الخلفية العام */
      direction: rtl;
    }

    /* الهيدر */
    .header {
      background-color: rgb(20, 61, 96); /* لون الهيدر */
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* شريط التنقل العلوي */
    .navbar {
      background-color: rgb(235, 91, 0); /* لون الشريط العلوي */
      color: white;
      padding: 10px;
      display: flex;
      justify-content: space-around;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .navbar button {
      background-color: transparent;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .navbar button:hover {
      background-color: rgb(200, 70, 0); /* لون عند التمرير */
    }

    .navbar button.active {
      background-color: rgb(160, 200, 120); /* لون الزر النشط */
    }

    /* الحاوية الرئيسية */
    .container {
      display: flex;
      height: calc(100vh - 120px); /* تعديل الارتفاع ليتناسب مع الهيدر والشريط العلوي */
    }

    /* القائمة الجانبية */
    .sidebar {
      width: 250px;
      background-color: rgb(160, 200, 120); /* لون الخلفية الجانبية */
      color: white;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 15px;
      box-shadow: 2px 0 6px rgba(0, 0, 0, 0.1);
    }

    .sidebar button {
     
      background-color: transparent;
      color: white;
      border: none;
      padding: 10px 15px;
      margin: 10px;
      align-items: baseline;
      text-align: right;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
      border-radius: 8px;
    }

    .sidebar button:hover {
      background-color: rgb(20, 61, 96); /* لون عند التمرير */
    }

    .sidebar button.active {
      background-color: rgb(235, 91, 0); /* لون الزر النشط */
    }

    .sidebar .logout-btn {
      margin-top: auto;
      background-color: rgb(235, 91, 0); /* لون زر تسجيل الخروج */
      color: white;
      font-size: 18px;
    }

    .sidebar .logout-btn:hover {
      background-color: rgb(200, 70, 0); /* لون عند التمرير */
    }

    /* المحتوى الرئيسي */
    .main-content {
      flex-grow: 1;
      padding: 30px;
      overflow-y: auto;
      background-color: rgb(221, 235, 157); /* لون خلفية المحتوى */
    }

    .card {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card h2 {
      font-size: 22px;
      margin-bottom: 15px;
      color: rgb(20, 61, 96); /* لون العنوان */
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
      color: rgb(20, 61, 96); /* لون النص */
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 16px;
    }

    .btn {
      display: inline-block;
      background-color: rgb(235, 91, 0); /* لون الأزرار */
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
      text-align: center;
    }

    .btn:hover {
      background-color: rgb(200, 70, 0); /* لون عند التمرير */
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .table th,
    .table td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ddd;
    }

    .table th {
      background-color: rgb(20, 61, 96); /* لون رأس الجدول */
      color: white;
    }

    .table tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>

<!-- الهيدر -->
<div class="header">
  لوحة تحكم المسؤول - منصة تعليمية
</div>

<!-- شريط التنقل العلوي -->
<div class="navbar">
  <button class="active" onclick="showSection('manage-courses')">إدارة الدورات</button>
  <button onclick="showSection('manage-students')">إدارة الطلاب</button>
  <button onclick="showSection('manage-teachers')">إدارة المعلمين</button>
  <button onclick="showSection('manage-course-content')">إدارة محتوى الدورات</button>
  <button onclick="showSection('manage-blog')">إدارة المدونة</button>
  <button onclick="showSection('view-reports')">إدارة التقارير</button>
</div>

<!-- الحاوية الرئيسية -->
<div class="container">
  <!-- القائمة الجانبية -->
  <div class="sidebar" id="sidebar">
    <!-- العمليات الخاصة بإدارة الدورات -->
    <div id="courses-actions" class="sidebar-section">
      <button onclick="showSubSection('add-course')">إضافة دورة</button>
      <button onclick="showSubSection('edit-course')">تعديل دورة</button>
      <button onclick="showSubSection('view-courses')">عرض الدورات المتاحة</button>
      <button onclick="showSubSection('add-course-content')">إضافة محتوى الدورة</button>
      <button onclick="showSubSection('view-course-content')"> محتوى الدورة</button>

    </div>

    <!-- العمليات الخاصة بإدارة الطلاب -->
    <div id="students-actions" class="sidebar-section" style="display: none;">
      <button onclick="showSubSection('add-student')">إضافة طالب</button>
      <button onclick="showSubSection('edit-student')">تعديل طالب</button>
      <button onclick="showSubSection('view-students')">عرض الطلاب</button>
    </div>

    <!-- العمليات الخاصة بإدارة المعلمين -->
    <div id="teachers-actions" class="sidebar-section" style="display: none;">
      <button onclick="showSubSection('add-teacher')">إضافة معلم</button>
      <button onclick="showSubSection('edit-teacher')">تعديل معلم</button>
      <button onclick="showSubSection('view-teachers')">عرض المعلمين</button>
    </div>

    <!-- العمليات الخاصة بإدارة محتوى الدورات -->
    <div id="course-content-actions" class="sidebar-section" style="display: none;">
      <button onclick="showSubSection('add-video')">إضافة فيديو</button>
      <button onclick="showSubSection('edit-video')">تعديل فيديو</button>
      <button onclick="showSubSection('delete-video')">حذف فيديو</button>
      <button onclick="showSubSection('view-videos')">عرض الفيديوهات</button>
    </div>

    <!-- العمليات الخاصة بإدارة المدونة -->
    <div id="blog-actions" class="sidebar-section" style="display: none;">
      <button onclick="showSubSection('add-post')">إضافة منشور</button>
      <button onclick="showSubSection('edit-post')">تعديل منشور</button>
      <button onclick="showSubSection('delete-post')">حذف منشور</button>
      <button onclick="showSubSection('view-posts')">عرض المنشورات</button>
    </div>

    <!-- العمليات الخاصة بإدارة التقارير -->
    <div id="reports-actions" class="sidebar-section" style="display: none;">
      <button onclick="showSubSection('view-student-reports')">تقارير الطلاب</button>
      <button onclick="showSubSection('view-course-reports')">تقارير الدورات</button>
      <button onclick="showSubSection('view-teacher-reports')">تقارير المعلمين</button>
    </div>

    <!-- زر تسجيل الخروج -->
    <button class="logout-btn" onclick="logout()">تسجيل الخروج</button>
  </div>

  <!-- المحتوى الرئيسي -->
  <div class="main-content">
    <!-- محتوى إدارة الدورات -->
    <div id="manage-courses" class="card">
      <h2>إدارة الدورات</h2>
      <div id="add-course" class="sub-section">
    <h3>إضافة دورة جديدة</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label>اسم الدورة</label>
            <input type="text" name="name" placeholder="أدخل اسم الدورة" required>
        </div>
        <div class="form-group">
            <label>وصف الدورة</label>
            <textarea name="description" placeholder="أدخل وصف الدورة" required></textarea>
        </div>
        <div class="form-group">
            <label>المعلم المسؤول</label>
            <select name="teacher_id" required>
                <option value="1">المعلم 1</option>
                <option value="2">المعلم 2</option>
            </select>
        </div>
        <div class="form-group">
            <label>تاريخ البدء</label>
            <input type="date" name="start_date" required>
        </div>
        <div class="form-group">
            <label>تاريخ الانتهاء</label>
            <input type="date" name="end_date" required>
        </div>
        <button type="submit" name="add_course" class="btn">إضافة الدورة</button>
    </form>
</div>

<div id="edit-course" class="sub-section" style="display: none;">
    <h3>تعديل دورة</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label>اختر الدورة</label>
            <select name="id" required>
                <?php foreach ($courses as $course): ?>
                    <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>اسم الدورة</label>
            <input type="text" name="name" placeholder="أدخل اسم الدورة" required>
        </div>
        <div class="form-group">
            <label>وصف الدورة</label>
            <textarea name="description" placeholder="أدخل وصف الدورة" required></textarea>
        </div>
        <div class="form-group">
            <label>المعلم المسؤول</label>
            <select name="teacher_id" required>
                <option value="1">المعلم 1</option>
                <option value="2">المعلم 2</option>
            </select>
        </div>
        <div class="form-group">
            <label>تاريخ البدء</label>
            <input type="date" name="start_date" required>
        </div>
        <div class="form-group">
            <label>تاريخ الانتهاء</label>
            <input type="date" name="end_date" required>
        </div>
        <button type="submit" name="edit_course" class="btn">تعديل الدورة</button>
    </form>
</div>

      <div id="view-courses" class="sub-section" style="display: none;">
    <h3>عرض الدورات المتاحة</h3>
    <table class="table">
        <thead>
            <tr>
                <th>اسم الدورة</th>
                <th>المعلم</th>
                <th>تاريخ البدء</th>
                <th>تاريخ الانتهاء</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo $course['name']; ?></td>
                    <td><?php echo $course['teacher_id']; ?></td>
                    <td><?php echo $course['start_date']; ?></td>
                    <td><?php echo $course['end_date']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<div id="add-course-content" class="sub-section" style="display: none;">
    <h3>إضافة محتوى الدورة</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label>اختر الدورة</label>
            <select name="course_id" required>
                <?php
                $courseHandler = new CourseHandler($pdo);
                $courses = $courseHandler->getAllCourses();
                foreach ($courses as $course): ?>
                    <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>عنوان المحتوى</label>
            <input type="text" name="title" placeholder="أدخل عنوان المحتوى" required>
        </div>
        <div class="form-group">
            <label>المحتوى</label>
            <textarea name="content" placeholder="أدخل محتوى الدورة" required></textarea>
        </div>
        <button type="submit" name="add_content" class="btn">إضافة المحتوى</button>
    </form>
</div>
<!-- 
<div id="view-course-content" class="sub-section" style="display: none;">
    <h3>عرض محتوى الدورة</h3>
    <table class="table">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>المحتوى</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($contents)): ?>
                <?php foreach ($contents as $content): ?>
                    <tr>
                        <td><?php echo $content['title']; ?></td>
                        <td><?php echo $content['content']; ?></td>
                        <td>
                            <button class="btn">تعديل</button>
                            <button class="btn" style="background-color: #e53e3e;">حذف</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">لا يوجد محتوى لهذه الدورة.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div> -->

<div id="select-course" class="sub-section">
        <h3>اختر الدورة</h3>
        <form method="GET" action="">
            <div class="form-group">
                <label>اختر الدورة</label>
                <select name="course_id" required>
                    <option value="">-- اختر دورة --</option>
                    <?php foreach ($courses as $course): ?>
                        <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn">عرض المحتوى</button>
        </form>
    </div>

    
    <div id="view-course-content" class="sub-section" style="display: <?php echo isset($_GET['course_id']) ? 'block' : 'none'; ?>;">
        <h3>عرض محتوى الدورة</h3>

        <!-- قسم اختيار الدورة -->
        <div id="select-course" class="sub-section">
            <h3>اختر الدورة</h3>
            <form method="GET" action="">
                <div class="form-group">
                    <label>اختر الدورة</label>
                    <select name="course_id" required>
                        <option value="">-- اختر دورة --</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo $course['id']; ?>" <?php echo isset($_GET['course_id']) && $_GET['course_id'] == $course['id'] ? 'selected' : ''; ?>>
                                <?php echo $course['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn">عرض المحتوى</button>
            </form>
        </div>

        <!-- عرض محتوى الدورة المحددة -->
        <?php if (isset($_GET['course_id'])): ?>
            <?php if (!empty($contents)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>المحتوى</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contents as $content): ?>
                            <tr>
                                <td><?php echo $content['title']; ?></td>
                                <td><?php echo $content['content']; ?></td>
                                <td>
                                    <a href="?action=delete_content&id=<?php echo $content['id']; ?>&course_id=<?php echo $course_id; ?>" class="btn" style="background-color: #e53e3e;">حذف</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>لا يوجد محتوى لهذه الدورة.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    </div>

    <!-- محتوى إدارة الطلاب -->
    <!-- <div id="manage-students" class="card" style="display: none;">
      <h2>إدارة الطلاب</h2>
      <div id="add-student" class="sub-section">
        <h3>إضافة طالب</h3>
        <div class="form-group">
          <label>اسم الطالب</label>
          <input type="text" placeholder="أدخل اسم الطالب">
        </div>
        <button class="btn">إضافة الطالب</button>
      </div>

      <div id="edit-student" class="sub-section" style="display: none;">
        <h3>تعديل طالب</h3>
        <div class="form-group">
          <label>اختر الطالب</label>
          <select>
            <option value="1">محمد أحمد</option>
            <option value="2">علي محمود</option>
          </select>
        </div>
        <button class="btn">تعديل الطالب</button>
      </div>

      <div id="view-students" class="sub-section" style="display: none;">
        <h3>عرض الطلاب</h3>
        <table class="table">
          <thead>
            <tr>
              <th>اسم الطالب</th>
              <th>البريد الإلكتروني</th>
              <th>الدورات المسجلة</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>محمد أحمد</td>
              <td>mohamed@example.com</td>
              <td>دورة الرياضيات</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> -->
    <div id="manage-students" class="card" style="display: none;">
        <h2>إدارة الطلاب</h2>

        <!-- إضافة طالب جديد -->
        <div id="add-student" class="sub-section">
            <h3>إضافة طالب جديد</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>اسم الطالب</label>
                    <input type="text" name="name" placeholder="أدخل اسم الطالب" required>
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" placeholder="أدخل البريد الإلكتروني" required>
                </div>
                <button type="submit" name="add_student" class="btn">إضافة الطالب</button>
            </form>
        </div>

        <!-- عرض جميع الطلاب -->
        <div id="view-students" class="sub-section">
            <h3>عرض الطلاب</h3>
            <?php if (!empty($students)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>اسم الطالب</th>
                            <th>البريد الإلكتروني</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo $student['name']; ?></td>
                                <td><?php echo $student['email']; ?></td>
                                <td>
                                    <a href="?action=delete_student&id=<?php echo $student['id']; ?>" class="btn" style="background-color: #e53e3e;">حذف</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>لا يوجد طلاب مسجلين.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- محتوى إدارة المعلمين -->
    <div id="manage-teachers" class="card" style="display: none;">
      <h2>إدارة المعلمين</h2>
      <div id="add-teacher" class="sub-section">
        <h3>إضافة معلم</h3>
        <div class="form-group">
          <label>اسم المعلم</label>
          <input type="text" placeholder="أدخل اسم المعلم">
        </div>
        <button class="btn">إضافة المعلم</button>
      </div>

      <div id="edit-teacher" class="sub-section" style="display: none;">
        <h3>تعديل معلم</h3>
        <div class="form-group">
          <label>اختر المعلم</label>
          <select>
            <option value="1">علي محمود</option>
            <option value="2">محمد أحمد</option>
          </select>
        </div>
        <button class="btn">تعديل المعلم</button>
      </div>

      <div id="view-teachers" class="sub-section" style="display: none;">
        <h3>عرض المعلمين</h3>
        <table class="table">
          <thead>
            <tr>
              <th>اسم المعلم</th>
              <th>البريد الإلكتروني</th>
              <th>الدورات التي يدرسها</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>علي محمود</td>
              <td>ali@example.com</td>
              <td>دورة الرياضيات</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- محتوى إدارة محتوى الدورات -->
    <!-- <div id="manage-course-content" class="card" style="display: none;">
      <h2>إدارة محتوى الدورات</h2>
      <div id="add-video" class="sub-section">
        <h3>إضافة فيديو</h3>
        <div class="form-group">
          <label>اختر الدورة</label>
          <select>
            <option value="1">دورة الرياضيات</option>
            <option value="2">دورة العلوم</option>
          </select>
        </div>
        <div class="form-group">
          <label>عنوان الفيديو</label>
          <input type="text" placeholder="أدخل عنوان الفيديو">
        </div>
        <div class="form-group">
          <label>رابط الفيديو</label>
          <input type="text" placeholder="أدخل رابط الفيديو">
        </div>
        <button class="btn">إضافة الفيديو</button>
      </div>

      <div id="edit-video" class="sub-section" style="display: none;">
        <h3>تعديل فيديو</h3>
        <div class="form-group">
          <label>اختر الفيديو</label>
          <select>
            <option value="1">فيديو 1</option>
            <option value="2">فيديو 2</option>
          </select>
        </div>
        <button class="btn">تعديل الفيديو</button>
      </div>

      <div id="delete-video" class="sub-section" style="display: none;">
        <h3>حذف فيديو</h3>
        <div class="form-group">
          <label>اختر الفيديو</label>
          <select>
            <option value="1">فيديو 1</option>
            <option value="2">فيديو 2</option>
          </select>
        </div>
        <button class="btn" style="background-color: #e53e3e;">حذف الفيديو</button>
      </div>

      <div id="view-videos" class="sub-section" style="display: none;">
        <h3>عرض الفيديوهات</h3>
        <table class="table">
          <thead>
            <tr>
              <th>عنوان الفيديو</th>
              <th>الدورة</th>
              <th>رابط الفيديو</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>فيديو 1</td>
              <td>دورة الرياضيات</td>
              <td><a href="#">رابط الفيديو</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> -->
    <div id="manage-course-content" class="card">
        <h2>إدارة محتوى الدورات</h2>
        
        <!-- إضافة فيديو -->
        <div id="add-video" class="sub-section">
            <h3>إضافة فيديو</h3>
            <form method="POST" action="admin.php">
                <div class="form-group">
                    <label>اختر الدورة</label>
                    <select name="course_id">
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course['id'] ?>"><?= $course['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>عنوان الفيديو</label>
                    <input type="text" name="title" placeholder="أدخل عنوان الفيديو">
                </div>
                <div class="form-group">
                    <label>رابط الفيديو</label>
                    <input type="text" name="video_url" placeholder="أدخل رابط الفيديو">
                </div>
                <button type="submit" name="add_video" class="btn">إضافة الفيديو</button>
            </form>
        </div>

        <!-- تعديل فيديو -->
        <div id="edit-video" class="sub-section">
            <h3>تعديل فيديو</h3>
            <form method="POST" action="admin.php">
                <div class="form-group">
                    <label>اختر الفيديو</label>
                    <select name="video_id">
                        <?php foreach ($videos as $video): ?>
                            <option value="<?= $video['id'] ?>"><?= $video['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>عنوان الفيديو</label>
                    <input type="text" name="title" placeholder="أدخل العنوان الجديد">
                </div>
                <div class="form-group">
                    <label>رابط الفيديو</label>
                    <input type="text" name="video_url" placeholder="أدخل الرابط الجديد">
                </div>
                <button type="submit" name="edit_video" class="btn">تعديل الفيديو</button>
            </form>
        </div>

        <!-- حذف فيديو -->
        <div id="delete-video" class="sub-section">
            <h3>حذف فيديو</h3>
            <form method="POST" action="admin.php">
                <div class="form-group">
                    <label>اختر الفيديو</label>
                    <select name="video_id">
                        <?php foreach ($videos as $video): ?>
                            <option value="<?= $video['id'] ?>"><?= $video['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" name="delete_video" class="btn" style="background-color: #e53e3e;">حذف الفيديو</button>
            </form>
        </div>

        <!-- عرض الفيديوهات -->
        <div id="view-videos" class="sub-section">
            <h3>عرض الفيديوهات</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>عنوان الفيديو</th>
                        <th>الدورة</th>
                        <th>رابط الفيديو</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($videos as $video): ?>
                        <tr>
                            <td><?= $video['title'] ?></td>
                            <td><?= $video['course_id'] ?></td>
                            <td><a href="<?= $video['video_url'] ?>" target="_blank">رابط الفيديو</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- محتوى إدارة المدونة -->
    <!-- <div id="manage-blog" class="card" style="display: none;">
      <h2>إدارة المدونة</h2>
      <div id="add-post" class="sub-section">
        <h3>إضافة منشور</h3>
        <div class="form-group">
          <label>عنوان المنشور</label>
          <input type="text" placeholder="أدخل عنوان المنشور">
        </div>
        <div class="form-group">
          <label>محتوى المنشور</label>
          <textarea placeholder="أدخل محتوى المنشور"></textarea>
        </div>
        <button class="btn">إضافة المنشور</button>
      </div>

      <div id="edit-post" class="sub-section" style="display: none;">
        <h3>تعديل منشور</h3>
        <div class="form-group">
          <label>اختر المنشور</label>
          <select>
            <option value="1">منشور 1</option>
            <option value="2">منشور 2</option>
          </select>
        </div>
        <button class="btn">تعديل المنشور</button>
      </div>

      <div id="delete-post" class="sub-section" style="display: none;">
        <h3>حذف منشور</h3>
        <div class="form-group">
          <label>اختر المنشور</label>
          <select>
            <option value="1">منشور 1</option>
            <option value="2">منشور 2</option>
          </select>
        </div>
        <button class="btn" style="background-color: #e53e3e;">حذف المنشور</button>
      </div>

      <div id="view-posts" class="sub-section" style="display: none;">
        <h3>عرض المنشورات</h3>
        <table class="table">
          <thead>
            <tr>
              <th>عنوان المنشور</th>
              <th>تاريخ النشر</th>
              <th>الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>منشور 1</td>
              <td>2023-10-01</td>
              <td>
                <button class="btn">تعديل</button>
                <button class="btn" style="background-color: #e53e3e;">حذف</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> -->

    <div id="manage-blog" class="card" style="display: none;">
        <h2>إدارة المدونة</h2>

        <!-- إضافة منشور جديد -->
        <div id="add-post" class="sub-section">
            <h3>إضافة منشور جديد</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label>عنوان المنشور</label>
                    <input type="text" name="title" placeholder="أدخل عنوان المنشور" required>
                </div>
                <div class="form-group">
                    <label>محتوى المنشور</label>
                    <textarea name="content" placeholder="أدخل محتوى المنشور" required></textarea>
                </div>
                <button type="submit" name="add_post" class="btn">إضافة المنشور</button>
            </form>
        </div>

        <!-- عرض جميع المنشورات -->
        <div id="view-posts" class="sub-section">
            <h3>عرض المنشورات</h3>
            <?php if (!empty($posts)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>المحتوى</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                            <tr>
                                <td><?php echo $post['title']; ?></td>
                                <td><?php echo $post['content']; ?></td>
                                <td>
                                    <a href="?action=delete_post&id=<?php echo $post['id']; ?>" class="btn" style="background-color: #e53e3e;">حذف</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>لا يوجد منشورات.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- محتوى إدارة التقارير -->
    <!-- <div id="view-reports" class="card" style="display: none;">
      <h2>إدارة التقارير</h2>
      <div id="view-student-reports" class="sub-section">
        <h3>تقارير الطلاب</h3>
        <table class="table">
          <thead>
            <tr>
              <th>اسم الطالب</th>
              <th>عدد الدورات</th>
              <th>التقييم</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>محمد أحمد</td>
              <td>3</td>
              <td>4.5</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div id="view-course-reports" class="sub-section" style="display: none;">
        <h3>تقارير الدورات</h3>
        <table class="table">
          <thead>
            <tr>
              <th>اسم الدورة</th>
              <th>عدد الطلاب</th>
              <th>التقييم</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>دورة الرياضيات</td>
              <td>50</td>
              <td>4.7</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div id="view-teacher-reports" class="sub-section" style="display: none;">
        <h3>تقارير المعلمين</h3>
        <table class="table">
          <thead>
            <tr>
              <th>اسم المعلم</th>
              <th>عدد الدورات</th>
              <th>التقييم</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>علي محمود</td>
              <td>5</td>
              <td>4.8</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> -->


    <div id="manage-reports" class="card">
        <h2>إدارة التقارير</h2>

        <!-- عرض التقارير حسب النوع -->
        <div id="view-reports" class="sub-section">
            <h3>عرض التقارير</h3>
            <ul>
                <li><a href="?type=student">تقارير الطلاب</a></li>
                <li><a href="?type=course">تقارير الدورات</a></li>
                <li><a href="?type=teacher">تقارير المعلمين</a></li>
            </ul>

            <?php if (isset($_GET['type'])): ?>
                <?php
                $type = $_GET['type'];
                $filteredReports = array_filter($reports, function($report) use ($type) {
                    return $report['type'] === $type;
                });
                ?>

                <h4>تقارير <?php echo $type; ?></h4>
                <?php if (!empty($filteredReports)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>النوع</th>
                                <th>البيانات</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filteredReports as $report): ?>
                                <tr>
                                    <td><?php echo $report['type']; ?></td>
                                    <td><?php echo $report['data']; ?></td>
                                    <td><?php echo $report['created_at']; ?></td>
                                    <td>
                                        <a href="?action=delete_report&id=<?php echo $report['id']; ?>" class="btn" style="background-color: #e53e3e;">حذف</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>لا يوجد تقارير من نوع <?php echo $type; ?>.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
  </div>
</div>

<script>
  // عرض الأقسام الرئيسية
  function showSection(sectionId) {
    const sections = document.querySelectorAll('.card');
    sections.forEach(section => section.style.display = 'none');
    document.getElementById(sectionId).style.display = 'block';

    // تحديث القائمة الجانبية بناءً على القسم المحدد
    const sidebarSections = document.querySelectorAll('.sidebar-section');
    sidebarSections.forEach(section => section.style.display = 'none');

    if (sectionId === 'manage-courses') {
      document.getElementById('courses-actions').style.display = 'block';
    } else if (sectionId === 'manage-students') {
      document.getElementById('students-actions').style.display = 'block';
    } else if (sectionId === 'manage-teachers') {
      document.getElementById('teachers-actions').style.display = 'block';
    } else if (sectionId === 'manage-course-content') {
      document.getElementById('course-content-actions').style.display = 'block';
    } else if (sectionId === 'manage-blog') {
      document.getElementById('blog-actions').style.display = 'block';
    } else if (sectionId === 'view-reports') {
      document.getElementById('reports-actions').style.display = 'block';
    }

    // تحديث الأزرار النشطة في شريط التنقل
    const navButtons = document.querySelectorAll('.navbar button');
    navButtons.forEach(button => button.classList.remove('active'));
    event.target.classList.add('active');
  }

  // عرض الأقسام الفرعية
  function showSubSection(subSectionId) {
    const subSections = document.querySelectorAll('.sub-section');
    subSections.forEach(subSection => subSection.style.display = 'none');
    document.getElementById(subSectionId).style.display = 'block';
  }

  // تسجيل الخروج
  function logout() {
    alert("تم تسجيل الخروج بنجاح");
    // يمكنك إضافة إعادة توجيه إلى صفحة تسجيل الدخول هنا
  }
</script>

</body>
</html>

