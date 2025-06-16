<?php
class Course_video {
    public $id;
    public $course_id;
    public $video_number;
    public $title;
    public $video_url;
    public $created_at;

    public function __construct($course_id, $video_number, $title, $video_url) {
        $this->course_id = $course_id;
        $this->video_number = $video_number;
        $this->title = $title;
        $this->video_url = $video_url;
    }
}
?>