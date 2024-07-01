<?php
require_once(__DIR__."/../../config/DatabaseConnection.php");
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
                $response['data'][] = $row;
            }
            $response['success'] = true;
            $response['error'] = "Success";
            $response['message'] = 'Courses found';
            
        } else {
            $response['success'] = false;
            $response['error'] = "False";
            $response['message'] = 'Courses not found';
        }
        return json_encode($response);
    }
    
    public function getCoursesByCourseId($course_id)
    {
    }
}