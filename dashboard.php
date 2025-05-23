<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_type = $_SESSION['user_type'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - HireHub</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

  <?php if ($user_type === 'employer'): ?>
    <p><a href="employer-dashboard.php">Go to Employer Dashboard</a></p>
    <p><a href="post-job.php">Post a New Job</a></p>
  <?php elseif ($user_type === 'job_seeker'): ?>
    <p><a href="browse-jobs.php">Browse Jobs</a></p>
    <p><a href="my-applications.php">My Applications</a></p>
  <?php else: ?>
    <p>User type unknown.</p>
  <?php endif; ?>

  <p><a href="logout.php">Logout</a></p>
</body>
</html>
