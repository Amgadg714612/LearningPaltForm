<?php
class TeacherReport extends Report {
    private $teacher_id;

    public function __construct($teacher_id, $data, $id = null) {
        parent::__construct('teacher', $data, $id);
        $this->teacher_id = $teacher_id;
    }

    public function getTeacherId() { return $this->teacher_id; }
    public function setTeacherId($teacher_id) { $this->teacher_id = $teacher_id; }

}

?>
