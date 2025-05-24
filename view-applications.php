<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['job_id'])) {
    die("Job ID is required.");
}

$job_id = $_GET['job_id'];
$employer_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ? AND posted_by = ?");
$stmt->execute([$job_id, $employer_id]);
$job = $stmt->fetch();

if (!$job) {
    die("Job not found or you don't have permission to view applications.");
}

$stmt = $conn->prepare("
    SELECT applications.*, users.username AS applicant_name, users.email AS applicant_email
    FROM applications
    JOIN users ON applications.user_id = users.id
    WHERE applications.job_id = ?
    ORDER BY applications.applied_at DESC
");

$stmt->execute([$job_id]);

$applications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Applications for <?php echo htmlspecialchars($job['title']); ?> - HireHub</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <h2>Applications for: <?php echo htmlspecialchars($job['title']); ?></h2>

  <p><a href="employer-dashboard.php">Back to My Jobs</a></p>

  <?php if (count($applications) > 0): ?>
    <ul>
      <?php foreach ($applications as $app): ?>
        <li style="margin-bottom: 20px;">
          <strong><?php echo htmlspecialchars($app['applicant_name']); ?></strong> (<?php echo htmlspecialchars($app['applicant_email']); ?>)<br />
          <em>Applied on:</em> <?php echo date("F j, Y, g:i a", strtotime($app['applied_at'])); ?><br />
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>No applications yet for this job.</p>
  <?php endif; ?>
</body>
</html>
