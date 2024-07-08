<?php

require_once ('../config/DatabaseConnection.php');

class AdminManager extends DatabaseConnection
{

    function __construct()
    {
        parent::__construct();
    }

    function adminRegister($full_name, $email, $password)
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

            $sql = "INSERT INTO admins (admin_fullname,admin_email,password) VALUES('$full_name','$email','$hashedPassword')";
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
    
    public function adminLogin($email, $password)
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
        $stmt = $this->conn->prepare("SELECT admin_id,admin_email FROM admins WHERE admin_email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $hashedPassword);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            session_start();
            
            $admin_id=mysqli_fetch_assoc($result);
            
            $_SESSION['admin_id']=$admin_id['admin_id'];
            
            header('Location:adminDashboard.php');
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
    
    
function logout(){
    session_start();
        // $_SESSION = array();
        session_destroy();
        header("Location:index.php");
        exit();
}
    
}