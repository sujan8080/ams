<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Document</title>

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
    <?php require_once ('adminNavigation.php'); ?>

    <div class="view-courses-btn">
        <a href="courses/addCourse.php" class="btn">Add Courses</a>
    </div>

    <div class="course-list">
        <div class="course-item">
            <div>
                <div class="course-title">Course Title 1</div>
                <div class="course-description">This is a description of Course 1.</div>
            </div>
            <div class="course-actions">
                <a href="#" class="btn">View</a>
            </div>
        </div>
        <div class="course-item">
            <div>
                <div class="course-title">Course Title 2</div>
                <div class="course-description">This is a description of Course 2.</div>
            </div>
            <div class="course-actions">
                <a href="#" class="btn">View</a>
            </div>
        </div>
        <!-- Add more course items as needed -->
    </div>



</body>

</html>

</html>