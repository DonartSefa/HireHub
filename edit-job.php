<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header("Location: login.php");
    exit;
}

$employer_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    die("Job ID is required.");
}

$job_id = $_GET['id'];

// Fetch the job and check ownership
$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ? AND posted_by = ?");
$stmt->execute([$job_id, $employer_id]);
$job = $stmt->fetch();

if (!$job) {
    die("Job not found or you don't have permission to edit it.");
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $company = trim($_POST['company']);
    $location = trim($_POST['location']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);

    if (!$title || !$company || !$location || !$category || !$description) {
        $error = "All fields are required.";
    } else {
        $updateStmt = $conn->prepare("
            UPDATE jobs SET title = ?, company = ?, location = ?, category = ?, description = ?
            WHERE id = ? AND posted_by = ?
        ");
        $updated = $updateStmt->execute([$title, $company, $location, $category, $description, $job_id, $employer_id]);

        if ($updated) {
            $success = "Job updated successfully.";
            // Refresh job data after update
            $stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ? AND posted_by = ?");
            $stmt->execute([$job_id, $employer_id]);
            $job = $stmt->fetch();
        } else {
            $error = "Failed to update job. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Job - HireHub</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <h2>Edit Job</h2>

  <p><a href="employer-dashboard.php">Back to My Jobs</a></p>

  <?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <?php if ($success): ?>
    <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
  <?php endif; ?>

  <form action="edit-job.php?id=<?php echo $job_id; ?>" method="post">
    <label>Job Title:<br />
      <input type="text" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required />
    </label><br /><br />

    <label>Company:<br />
      <input type="text" name="company" value="<?php echo htmlspecialchars($job['company']); ?>" required />
    </label><br /><br />

    <label>Location:<br />
      <input type="text" name="location" value="<?php echo htmlspecialchars($job['location']); ?>" required />
    </label><br /><br />

    <label>Category:<br />
      <input type="text" name="category" value="<?php echo htmlspecialchars($job['category']); ?>" required />
    </label><br /><br />

    <label>Description:<br />
      <textarea name="description" rows="6" cols="50" required><?php echo htmlspecialchars($job['description']); ?></textarea>
    </label><br /><br />

    <button type="submit">Update Job</button>
  </form>
</body>
</html>
