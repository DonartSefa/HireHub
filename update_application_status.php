<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    echo "<p style='color:red;'>Unauthorized access.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'], $_POST['status'])) {
    $application_id = $_POST['application_id'];
    $new_status = $_POST['status'];

    if (!in_array($new_status, ['approved', 'denied'])) {
        echo "<p style='color:red;'>Invalid status.</p>";
        exit;
    }

    // Ensure the application belongs to a job posted by this employer
    $stmt = $conn->prepare("
        SELECT a.id 
        FROM applications a 
        JOIN jobs j ON a.job_id = j.id 
        WHERE a.id = ? AND j.posted_by = ?
    ");
    $stmt->execute([$application_id, $_SESSION['user_id']]);

    if ($stmt->rowCount() === 0) {
        echo "<p style='color:red;'>Application not found or unauthorized.</p>";
        exit;
    }

    // Update status
    $update = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $update->execute([$new_status, $application_id]);

    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "<p style='color:red;'>Invalid request.</p>";
}
