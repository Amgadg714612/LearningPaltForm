<?php
class Course {
    private $id;
    private $name;
    private $description;
    private $teacher_id;
    private $start_date;
    private $image;

    
    private $end_date;
    public function __construct($name, $description, $teacher_id, $start_date, $end_date, $id = null,$image=null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->teacher_id = $teacher_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->image=$image;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getDescription() { return $this->description; }
    public function getTeacherId() { return $this->teacher_id; }
    public function getStartDate() { return $this->start_date; }
    public function getEndDate() { return $this->end_date; }
    public function getimage() { return $this->image; }


    // Setters
    public function setName($name) { $this->name = $name; }
    public function setDescription($description) { $this->description = $description; }
    public function setTeacherId($teacher_id) { $this->teacher_id = $teacher_id; }
    public function setStartDate($start_date) { $this->start_date = $start_date; }
    public function setEndDate($end_date) { $this->end_date = $end_date; }
}
?>