<?php
session_start();
include_once("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $user_type = $_POST['user_type'];

    if (empty($username) || empty($email) || empty($password)) {
        die("Please fill in all fields.");
    }

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("Email already registered.");
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
    $success = $stmt->execute([$username, $email, $hashedPassword, $user_type]);

    if ($success) {
        $_SESSION['user_id'] = $conn->lastInsertId();
        $_SESSION['username'] = $username;
        $_SESSION['user_type'] = $user_type;
        header("Location: dashboard.php");
        exit;
    } else {
        die("Error creating user.");
    }
}
?>