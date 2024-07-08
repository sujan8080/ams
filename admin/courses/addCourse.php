
<?php 

require_once("CoursesManager.php");

if(!empty($_POST)){
    $course_name = $_POST["course_name"];
    $description =$_POST["course_description"];

    $courseManager = new CoursesManager();
    $response = $courseManager->addCourse($course_name, $description);
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
    // print_r($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .add-course-form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .form-group input[type="text"], 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-group input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="add-course-form">
    <h2>Add New Course</h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="course_name">Course Name</label>
            <input type="text" id="course_name" name="course_name" required>
        </div>
        <div class="form-group">
            <label for="course_description">Course Description</label>
            <textarea id="course_description" name="course_description" required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Add Course">
        </div>
    </form>
    

</div>

</body>
</html>

