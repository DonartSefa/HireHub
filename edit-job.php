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
  <title>Edit Job - KosovaJob</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

    body {
      font-family: 'Inter', sans-serif;
      background-color: #f6f6f3;
      max-width: 700px;
      margin: 40px auto;
      padding: 0 20px 50px;
      color: #333;
    }

    h2 {
      color: #846c3b;
      font-weight: 700;
      font-size: 2rem;
      text-align: center;
      margin-bottom: 25px;
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

    .message {
      max-width: 600px;
      margin: 15px auto;
      padding: 12px 18px;
      border-radius: 8px;
      font-weight: 600;
      text-align: center;
      box-shadow: 0 4px 8px rgba(132,108,59,0.15);
    }

    .error {
      background-color: #fbeaea;
      color: #b72c2c;
      border: 1px solid #b72c2c;
    }

    .success {
      background-color: #e6f2e6;
      color: #2d7a2d;
      border: 1px solid #2d7a2d;
    }

    form {
      background: white;
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(132,108,59,0.12);
      max-width: 700px;
      margin: 0 auto;
    }

    label {
      display: block;
      font-weight: 600;
      margin-bottom: 8px;
      color: #554a1e;
    }

    input[type="text"],
    textarea {
      width: 100%;
      padding: 12px 14px;
      border: 1.8px solid #cfcfcf;
      border-radius: 10px;
      font-size: 1rem;
      font-family: 'Inter', sans-serif;
      color: #333;
      resize: vertical;
      transition: border-color 0.3s ease;
      box-sizing: border-box;
      margin-bottom: 20px;
    }

    input[type="text"]:focus,
    textarea:focus {
      border-color: #846c3b;
      outline: none;
      box-shadow: 0 0 6px rgba(132,108,59,0.3);
    }

    button[type="submit"] {
      background-color: #846c3b;
      color: white;
      font-weight: 700;
      padding: 14px 0;
      border: none;
      border-radius: 14px;
      width: 100%;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-shadow: 0 6px 15px rgba(132,108,59,0.3);
    }

    button[type="submit"]:hover {
      background-color: #6c552f;
      box-shadow: 0 8px 20px rgba(108,85,47,0.5);
    }
  </style>
</head>
<body>

  <h2>Edit Job</h2>

  <p class="back-link"><a href="employer-dashboard.php">← Back to My Jobs</a></p>

  <?php if ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <?php if ($success): ?>
    <div class="message success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <form action="edit-job.php?id=<?= $job_id ?>" method="post" novalidate>
    <label for="title">Job Title:</label>
    <input type="text" id="title" name="title" value="<?= htmlspecialchars($job['title']) ?>" required />

    <label for="company">Company:</label>
    <input type="text" id="company" name="company" value="<?= htmlspecialchars($job['company']) ?>" required />

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" value="<?= htmlspecialchars($job['location']) ?>" required />

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="<?= htmlspecialchars($job['category']) ?>" required />

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="6" required><?= htmlspecialchars($job['description']) ?></textarea>

    <button type="submit">Update Job</button>
  </form>

</body>
</html>
