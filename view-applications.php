<?php
session_start();
include_once("config.php");

// Only allow employers to view this
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    echo "<p style='color:red;'>Unauthorized access.</p>";
    exit;
}

$employer_id = $_SESSION['user_id'];

// Get all applications to jobs posted by this employer
$stmt = $conn->prepare("
    SELECT a.*, j.title AS job_title, j.company, j.location, u.username
    FROM applications a
    JOIN jobs j ON a.job_id = j.id
    JOIN users u ON a.user_id = u.id
    WHERE j.posted_by = ?
    ORDER BY a.applied_at DESC
");
$stmt->execute([$employer_id]);
$applications = $stmt->fetchAll();
?>

<h2 style="color:#f47f4c; font-weight:700; margin-bottom: 30px;">Applications to My Jobs</h2>

<style>
  .application-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    border-left: 6px solid #4ca1f4;
    transition: box-shadow 0.3s ease;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .application-card:hover {
    box-shadow: 0 8px 20px rgba(76,161,244,0.25);
  }
  .job-title {
    color: #4ca1f4;
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
  .status-label {
    margin-top: 10px;
    font-weight: bold;
  }
  .status-pending {
    color: orange;
  }
  .status-approved {
    color: green;
  }
  .status-denied {
    color: red;
  }
  .action-buttons {
    margin-top: 15px;
  }
  .action-buttons button {
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    margin-right: 10px;
  }
  .approve-btn {
    background: #28a745;
    color: white;
  }
  .deny-btn {
    background: #dc3545;
    color: white;
  }
  .no-applications {
    color: #777;
    font-style: italic;
    margin-top: 30px;
    text-align: center;
  }
</style>

<?php if (count($applications) > 0): ?>
  <?php foreach ($applications as $app): ?>
    <div class="application-card" title="<?= htmlspecialchars($app['job_title']); ?>">
      <h3 class="job-title"><?= htmlspecialchars($app['job_title']); ?></h3>
      <div class="job-company">
        at <?= htmlspecialchars($app['company']); ?> — <?= htmlspecialchars($app['location']); ?>
      </div>
      <div class="application-info">
        <em><strong>Applicant:</strong> <?= htmlspecialchars($app['full_name']); ?> (<?= htmlspecialchars($app['username']); ?>)</em>
        <em><strong>Email:</strong> <?= htmlspecialchars($app['email']); ?></em>
        <em><strong>Phone:</strong> <?= htmlspecialchars($app['phone']); ?></em>
        <em><strong>Gender:</strong> <?= htmlspecialchars($app['gender']); ?></em>
        <em><strong>Date of Birth:</strong> <?= htmlspecialchars($app['dob']); ?></em>
        <em><strong>City:</strong> <?= htmlspecialchars($app['city']); ?></em>
        <em><strong>Education Level:</strong> <?= htmlspecialchars($app['education_level']); ?></em>
        <em><strong>Experience:</strong> <?= htmlspecialchars($app['experience']); ?></em>
        <em><strong>Applied On:</strong> <?= date("F j, Y, g:i a", strtotime($app['applied_at'])); ?></em>
      </div>

      <p class="status-label">
        Status:
        <?php if ($app['status'] === 'approved'): ?>
          <span class="status-approved">Approved</span>
        <?php elseif ($app['status'] === 'denied'): ?>
          <span class="status-denied">Denied</span>
        <?php else: ?>
          <span class="status-pending">Pending</span>
        <?php endif; ?>
      </p>

      <form method="POST" action="update_application_status.php" class="action-buttons">
        <input type="hidden" name="application_id" value="<?= $app['id']; ?>">
        <button type="submit" name="status" value="approved" class="approve-btn">Approve</button>
        <button type="submit" name="status" value="denied" class="deny-btn">Deny</button>
      </form>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="no-applications">
    No one has applied to your jobs yet.
  </div>
<?php endif; ?>
