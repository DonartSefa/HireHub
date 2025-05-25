<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$userId = $_SESSION['user_id'];
$userType = $_SESSION['user_type'] ?? '';

// Get username
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();
$username = $user ? $user['username'] : 'User';

// For employer, get a posted job ID if any
$jobId = 0;
$hasJob = false;
if ($userType === 'employer') {
  $jobQuery = $conn->prepare("SELECT id FROM jobs WHERE posted_by = ?" );
  $jobQuery->execute([$userId]);
  $jobData = $jobQuery->fetch();
  if ($jobData) {
    $jobId = (int)$jobData['id'];
    $hasJob = true;
  }
}

// Setup the "My Applications" onclick JS action based on user type and job availability
if ($userType === 'employer') {
  if ($hasJob) {
    $inboxJs = "loadApplications('view-applications.php?job_id=$jobId'); return false;";
  } else {
    // Employer has no posted jobs - show alert
    $inboxJs = "alert('You have no posted jobs yet, so no applications to view.'); return false;";
  }
} else {
  // For job seekers
  $inboxJs = "loadApplications('my-applications.php'); return false;";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard | HireHub</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* ... Your CSS styles here (same as your original) ... */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body, html { height: 100%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6fb; }

    .dashboard-container { display: flex; height: 100vh; }

    .sidebar {
      width: 240px;
      background-color: #0f1f3e;
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 20px;
      justify-content: space-between;
    }

    .logo h2 { font-size: 22px; margin-bottom: 30px; }
    .sidebar-menu { list-style: none; }
    .sidebar-menu li { margin: 18px 0; }
    .sidebar-menu a {
      color: #c5c7d0;
      text-decoration: none;
      font-size: 15px;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: color 0.2s;
      cursor: pointer;
    }
    .sidebar-menu a:hover { color: #fff; }
    .sidebar-footer a {
      display: block;
      color: #aab2c8;
      text-decoration: none;
      margin-top: 15px;
      font-size: 14px;
    }
    .sidebar-footer a:hover { color: #fff; }

    .main-content {
      flex: 1;
      padding: 20px 30px;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 15px rgb(0 0 0 / 0.1);
    }

    .top-bar {
      background-color: #fff;
      padding: 15px 25px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .top-bar h2 {
      font-size: 20px;
      font-weight: 600;
      color: #2c3e50;
    }

    .profile-pic img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 2px solid #ddd;
    }

    /* Job card styles for browse-jobs content */
    .job-card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgb(0 0 0 / 0.1);
      margin-bottom: 20px;
      padding: 20px;
      transition: box-shadow 0.3s ease;
    }
    .job-card:hover {
      box-shadow: 0 6px 20px rgb(0 0 0 / 0.15);
    }
    .job-title {
      font-weight: 700;
      color: #007bff;
      text-decoration: none;
    }
    .job-company-location {
      color: #555;
      font-size: 0.9rem;
      margin-bottom: 10px;
    }
    .job-description {
      color: #333;
      font-size: 0.95rem;
      margin-bottom: 10px;
      max-height: 60px;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .apply-btn {
      font-weight: 600;
      color: #fff;
      background-color: #007bff;
      border: none;
      padding: 8px 15px;
      border-radius: 6px;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s ease;
    }
    .apply-btn:hover {
      background-color: #0056b3;
      text-decoration: none;
      color: #fff;
    }
    .no-jobs, .no-applications {
      text-align: center;
      font-size: 1.2rem;
      color: #777;
      margin-top: 50px;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="logo">
        <h2>JobHorizon</h2>
      </div>
      <ul class="sidebar-menu">
        <li><a href="dashboard.php"><i class="fas fa-chart-pie"></i> Overview</a></li>
        <li><a href="#" onclick="<?= $inboxJs ?>"><i class="fas fa-inbox"></i> My Applications</a></li>
        <li><a href="#"><i class="fas fa-users-cog"></i> User Management</a></li>
        <li><a href="#" id="aiHelpBtn"><i class="fas fa-robot"></i> Need AI help?</a></li>
      </ul>
      <div class="sidebar-footer">
        <a href="#"><i class="fas fa-cog"></i> Settings</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="top-bar">
        <h2>Welcome, <?= htmlspecialchars($username); ?>!</h2>
        <div class="profile-pic">
          <img src="https://via.placeholder.com/40" alt="Profile" />
        </div>
      </div>

      <div id="dynamic-content">
        <?php 
          // Show job seeker browse jobs initially
          if ($userType === 'job_seeker') {
            include 'browse-jobs.php';
          } else {
            echo "<p>Use the Inbox menu to view your applications.</p>";
          }
        ?>
      </div>
    </div>

  </div>

  <!-- AI Help Modal -->
  <div class="modal fade" id="aiHelpModal" tabindex="-1" aria-labelledby="aiHelpModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="aiHelpModalLabel">AI Help</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Ask about jobs and we'll filter results for you.</p>
          <textarea id="aiQueryInput" rows="5" class="form-control" placeholder="Enter your question or keywords here..."></textarea>
          <button id="aiSendBtn" type="button" class="btn btn-primary mt-3">Send</button>
          <div id="aiHelpResponse" class="mt-3"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function loadApplications(url) {
      console.log("Loading applications from URL:", url);
      const container = document.getElementById('dynamic-content');
      container.innerHTML = "<p>Loading...</p>";

      fetch(url)
        .then(response => {
          if (!response.ok) throw new Error("Failed to load content.");
          return response.text();
        })
        .then(html => {
          container.innerHTML = html;
        })
        .catch(error => {
          container.innerHTML = `<p style="color:red;">${error.message}</p>`;
        });
    }

    function loadBrowseJobs() {
      const container = document.getElementById('dynamic-content');
      container.innerHTML = "<p>Loading jobs...</p>";

      fetch('browse-jobs-content.php')
        .then(response => {
          if (!response.ok) throw new Error("Failed to load jobs.");
          return response.text();
        })
        .then(html => {
          container.innerHTML = html;
        })
        .catch(error => {
          container.innerHTML = `<p style="color:red;">${error.message}</p>`;
        });
    }

    // Open AI Help Modal on sidebar click
    document.getElementById('aiHelpBtn').addEventListener('click', function(e) {
      e.preventDefault();
      var aiModal = new bootstrap.Modal(document.getElementById('aiHelpModal'));
      aiModal.show();

      // Clear previous inputs
      document.getElementById('aiQueryInput').value = "";
      document.getElementById('aiHelpResponse').innerHTML = "";
    });

    // Handle AI Send button click
    document.getElementById('aiSendBtn').addEventListener('click', function() {
      const query = document.getElementById('aiQueryInput').value.trim();
      const responseDiv = document.getElementById('aiHelpResponse');
      if (!query) {
        responseDiv.innerHTML = '<div class="alert alert-warning">Please enter a query.</div>';
        return;
      }
      responseDiv.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

      fetch('filter-jobs.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'query=' + encodeURIComponent(query)
      })
      .then(response => {
        if (!response.ok) throw new Error("Failed to fetch jobs.");
        return response.text();
      })
      .then(html => {
        responseDiv.innerHTML = '<div class="alert alert-success">Showing results for your query.</div>';
        document.getElementById('dynamic-content').innerHTML = html;
        setTimeout(() => {
          var aiModalEl = document.getElementById('aiHelpModal');
          var modal = bootstrap.Modal.getInstance(aiModalEl);
          modal.hide();
        }, 1500);
      })
      .catch(err => {
        responseDiv.innerHTML = `<div class="alert alert-danger">${err.message}</div>`;
      });
    });
  </script>
</body>
</html>
