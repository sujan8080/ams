<?php
require_once ('StudentManager.php');
session_start();
// echo $_SESSION['student_id'];
if (!empty($_SESSION["student_id"]) && isset($_SESSION['student_id'])) {

    $student_id = $_SESSION['student_id'];
    $studentManager = new StudentManager();
     $studentDetails = $studentManager->getStudentName($student_id);
    $responseDecode = json_decode($studentDetails, true); // Decode JSON response
    // print_r($responseDecode);
} else {
    header('studentLogin.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: linear-gradient(to right, #00c6ff, #0072ff);
            /* Gradient background */
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
            /* Smooth hover transition */
        }

        .navbar a:hover {
            background-color: rgba(255, 255, 255, 0.3);
            /* Transparent white on hover */
            color: white;
        }

        .navbar a.active {
            background-color: rgba(255, 255, 255, 0.2);
            /* Semi-transparent white for active link */
        }

        .navbar a.logo {
            font-weight: bold;
            font-size: 24px;
        }

        .navbar a:last-child {
            float: right;
            /* Float the last link (Logout) to the right */
        }
    </style>
</head>

<body>

    <div class="navbar">
        <?php if (!empty($responseDecode) && isset($responseDecode['success']) && $responseDecode['success']) { ?>
            <a href="#" class="logo">
                <?= $responseDecode['data']; ?>

            </a>
        <?php } ?>

        <a href="adminDashboard.php">Dashboard</a>
        <a href="studentList.php">Admission Form</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>


</body>

</html>