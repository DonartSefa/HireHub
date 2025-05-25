<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'job_seeker') {
    echo "<p style='color:red;'>Unauthorized access.</p>";
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

<style>
  .application-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    border-left: 6px solid #f47f4c;
    transition: box-shadow 0.3s ease;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .application-card:hover {
    box-shadow: 0 8px 20px rgba(244,127,76,0.25);
  }
  .job-title {
    color: #f47f4c;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 5px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }
  .job-company {
    font-size: 1rem;
    color: #555;
    margin-bottom: 15px;
    font-style: italic;
  }
  .application-info em {
    display: block;
    margin-bottom: 6px;
    font-style: normal;
    color: #555;
    font-size: 0.9rem;
  }
  .status-pill {
    display: inline-block;
    padding: 5px 10px;
    font-size: 0.85rem;
    font-weight: 600;
    border-radius: 50px;
    margin-top: 10px;
  }
  .status-pending {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
  }
  .status-approved {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }
  .status-denied {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }
  .no-applications {
    color: #777;
    font-style: italic;
    margin-top: 30px;
    text-align: center;
  }
</style>

<h2 style="color:#f47f4c; font-weight:700; margin-bottom: 30px;">My Job Applications</h2>

<?php if (count($applications) > 0): ?>
  <?php foreach ($applications as $app): ?>
    <?php
      $statusClass = 'status-pending';
      if ($app['status'] === 'approved') {
          $statusClass = 'status-approved';
      } elseif ($app['status'] === 'denied') {
          $statusClass = 'status-denied';
      }
    ?>
    <div class="application-card" title="<?= htmlspecialchars($app['title']); ?>">
      <h3 class="job-title"><?= htmlspecialchars($app['title']); ?></h3>
      <div class="job-company">
        at <?= htmlspecialchars($app['company']); ?> — <?= htmlspecialchars($app['location']); ?>
      </div>
      <div class="application-info">
        <em><strong>Applied on:</strong> <?= date("F j, Y, g:i a", strtotime($app['applied_at'])); ?></em>
        <em><strong>Full Name:</strong> <?= htmlspecialchars($app['full_name']); ?></em>
        <em><strong>Email:</strong> <?= htmlspecialchars($app['email']); ?></em>
        <em><strong>Phone:</strong> <?= htmlspecialchars($app['phone']); ?></em>
        <em><strong>Gender:</strong> <?= htmlspecialchars($app['gender']); ?></em>
        <em><strong>Date of Birth:</strong> <?= htmlspecialchars($app['dob']); ?></em>
        <em><strong>City:</strong> <?= htmlspecialchars($app['city']); ?></em>
        <em><strong>Education Level:</strong> <?= htmlspecialchars($app['education_level']); ?></em>
        <em><strong>Experience:</strong> <?= htmlspecialchars($app['experience']); ?></em>
        <div class="status-pill <?= $statusClass; ?>">
          Status: <?= ucfirst(htmlspecialchars($app['status'])); ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="no-applications">
    You have not applied to any jobs yet.
  </div>
<?php endif; ?>
