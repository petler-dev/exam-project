<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db/db.php';

$errors = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Если нажата кнопка регистрации
    if (isset($_POST['register'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        if (empty($name) || strlen($name) < 3) {
            $errors[] = "Name must be at least 3 characters long.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        if (isEmailExists($email)) {
            $errors[] = "This email is already registered.";
        }
        if (empty($errors)) {
            saveToDatabase($name, $email, $password);
            $successMessage = "Registration successful! You can now login.";
        }
    }

    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $user = getUserByEmail($email);


        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = "Invalid email or password.";
        } else {
            $_SESSION['user'] = $email;
            header('Location: dashboard.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            display: none;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loader-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: none;
        }
    </style>
</head>
<body>
    <div class="loader-wrapper">
        <div class="loader"></div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Login and Registration</h2>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($successMessage): ?>
            <div class="alert alert-success">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="POST" onsubmit="showLoader()">
            <h3>Login</h3>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>

        <hr>

        <!-- Форма регистрации -->
        <form action="index.php" method="POST" onsubmit="showLoader()">
            <h3>Register</h3>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="register" class="btn btn-success">Register</button>
        </form>
    </div>

    <!-- Скрипт для отображения лоадера при отправке формы -->
    <script>
        function showLoader() {
            // Показываем лоадер
            document.querySelector('.loader-wrapper').style.display = 'flex';
        }
    </script>
</body>
</html>
