<?php
session_start();
include_once("config.php");

// Validate user session
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'job_seeker') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Job ID not specified.");
}

$job_id = (int)$_GET['id'];
$stmt = $conn->prepare("
    SELECT j.*, u.username AS employer_name
    FROM jobs j
    JOIN users u ON j.posted_by = u.id
    WHERE j.id = ?
");
$stmt->execute([$job_id]);
$job = $stmt->fetch();

if (!$job) {
    die("<p class='text-danger text-center mt-4'>Job not found.</p>");
}

// Initialize variables
$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect input
    $first_name  = trim($_POST['first_name']);
    $last_name   = trim($_POST['last_name']);
    $full_name   = "$first_name $last_name";
    $gender      = $_POST['gender'];
    $dob         = date('Y-m-d', strtotime("{$_POST['dob_year']}-{$_POST['dob_month']}-{$_POST['dob_day']}"));
    $city        = trim($_POST['city']);
    $phone       = trim($_POST['phone']);
    $email       = trim($_POST['email']);
    $education   = $_POST['education_level'];
    $experience  = $_POST['experience'];
    $resume_path = null;

    // Handle resume upload
    if (!empty($_FILES['resume']['name'])) {
        $allowed = ['pdf', 'doc', 'docx'];
        $ext = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $error = "Resume must be a PDF, DOC, or DOCX.";
        } elseif ($_FILES['resume']['size'] > 2 * 1024 * 1024) {
            $error = "Resume file must be under 2 MB.";
        } else {
            $upload_dir = __DIR__ . '/uploads/resumes/';
            if (!file_exists($upload_dir)) mkdir($upload_dir, 0755, true);

            $new_name = uniqid("resume_", true) . "." . $ext;
            $path = $upload_dir . $new_name;

            if (!move_uploaded_file($_FILES['resume']['tmp_name'], $path)) {
                $error = "Failed to upload resume.";
            } else {
                $resume_path = "uploads/resumes/$new_name";
            }
        }
    }

    // Insert application
    if (!$error) {
        $stmt = $conn->prepare("
            INSERT INTO applications 
            (user_id, job_id, full_name, email, phone, gender, city, dob, education_level, experience, applied_at, resume_path)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)
        ");
        $success = $stmt->execute([
            $_SESSION['user_id'], $job_id, $full_name, $email, $phone, $gender,
            $city, $dob, $education, $experience, $resume_path
        ]);

        if (!$success) {
            $error = "Application submission failed. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply – <?= htmlspecialchars($job['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .application-form {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        h1 { font-size: 28px; margin-bottom: 10px; }
        label { font-weight: 500; margin-top: 10px; }
    </style>
</head>
<body>

<div class="application-form">
    <a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">&larr; Back to Dashboard</a>

    <h1><?= htmlspecialchars($job['title']); ?> at <?= htmlspecialchars($job['company']); ?></h1>
    <p><strong>Employer:</strong> <?= htmlspecialchars($job['employer_name']); ?></p>
    <p><?= nl2br(htmlspecialchars($job['description'])); ?></p>

    <?php if ($success): ?>
        <div class="alert alert-success mt-3">✅ Your application has been submitted successfully!</div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger mt-3">❌ <?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if (!$success): ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <label>First Name *</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Last Name *</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
        </div>

        <label class="mt-3">Gender *</label>
        <select name="gender" class="form-select" required>
            <option value="">Select...</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
        </select>

        <label class="mt-3">Date of Birth *</label>
        <div class="row">
            <div class="col-md-4">
                <select name="dob_day" class="form-select" required>
                    <option value="">Day</option>
                    <?php for ($i = 1; $i <= 31; $i++) echo "<option>$i</option>"; ?>
                </select>
            </div>
            <div class="col-md-4">
                <select name="dob_month" class="form-select" required>
                    <option value="">Month</option>
                    <?php foreach (range(1,12) as $m) echo "<option>$m</option>"; ?>
                </select>
            </div>
            <div class="col-md-4">
                <select name="dob_year" class="form-select" required>
                    <option value="">Year</option>
                    <?php for ($y = date('Y') - 16; $y >= date('Y') - 65; $y--) echo "<option>$y</option>"; ?>
                </select>
            </div>
        </div>

        <label class="mt-3">City *</label>
        <input type="text" name="city" class="form-control" required>

        <label class="mt-3">Phone *</label>
        <input type="text" name="phone" class="form-control" required>

        <label class="mt-3">Email *</label>
        <input type="email" name="email" class="form-control" required>

        <label class="mt-3">Education Level *</label>
        <select name="education_level" class="form-select" required>
            <option value="">Select...</option>
            <option>High School</option>
            <option>Bachelor's</option>
            <option>Master's</option>
            <option>PhD</option>
            <option>Other</option>
        </select>

        <label class="mt-3">Experience *</label>
        <div>
            <?php foreach (['More than 5 years','3 - 5 years','1 - 3 years','Less than 1 year','No experience'] as $exp): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="experience" value="<?= $exp ?>" required>
                    <label class="form-check-label"><?= $exp ?></label>
                </div>
            <?php endforeach; ?>
        </div>

        <label class="mt-3">Upload Resume (PDF, DOC, DOCX – Max 2MB)</label>
        <input type="file" name="resume" class="form-control">

        <button type="submit" class="btn btn-primary mt-4 w-100">Submit Application</button>
    </form>
    <?php endif; ?>
</div>

</body>
</html>
