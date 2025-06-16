<?php
class StudentReport extends Report {
    private $student_id;

    public function __construct($student_id, $data, $id = null) {
        parent::__construct('student', $data, $id);
        $this->student_id = $student_id;
    }

    public function getStudentId() { return $this->student_id; }
    public function setStudentId($student_id) { $this->student_id = $student_id; }
}
?>
