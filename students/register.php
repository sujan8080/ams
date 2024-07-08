<?php

require_once ('StudentManager.php');

if (!empty($_POST)) {

    // print_r($_POST);

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $course_id = $_POST['course_id'];

    $studentManager = new StudentManager();
    $response = $studentManager->studentRegister($full_name, $email, $password, $course_id);
    $responseDecode = json_decode($response, true);

    if (!empty($responseDecode) && isset($responseDecode['success'])) {
        // header("Location: {$_SERVER['HTTP_REFERER']}");
        echo $responseDecode['message'];
        exit;
    } else {
        echo $responseDecode['message'];
        // header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }


}