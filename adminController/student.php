<?php
class Student {
    private $id;
    private $name;
    private $email;

    public function __construct($name, $email, $id = null) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
    // Getters
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    // Setters
    public function setName($name) { $this->name = $name; }
    public function setEmail($email) { $this->email = $email; }
}
?>