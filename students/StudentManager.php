<?php
// require_once (_DIR__."/../config/DatabaseConnection.php");
require_once ('../config/DatabaseConnection.php');


class StudentManager extends DatabaseConnection
{

    function __construct()
    {
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
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE student_email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();

        $student = mysqli_fetch_assoc($result);


        if ($result && $result->num_rows > 0) {
            $is_verified = $student['is_admission_verified'];
            if ($is_verified === "approved") {
                session_start();
                $_SESSION['student_id'] = $student['student_id'];
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
                    'message' => 'Student is not approved',
                    'status' => $is_verified
                ];
            }
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


    function studentRegister($full_name, $email, $password, $course_id)
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

    public function getStudentDetails($student_id)
    {
        $response = [];

        // Query to retrieve student details based on ID
        $sql = "SELECT * FROM students WHERE student_id = ?";

        // Using prepared statement to prevent SQL injection
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response['success'] = true;
            $response['data'] = $row; // Assign fetched row to 'data' key
            $response['message'] = 'Student details found';
        } else {
            $response['success'] = false;
            $response['message'] = 'Student not found';
        }

        return json_encode($response);
    }
    public function getStudentName($student_id)
    {
        $response = [];

        // Query to retrieve student name based on ID
        $sql = "SELECT student_fullname FROM students WHERE student_id = ?";

        // Using prepared statement to prevent SQL injection
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            $response['success'] = false;
            $response['message'] = 'Database error: ' . $this->conn->error;
            return json_encode($response);
        }

        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response['success'] = true;
            $response['data'] = $row['student_fullname']; // Assign fetched name to 'data' key
            $response['message'] = 'Student name found';
        } else {
            $response['success'] = false;
            $response['message'] = 'Student not found';
        }

        return json_encode($response);
    }




    function studentList()
    {
        $response = [];
        $sql = "SELECT students.*, courses.* FROM students
        JOIN courses 
        ON courses.course_id = students.course_id";
        $result = $this->conn->query($sql);
        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $response['data'][] = $row;
                }
                $response['success'] = true;
                $response['error'] = 'Success';
                $response['message'] = 'Students found';
            }
        } else {
            $response['success'] = false;
            $response['error'] = "Failed";
            $response["message"] = "No student found";
        }
        return json_encode($response);

    }
    // function studentList()
    // {
    //     $response = [];
    //     $sql = "SELECT * FROM students";
    //     $result = $this->conn->query($sql);
    //     if ($result) {
    //         if ($result->num_rows > 0) {
    //             while ($row = $result->fetch_assoc()) {
    //                 $response['data'][] = $row;
    //             }
    //             $response['success'] = true;
    //             $response['error'] = 'Success';
    //             $response['message'] = 'Students found';
    //         }
    //     } else {
    //         $response['success'] = false;
    //         $response['error'] = "Failed";
    //         $response["message"] = "No student found";
    //     }
    //     return json_encode($response);

    // }


    public function updateAdmissionStatus($student_id, $status)
    {
        $response = [];

        // Validate the status
        $validStatuses = ['pending', 'cancelled', 'approved'];
        if (!in_array($status, $validStatuses)) {
            $response['success'] = false;
            $response['error'] = 'Invalid Status';
            $response['message'] = 'Invalid admission status provided';
            return json_encode($response);
        }

        $stmt = $this->conn->prepare("UPDATE students SET is_admission_verified = ? WHERE student_id = ?");
        if ($stmt) {
            $stmt->bind_param("si", $status, $student_id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Admission status updated successfully';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'No student found with the provided ID';
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Error executing update: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = 'Error preparing statement: ' . $this->conn->error;
        }

        return json_encode($response);
    }
    function deleteStudent($student_id)
    {
        $response = [];

        $sql = "DELETE FROM students WHERE student_id = ?";

        // Prepare and bind parameter
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $student_id);

        // Execute the statement
        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'error' => "Success",
                'message' => "Deleted successfully"
            ];
        } else {
            $response = [
                'success' => false,
                'error' => "Failed",
                'message' => "Failed to delte"
            ];
        }

        // Close statement and connection
        $stmt->close();

        return json_encode($response);
    }

    function logout()
    {
        session_start();
        // $_SESSION = array();
        session_destroy();
        header("Location:studentLogin.php");
        exit();
    }
}





