<?php
require_once ('StudentManager.php');

if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // print_r($_POST);

    $studentManager = new StudentManager();

    $response = $studentManager->studentLogin($email, $password);
    $responseDecode = json_decode($response, true);
    // print_r($responseDecode);

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
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

        .login-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h2 {
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

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
        }

        .login-btn:hover {
            background-color: #45a049;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>

        <form action="" method="post">
            <div class="form-group">
                <label for="username">Email</label>
                <input type="text" id="username" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <?php if (!empty($responseDecode) && isset($responseDecode['success'])) { ?>
                <?php if ($responseDecode['success']) { ?>
                    <p class="success"><?= $responseDecode['message']; ?></p>
                <?php } else { ?>
                    <p class="error"><?= $responseDecode['message'];
                    // echo "$responseDecode[status]"; ?></p>
                <?php } ?>
            <?php } ?>

            <button type="submit" class="login-btn">Login</button><br><br>

        </form>
        <a href="studentRegister.php">Register</a>
    </div>
</body>

</html>