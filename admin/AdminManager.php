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

            $sql = "INSERT INTO admin (full_name,email,password) VALUES('$full_name','$email','$hashedPassword')";
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



