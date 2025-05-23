<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'job_seeker') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("
    SELECT applications.*, jobs.title, jobs.company, jobs.location 
    FROM applications 
    JOIN jobs ON applications.job_id = jobs.id 
    WHERE applications.user_id = ?
    ORDER BY applications.applied_at DESC
");
$stmt->execute([$user_id]);
$applications = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Applications - HireHub</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
    }
    h2 {
      color: #333;
    }
    ul {
      list-style: none;
      padding: 0;
    }
    li {
      background: #f9f9f9;
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 8px;
    }
    .job-title {
      font-size: 18px;
      font-weight: bold;
      color: #f47f4c;
    }
    .job-company {
      font-size: 16px;
      color: #444;
    }
    em {
      color: #666;
      display: block;
      margin-top: 6px;
    }
    .back-link {
      margin-top: 30px;
    }
  </style>
</head>
<body>
  <h2>My Job Applications</h2>

  <?php if (count($applications) > 0): ?>
    <ul>
      <?php foreach ($applications as $app): ?>
        <li>
          <div class="job-title"><?php echo htmlspecialchars($app['title']); ?></div>
          <div class="job-company">at <?php echo htmlspecialchars($app['company']); ?></div>
          <em>Location: <?php echo htmlspecialchars($app['location']); ?></em>
          <em>Applied on: <?php echo date("F j, Y, g:i a", strtotime($app['applied_at'])); ?></em>
          <em>Full Name: <?php echo htmlspecialchars($app['full_name']); ?></em>
          <em>Email: <?php echo htmlspecialchars($app['email']); ?></em>
          <em>Phone: <?php echo htmlspecialchars($app['phone']); ?></em>
          <em>Gender: <?php echo htmlspecialchars($app['gender']); ?></em>
          <em>Date of Birth: <?php echo htmlspecialchars($app['dob']); ?></em>
          <em>City: <?php echo htmlspecialchars($app['city']); ?></em>
          <em>Education Level: <?php echo htmlspecialchars($app['education_level']); ?></em>
          <em>Experience: <?php echo htmlspecialchars($app['experience']); ?></em>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>You have not applied to any jobs yet.</p>
  <?php endif; ?>

  <p class="back-link"><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
