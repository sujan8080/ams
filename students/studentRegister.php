<?php
require_once '../admin/courses/CoursesManager.php';

$courseManager = new CoursesManager();
$response = $courseManager->getCourses();
$responseDecode = json_decode($response, true);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .register-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
    }

    .register-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .register-btn {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 16px;
    }

    .register-btn:hover {
        background-color: #45a049;
    }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Register</h2>
        <form id="registerForm" action="register.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="course">Course</label>
                <select name="course_id" id="course_id">
                    <?php if (isset($responseDecode['data']) && is_array($responseDecode['data'])) { ?>
                    <?php foreach ($responseDecode['data'] as $course) { ?>
                    <option value="<?= htmlspecialchars($course['course_id']); ?>">
                        <?= htmlspecialchars($course['course_name']); ?></option>
                    <?php } ?>
                    <?php } else { ?>
                    <option value="">No courses available</option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="username">Full name</label>
                <input type="text" id="username" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" required>
            </div>
            <button type="submit" class="register-btn">Register</button>
        </form>
    </div>
    <script>
    function validateForm() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        if (password.length < 6) {
            alert('Password must be at least 6 characters long.');
            return false;
        }

        if (password !== confirmPassword) {
            alert('Passwords do not match.');
            return false;
        }

        return true; // Allow form submission
    }
    </script>
</body>

</html>