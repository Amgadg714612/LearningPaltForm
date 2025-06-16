<?php
class Post {
    private $id;
    private $title;
    private $content;
    private $image;

    public function __construct($title, $content, $id = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }

    // Setters
    public function setTitle($title) { $this->title = $title; }
    public function setContent($content) { $this->content = $content; }
}
?>