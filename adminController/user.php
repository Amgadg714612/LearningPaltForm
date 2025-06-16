<?php
class User {
    private $id;
    private $email;
    private $password;
    private $role;

    // Constructor
    public function __construct($id, $email, $password,$role) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->role=$role;
    }
    // Getters
    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }
    public function getrole() {
        return $this->role;
    }
}
?>