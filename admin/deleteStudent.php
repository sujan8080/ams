<?php

require_once ("../students/StudentManager.php");

if (!empty($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $studentManager = new StudentManager();
    $response = $studentManager->deleteStudent($student_id);
    $responseDecode = json_decode($response, true);

    if (!empty($responseDecode) && isset($responseDecode['success'])) {
        $_SESSION['success_message'] = $responseDecode['message'];
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } else {
        $_SESSION['error_message'] = $responseDecode['message'];
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
}
?>