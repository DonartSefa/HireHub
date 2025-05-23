<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'job_seeker') {
    header("Location: login.php");
    exit;
}

$stmt = $conn->query("SELECT jobs.*, users.username AS employer_name FROM jobs JOIN users ON jobs.posted_by = users.id ORDER BY created_at DESC");
$jobs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Browse Jobs - HireHub</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <h2>Available Job Listings</h2>

  <?php if (count($jobs) > 0): ?>
    <ul>
      <?php foreach ($jobs as $job): ?>
        <li style="margin-bottom: 20px;">
          <a href="view-job.php?id=<?php echo $job['id']; ?>">
            <strong><?php echo htmlspecialchars($job['title']); ?></strong>
          </a> at <?php echo htmlspecialchars($job['company']); ?><br />
          <em>Location:</em> <?php echo htmlspecialchars($job['location']); ?><br />
          <em>Category:</em> <?php echo htmlspecialchars($job['category']); ?><br />
          <small>Posted by <?php echo htmlspecialchars($job['employer_name']); ?> on <?php echo date("F j, Y", strtotime($job['created_at'])); ?></small>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>No jobs available at the moment.</p>
  <?php endif; ?>

  <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
