<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Job ID is required.");
}

$job_id = $_GET['id'];
$employer_id = $_SESSION['user_id'];

// Check ownership before deleting
$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ? AND posted_by = ?");
$stmt->execute([$job_id, $employer_id]);
$job = $stmt->fetch();

if (!$job) {
    die("Job not found or you don't have permission to delete it.");
}

// Delete the job (applications will delete automatically if you have ON DELETE CASCADE)
$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
$stmt->execute([$job_id]);

header("Location: employer-dashboard.php");
exit;
