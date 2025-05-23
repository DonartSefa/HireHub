<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title       = trim($_POST['title']);
    $company     = trim($_POST['company']);
    $location    = trim($_POST['location']);
    $category    = trim($_POST['category']);
    $description = trim($_POST['description']);
    $posted_by   = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO jobs (title, company, location, category, description, posted_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $company, $location, $category, $description, $posted_by]);

    header("Location: dashboard.php");
    exit;
}
?>
