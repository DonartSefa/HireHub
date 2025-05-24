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
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Roboto', sans-serif;
    }

    .header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 20px;
      border-bottom: 1px solid #eee;
    }

    .logo {
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 30px;
      margin-right: 8px;
    }

    .nav {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .nav a {
      text-decoration: none;
      color: #222;
      font-size: 14px;
    }

    .nav .dropdown::after {
      content: '▼';
      font-size: 10px;
      margin-left: 4px;
    }

    .icons {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .profile-button {
      background-color: #fcbfa4;
      border: none;
      padding: 8px 14px;
      border-radius: 4px;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }

    .icon {
      font-size: 16px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="header">
    <div class="logo">
      <img src="logo.png" alt="KosovaJob Logo" />
      <strong>KOSOVAJOB</strong>
    </div>
    <nav class="nav">
      <a href="#">THIRRJET PËR APLIKIME</a>
      <a href="#">BLOG</a>
      <a href="#">PUBLIKO KONKURS</a>
      <a href="#">KONTAKT</a>
      <a href="#" class="dropdown">PRODUKTET</a>
      <a href="#">EN</a>
    </nav>
    <div class="icons">
      <span class="icon">🔔</span>
      <span class="icon">🔍</span>
      <button class="profile-button">PROFILI IM</button>
    </div>  
  </header>
  </div>

</body>
</html>



  <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

  <?php if ($user_type === 'employer'): ?>
    <p><a href="employer-dashboard.php">Go to Employer Dashboard</a></p>
    <p><a href="post-job.php">Post a New Job</a></p>
  <?php elseif ($user_type === 'job_seeker'): ?>
    <p><a href="browse-jobs.php">Browse Jobs</a></p>
    <p><a href="my-applications.php">My Applications</a></p>
  <?php else: ?>
    <p>User type unknown.</p>
  <?php endif; ?>

  <p><a href="logout.php">Logout</a></p>
</body>
</html>
