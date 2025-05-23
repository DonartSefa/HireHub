<?php
session_start();
include_once("config.php");

// Ensure user is logged in and is a job seeker
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'job_seeker') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = $_POST['job_id'];
    $user_id = $_SESSION['user_id'];

    // Collect form data
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $full_name = $first_name . ' ' . $last_name;

    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $dob_day = $_POST['dob_day'];
    $dob_month = $_POST['dob_month'];
    $dob_year = $_POST['dob_year'];
    $dob = $dob_year . '-' . str_pad(array_search($dob_month, ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]) + 1, 2, "0", STR_PAD_LEFT) . '-' . str_pad($dob_day, 2, "0", STR_PAD_LEFT);

    $education_level = $_POST['education_level'];
    $experience = $_POST['experience'];

    // Prevent duplicate applications by the same user to the same job
    $check = $conn->prepare("SELECT id FROM applications WHERE job_id = ? AND user_id = ?");
    $check->execute([$job_id, $user_id]);

    if ($check->rowCount() > 0) {
        die("You have already applied for this job.");
    }

    // Insert the job application
    $stmt = $conn->prepare("INSERT INTO applications 
        (user_id, job_id, full_name, email, phone, gender, city, dob, education_level, experience) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $user_id,
        $job_id,
        $full_name,
        $email,
        $phone,
        $gender,
        $city,
        $dob,
        $education_level,
        $experience
    ]);

    header("Location: view-job.php?id=$job_id&applied=1");
    exit;
}
?>
