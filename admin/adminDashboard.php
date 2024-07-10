<?php
require_once('courses/CoursesManager.php');
$courseManager = new CoursesManager();
$response = $courseManager->courseList();
$responseDecode = json_decode($response,true);

// print_r($responseDecode);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .course-list {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .course-item {
            border-bottom: 1px solid #ddd;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .course-item:last-child {
            border-bottom: none;
        }

        .course-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .course-description {
            margin-top: 8px;
            color: #666;
        }

        .course-actions {
            text-align: right;
        }

        .btn {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .view-courses-btn {
            text-align: center;
            margin-top: 20px;
            padding-bottom: 20px;
        }

        .view-courses-btn a {
            display: inline-block;
            padding: 10px 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            
        }

        .view-courses-btn a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <?php require_once('adminNavigation.php'); ?>

    <div class="view-courses-btn">
        <a href="courses/addCourse.php" style="background-color:green;" class="btn">Add Courses</a>
    </div>

    <div class="course-list">
    <?php
    if (!empty($responseDecode) && isset($responseDecode['success']) == true) {
                foreach ($responseDecode['data'] as $course) {
                    ?>
        <div class="course-item">
            <div>
                <div class="course-title"><?= $course['course_name']; ?></div>
                <!-- <div class="course-description"><?= $course['course_description']; ?></div> -->
            </div>
            <div class="course-actions">
                <a href="courses/editCourse.php?course_id=<?= $course['course_id'];?>" class="btn" >Edit</a>
                <a href="courses/deleteCourse.php?course_id=<?= $course['course_id'];?>" class="btn" style="background-color:red;">Delete</a>
            </div>
        </div>
       
    
        <?php } }?>
    
        <!-- Add more course items as needed -->
    </div>
    <?php require_once ('adminNavigation.php'); ?>




</body>

</html>