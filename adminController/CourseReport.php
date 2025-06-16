<?php
class CourseReport extends Report {
    private $course_id;

    public function __construct($course_id, $data, $id = null) {
        parent::__construct('course', $data, $id);
        $this->course_id = $course_id;
    }

    public function getCourseId() { return $this->course_id; }
    public function setCourseId($course_id) { $this->course_id = $course_id; }
}
?>