<?php

// print_r($_POST);

require_once ("../students/StudentManager.php");

if (!empty($_POST)) {
    $studentId = $_POST['student_id'];
    $studentStatus = $_POST['is_admission_verified'];

    // print_r($studentStatus);

    $StudentManager = new StudentManager();
    $response = $StudentManager->updateAdmissionStatus($studentId, $studentStatus);
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