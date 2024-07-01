<?php

require_once ('../../config/DatabaseConnection.php');

class CoursesManager extends DatabaseConnection
{
    function __construct()
    {
        parent::__construct();
    }
    public function getCourses()
    {

        $response = [];
        $sql = "SELECT * FROM courses";
        $result = $this->conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $response[] = $row;
            }
            $response = [
                'success' => true,
                'error' => "Success",
                'message' => 'Courses found'
            ];
        }

    }
    public function getCoursesByCourseId($course_id)
    {
    }
}