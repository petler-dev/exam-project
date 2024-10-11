<?php
$host = 'form_db';
$dbname = 'john_snow';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function saveToDatabase($name, $email, $password) {
    global $pdo;

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashedPassword]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
    saveToDatabase($name, $email, $password);
    $successMessage = "Registration successful! Your data has been saved.";
}
?>
