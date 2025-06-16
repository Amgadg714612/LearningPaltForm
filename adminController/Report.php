<?php
class Report {
    private $id;
    private $type;
    private $data;

    public function __construct($type, $data, $id = null) {
        $this->id = $id;
        $this->type = $type;
        $this->data = $data;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getType() { return $this->type; }
    public function getData() { return $this->data; }

    // Setters
    public function setType($type) { $this->type = $type; }
    public function setData($data) { $this->data = $data; }
}
?>