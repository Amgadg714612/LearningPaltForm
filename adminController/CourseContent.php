<?php
class CourseContent {
    private $id;
    private $course_id;
    private $title;
    private $content;

    public function __construct($course_id, $title, $content, $id = null) {
        $this->id = $id;
        $this->course_id = $course_id;
        $this->title = $title;
        $this->content = $content;
    }
    // Getters
    public function getId() { return $this->id; }
    public function getCourseId() { return $this->course_id; }
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }

    // Setters
    public function setCourseId($course_id) { $this->course_id = $course_id; }
    public function setTitle($title) { $this->title = $title; }
    public function setContent($content) { $this->content = $content; }
}
?>