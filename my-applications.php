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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f9fafb;
      padding: 40px 20px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h2 {
      color: #444;
      margin-bottom: 30px;
      text-align: center;
      font-weight: 700;
    }
    .application-card {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgb(0 0 0 / 0.05);
      background: #fff;
      padding: 20px 25px;
      margin-bottom: 25px;
      transition: box-shadow 0.3s ease;
    }
    .application-card:hover {
      box-shadow: 0 8px 24px rgb(0 0 0 / 0.1);
    }
    .job-title {
      color: #f47f4c;
      font-weight: 700;
      font-size: 1.25rem;
      margin-bottom: 0;
      text-overflow: ellipsis;
      white-space: nowrap;
      overflow: hidden;
    }
    .job-company {
      font-size: 1rem;
      color: #555;
      margin-bottom: 15px;
    }
    .info-label {
      font-weight: 600;
      color: #333;
      width: 140px;
      display: inline-block;
    }
    .info-value {
      color: #555;
    }
    .application-info em {
      display: block;
      margin-bottom: 6px;
      font-style: normal;
      color: #666;
    }
    .no-applications {
      text-align: center;
      color: #777;
      font-size: 1.1rem;
      margin-top: 50px;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 40px;
      font-weight: 600;
      color: #f47f4c;
      text-decoration: none;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <h2>My Job Applications</h2>

  <div class="container">
    <?php if (count($applications) > 0): ?>
      <?php foreach ($applications as $app): ?>
        <div class="application-card">
          <h3 class="job-title" title="<?php echo htmlspecialchars($app['title']); ?>">
            <?php echo htmlspecialchars($app['title']); ?>
          </h3>
          <div class="job-company">
            at <?php echo htmlspecialchars($app['company']); ?> — <?php echo htmlspecialchars($app['location']); ?>
          </div>

          <div class="application-info">
            <em><span class="info-label">Applied on:</span> <span class="info-value"><?php echo date("F j, Y, g:i a", strtotime($app['applied_at'])); ?></span></em>
            <em><span class="info-label">Full Name:</span> <span class="info-value"><?php echo htmlspecialchars($app['full_name']); ?></span></em>
            <em><span class="info-label">Email:</span> <span class="info-value"><?php echo htmlspecialchars($app['email']); ?></span></em>
            <em><span class="info-label">Phone:</span> <span class="info-value"><?php echo htmlspecialchars($app['phone']); ?></span></em>
            <em><span class="info-label">Gender:</span> <span class="info-value"><?php echo htmlspecialchars($app['gender']); ?></span></em>
            <em><span class="info-label">Date of Birth:</span> <span class="info-value"><?php echo htmlspecialchars($app['dob']); ?></span></em>
            <em><span class="info-label">City:</span> <span class="info-value"><?php echo htmlspecialchars($app['city']); ?></span></em>
            <em><span class="info-label">Education Level:</span> <span class="info-value"><?php echo htmlspecialchars($app['education_level']); ?></span></em>
            <em><span class="info-label">Experience:</span> <span class="info-value"><?php echo htmlspecialchars($app['experience']); ?></span></em>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="no-applications">
        You have not applied to any jobs yet.
      </div>
    <?php endif; ?>

    <a href="dashboard.php" class="back-link">&larr; Back to Dashboard</a>
  </div>

</body>
</html>
