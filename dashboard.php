<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_type = $_SESSION['user_type'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="sq">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KosovaJob Header</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #f9f9f9;
      padding-top: 80px; /* Make sure content doesn't get hidden behind fixed header */
    }

    /* Fixed header at top */
    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;

      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 40px;

      background-color: #f6f6f3;
      border-bottom: 1px solid #e0e0e0;
      box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .logo {
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 38px;
      scale: 1.7;
    }

    .nav {
      display: flex;
      gap: 28px;
      align-items: center;
    }

    .nav a {
      text-decoration: none;
      font-weight: 500;
      font-size: 14px;
      color: #333;
      transition: color 0.25s ease;
      position: relative;
    }

    .nav a::after {
      content: '';
      position: absolute;
      width: 0%;
      height: 2px;
      left: 0;
      bottom: -5px;
      background-color: #846c3b;
      transition: width 0.25s ease;
    }

    .nav a:hover {
      color: #846c3b;
    }

    .nav a:hover::after {
      width: 100%;
    }

    .icons {
      display: flex;
      align-items: center;
      gap: 18px;
    }

    .icon {
      font-size: 20px;
      cursor: pointer;
      transition: transform 0.2s;
      user-select: none;
    }

    .icon:hover {
      transform: scale(1.15);
    }

    .profile-button {
      background-color: #846c3b;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
      font-size: 14px;
      transition: background-color 0.3s ease;
    }

    .profile-button:hover {
      background-color: #6c552f;
    }

    .container3 {
      max-width: 100%;
      margin: 0 auto;
    }

    a.logout-link {
      display: block;
      text-align: right;
      padding: 15px 40px;
      font-size: 14px;
      text-decoration: none;
      color: #999;
      transition: color 0.2s;
    }

    a.logout-link:hover {
      color: #846c3b;
    }
  </style>
</head>
<body>

<div class="container3">
  <header class="header">
    <div class="logo">
      <a href="dashboard.php"><img src="jobhorizon.png" alt="KosovaJob Logo" /></a>
    </div>
    <nav class="nav">
      <?php if ($user_type === 'employer'): ?>
        <a href="post-job.php">Post a Job</a>
        <a href="employer-dashboard.php">Your Posts</a>
      <?php elseif ($user_type === 'job_seeker'): ?>
        <a href="my-applications.php">Applications</a>
        <a href="employer-dashboard.php">Your Posts</a>
      <?php endif; ?>
      <a href="#">Kontakt</a>
      <a href="#" class="dropdown">Produktet ▼</a>
      <a href="#">EN</a>
    </nav>
    <div class="icons">
      <span class="icon" title="Search">🔍</span>
      <button class="profile-button"><?= htmlspecialchars($username) ?></button>
    </div>
  </header>
</div>

<?php if ($user_type === 'job_seeker'): ?>
  <?php include_once 'browse-jobs.php'; ?>
<?php endif; ?>

<a href="logout.php" class="logout-link">Logout</a>

</body>
</html>
