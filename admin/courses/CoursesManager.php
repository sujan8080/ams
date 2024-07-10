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
        
        if ($result && $result->num_rows > 0) {
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
        $response = [];
        $sql = "SELECT * FROM courses WHERE course_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $response['data'] = $result->fetch_assoc();
            $response['success'] = true;
            $response['error'] = "Success";
            $response['message'] = 'Course found';
        } else {
            $response['success'] = false;
            $response['error'] = "False";
            $response['message'] = 'Course not found';
        }
        
        $stmt->close();
        
        return json_encode($response);
    }
    
    public function addCourse($course_name, $course_description)
    {
        $response = [];
        
        $sql = "INSERT INTO courses (course_name, course_description) VALUES (?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ss", $course_name, $course_description);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['error'] = "Success";
                $response['message'] = 'Course added successfully.';
            } else {
                $response['success'] = false;
                $response['error'] = "False";
                $response['message'] = 'Failed to add course: ' . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $response['success'] = false;
            $response['error'] = "False";
            $response['message'] = 'Database error: ' . $this->conn->error;
        }
        
        return json_encode($response);
    }


    public function deleteCourse($course_id)
    {
        $response = [];
        
        $sql = "DELETE FROM courses WHERE course_id = ?";
        
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("i", $course_id);
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Course deleted successfully.';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Course not found or already deleted.';
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Failed to delete course: ' . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = 'Database error: ' . $this->conn->error;
        }
        
        return json_encode($response);
    }
    
    function courseList()
    {
        $response = [];
        // $sql = "SELECT students.*, courses.*  FROM students
        // JOIN courses 
        // ON courses.course_id = students.course_id "
        // Where students.student_id='$student_id';
        
        $sql="SELECT * FROM courses";

        $result = $this->conn->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $response['data'][] = $row;
                }
                $response['success'] = true;
                $response['error'] = 'Success';
                $response['message'] = 'course found';
            }
        } else {
            $response['success'] = false;
            $response['error'] = "Failed";
            $response["message"] = "No course found";
        }
        return json_encode($response);
    
    }
}
?>
