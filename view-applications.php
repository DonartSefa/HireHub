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

<h2 class="page-heading">Applications to My Jobs</h2>

<?php if (count($applications) > 0): ?>
  <?php foreach ($applications as $app): ?>
    <div class="application-card" title="<?= htmlspecialchars($app['job_title']); ?>">
      <div class="job-info">
        <h3 class="job-title"><?= htmlspecialchars($app['job_title']); ?></h3>
        <p class="job-company"><?= htmlspecialchars($app['company']); ?> — <?= htmlspecialchars($app['location']); ?></p>
      </div>

      <div class="application-details">
        <div class="applicant-info">
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

        <!-- Resume section -->
        <div class="resume-section">
          <?php if (!empty($app['resume_path'])): ?>
            <a href="<?= htmlspecialchars($app['resume_path']); ?>" class="resume-link" download>Download Resume</a>
          <?php else: ?>
            <span class="no-resume">No resume uploaded</span>
          <?php endif; ?>
        </div>
      </div>

      <div class="status-action">
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
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="no-applications">
    No one has applied to your jobs yet.
  </div>
<?php endif; ?>

<style>
  /* Overall Page */
  body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    margin: 0;
    padding: 20px;
  }

  .page-heading {
    color: #3b4d61;
    font-size: 2rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 40px;
  }

  /* Application Card */
  .application-card {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-left: 8px solid #ff7f50;
    transition: box-shadow 0.3s ease-in-out;
  }

  .application-card:hover {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
  }

  .job-info {
    margin-bottom: 20px;
  }

  .job-title {
    color: #ff7f50;
    font-weight: 600;
    font-size: 1.4rem;
    margin: 0;
  }

  .job-company {
    color: #7a7a7a;
    font-size: 1.1rem;
    font-style: italic;
  }

  .application-details {
    margin-top: 20px;
  }

  .applicant-info {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 20px;
  }

  .resume-section {
    margin-top: 10px;
  }

  .resume-link {
    font-weight: bold;
    color: #1e90ff;
    font-size: 1rem;
    text-decoration: none;
    padding: 10px;
    border-radius: 6px;
    background-color: #f0f8ff;
    display: inline-block;
    transition: background-color 0.3s;
  }

  .resume-link:hover {
    background-color: #d9e9f8;
    text-decoration: underline;
  }

  .no-resume {
    color: #d9534f;
    font-style: italic;
  }

  .status-label {
    font-size: 1.1rem;
    font-weight: bold;
    margin-top: 20px;
  }

  .status-approved {
    color: #28a745;
  }

  .status-denied {
    color: #dc3545;
  }

  .status-pending {
    color: #ffc107;
  }

  .status-action {
    margin-top: 20px;
  }

  .action-buttons button {
    padding: 8px 20px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px;
    transition: all 0.3s ease;
  }

  .approve-btn {
    background-color: #28a745;
    color: white;
  }

  .deny-btn {
    background-color: #dc3545;
    color: white;
  }

  .approve-btn:hover {
    background-color: #218838;
  }

  .deny-btn:hover {
    background-color: #c82333;
  }

  .no-applications {
    text-align: center;
    font-size: 1.2rem;
    color: #777;
    margin-top: 40px;
  }
</style>
