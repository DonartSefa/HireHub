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
  <title>Employer Dashboard - KosovaJob</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f6f6f3;
      margin: 30px auto;
      max-width: 900px;
      padding: 0 20px 50px 20px;
      color: #333;
    }

    h2 {
      color: #846c3b;
      font-weight: 700;
      font-size: 2rem;
      margin-bottom: 20px;
      text-align: center;
    }

    p.actions {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
    }

    p.actions a {
      color: #846c3b;
      text-decoration: none;
      margin: 0 15px;
      font-size: 1rem;
      transition: color 0.3s ease;
    }

    p.actions a:hover {
      color: #6c552f;
      text-decoration: underline;
    }

    ul.job-list {
      list-style-type: none;
      padding: 0;
      margin: 0 auto;
      max-width: 900px;
    }

    ul.job-list li {
      background: white;
      padding: 20px 25px;
      margin-bottom: 20px;
      border-radius: 12px;
      box-shadow: 0 6px 15px rgba(132,108,59,0.12);
      transition: box-shadow 0.3s ease;
    }

    ul.job-list li:hover {
      box-shadow: 0 8px 25px rgba(132,108,59,0.25);
    }

    ul.job-list strong {
      font-size: 1.25rem;
      color: #4b3e1a;
      display: block;
      margin-bottom: 8px;
    }

    ul.job-list em {
      font-style: normal;
      font-weight: 600;
      color: #846c3b;
      margin-right: 5px;
    }

    ul.job-list small {
      color: #888;
      font-size: 0.85rem;
      display: block;
      margin-top: 12px;
    }

    .job-actions {
      margin-top: 15px;
    }

    .job-actions a {
      color: #846c3b;
      font-weight: 600;
      text-decoration: none;
      margin-right: 20px;
      transition: color 0.3s ease;
    }

    .job-actions a:hover {
      color: #6c552f;
      text-decoration: underline;
    }

    .no-jobs {
      text-align: center;
      font-size: 1.1rem;
      color: #666;
      margin-top: 40px;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 50px;
      font-weight: 600;
      color: #846c3b;
      text-decoration: none;
      font-size: 1rem;
      transition: color 0.3s ease;
    }

    .back-link:hover {
      color: #6c552f;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <h2>My Posted Jobs</h2>

  <p class="actions">
    <a href="post-job.php">Post New Job</a> |
    <a href="logout.php">Logout</a>
  </p>

  <?php if (count($jobs) > 0): ?>
    <ul class="job-list">
      <?php foreach ($jobs as $job): ?>
        <li>
          <strong><?= htmlspecialchars($job['title']) ?></strong>
          <div><em>Company:</em> <?= htmlspecialchars($job['company']) ?></div>
          <div><em>Location:</em> <?= htmlspecialchars($job['location']) ?></div>
          <div><em>Category:</em> <?= htmlspecialchars($job['category']) ?></div>
          <small>Posted on <?= date("F j, Y", strtotime($job['created_at'])) ?></small>

          <div class="job-actions">
            <a href="view-applications.php?job_id=<?= $job['id'] ?>">View Applications</a>
            <a href="edit-job.php?id=<?= $job['id'] ?>">Edit</a>
            <a href="delete-job.php?id=<?= $job['id'] ?>" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="no-jobs">You have not posted any jobs yet.</p>
  <?php endif; ?>

  <a href="dashboard.php" class="back-link">Back to Main Dashboard</a>

</body>
</html>
