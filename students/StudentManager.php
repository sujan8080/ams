<?php
// require_once (_DIR__."/../config/DatabaseConnection.php");
require_once('../config/DatabaseConnection.php');


class StudentManager extends DatabaseConnection{
    
    function __construct(){
        parent::__construct();
    }

  
    public function studentLogin($email, $password)
    {
        $response = [];
        
        if (empty($email) || empty($password)) {
            $response = [
                'success' => false,
                'error' => 'Failed',
                'message' => 'Fields are required'
            ];
            return json_encode($response);
        }
    
        $hashedPassword = md5($password);
    
        // Use prepared statements to prevent SQL injection
        $stmt = $this->conn->prepare("SELECT student_email FROM students WHERE student_email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            
            header('Location:studentDashboard.php');
            
            $response = [
                'success' => true,
                'error' => 'Success',
                'message' => 'Login successfully'
            ];
        } else {
            $response = [
                'success' => false,
                'error' => 'Failed',
                'message' => 'Email and password not match'
            ];
        }
    
        $stmt->close();
        return json_encode($response);
    }


    function studentRegister($full_name, $email, $password,$course_id)
    {
        $response = [];

        if (empty($email)) {
            $response = [
                'success' => false,
                'error' => 'Failed',
                'message' => 'Fields are required'
            ];
            return json_encode($response);
        }
        $hashedPassword = md5($password);
        // $hashedPassword=PASSWORD_BCRYPT($password);

        try {

            $sql = "INSERT INTO students (student_fullname,student_email,password,course_id) VALUES('$full_name','$email','$hashedPassword','$course_id')";
            $result = $this->conn->query($sql);
            if ($result) {
                $response = [
                    'success' => true,
                    'error' => 'Successs',
                    'message' => 'Account created successfully'
                ];
            } else {
                $response = [
                    'success' => false,
                    'error' => 'Failed',
                    'message' => 'Something went wrong'
                ];
            }
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'error' => 'Failed',
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
        return json_encode($response);

    }

}

?>