<?php
require_once('CoursesManager.php');

if(!empty($_GET['course_id'])){
$couseId=$_GET['course_id'];
    $courseManager=new CoursesManager();
    $response=$courseManager->deleteCourse($couseId);

}else{
    header('Location:../index.php');
}

?>