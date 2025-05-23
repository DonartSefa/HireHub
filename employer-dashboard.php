<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header("Location: login.php");
    exit;
}

$employer_id = $_SESSION['user_id'];

// Fetch jobs posted by this employer
$stmt = $conn->prepare("SELECT * FROM jobs WHERE posted_by = ? ORDER BY created_at DESC");
$stmt->execute([$employer_id]);
$jobs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Employer Dashboard - HireHub</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>
    body { font-family: Arial, sans-serif; max-width: 900px; margin: 30px auto; padding: 0 20px; }
    h2 { color: #333; }
    ul { list-style-type: none; padding: 0; }
    li { background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
    a { color: #007BFF; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .job-actions a { margin-right: 15px; }
  </style>
</head>
<body>
  <h2>My Posted Jobs</h2>

  <p>
    <a href="post-job.php">Post New Job</a> |
    <a href="logout.php">Logout</a>
  </p>

  <?php if (count($jobs) > 0): ?>
    <ul>
      <?php foreach ($jobs as $job): ?>
        <li>
          <strong><?php echo htmlspecialchars($job['title']); ?></strong><br />
          <em>Company:</em> <?php echo htmlspecialchars($job['company']); ?><br />
          <em>Location:</em> <?php echo htmlspecialchars($job['location']); ?><br />
          <em>Category:</em> <?php echo htmlspecialchars($job['category']); ?><br />
          <small>Posted on <?php echo date("F j, Y", strtotime($job['created_at'])); ?></small><br /><br />

          <div class="job-actions">
            <a href="view-applications.php?job_id=<?php echo $job['id']; ?>">View Applications</a>
            <a href="edit-job.php?id=<?php echo $job['id']; ?>">Edit</a>
            <a href="delete-job.php?id=<?php echo $job['id']; ?>" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>You have not posted any jobs yet.</p>
  <?php endif; ?>

  <p><a href="dashboard.php">Back to Main Dashboard</a></p>
</body>
</html>
