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
  <title>Applications for <?= htmlspecialchars($job['title']) ?> - KosovaJob</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f6f6f3;
      max-width: 900px;
      margin: 30px auto;
      padding: 0 20px 50px;
      color: #333;
    }

    h2 {
      color: #846c3b;
      font-weight: 700;
      font-size: 2rem;
      margin-bottom: 20px;
      text-align: center;
    }

    p.back-link {
      text-align: center;
      margin-bottom: 30px;
      font-weight: 600;
    }

    p.back-link a {
      color: #846c3b;
      text-decoration: none;
      font-size: 1rem;
      transition: color 0.3s ease;
    }

    p.back-link a:hover {
      color: #6c552f;
      text-decoration: underline;
    }

    ul.applications-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    ul.applications-list li {
      background: white;
      padding: 20px 25px;
      border-radius: 12px;
      margin-bottom: 20px;
      box-shadow: 0 6px 15px rgba(132,108,59,0.12);
      transition: box-shadow 0.3s ease;
    }

    ul.applications-list li:hover {
      box-shadow: 0 8px 25px rgba(132,108,59,0.25);
    }

    ul.applications-list strong {
      font-size: 1.2rem;
      color: #4b3e1a;
    }

    ul.applications-list em {
      font-style: normal;
      font-weight: 600;
      color: #846c3b;
      margin-top: 6px;
      display: inline-block;
    }

    .no-applications {
      text-align: center;
      font-size: 1.1rem;
      color: #666;
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <h2>Applications for: <?= htmlspecialchars($job['title']) ?></h2>

  <p class="back-link"><a href="employer-dashboard.php">← Back to My Jobs</a></p>

  <?php if (count($applications) > 0): ?>
    <ul class="applications-list">
      <?php foreach ($applications as $app): ?>
        <li>
          <strong><?= htmlspecialchars($app['applicant_name']) ?></strong> (<?= htmlspecialchars($app['applicant_email']) ?>)<br />
          <em>Applied on: <?= date("F j, Y, g:i a", strtotime($app['applied_at'])) ?></em>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="no-applications">No applications yet for this job.</p>
  <?php endif; ?>

</body>
</html>
