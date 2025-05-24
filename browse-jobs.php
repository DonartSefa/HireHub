<?php
// session_start();
// include_once("config.php");

// if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'job_seeker') {
//     header("Location: login.php");
//     exit;
// }

$stmt = $conn->query("SELECT jobs.*, users.username AS employer_name FROM jobs JOIN users ON jobs.posted_by = users.id ORDER BY created_at DESC");
$jobs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Browse Jobs - HireHub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <style>
    .job-card {
      display: flex;
      flex-direction: column;
      height: 100%;
      border: 1px solid #dee2e6;
      transition: all 0.3s ease-in-out;
    }

    .job-card:hover {
      border-color: #8f7a4e;
      box-shadow: 0 6px 20px rgba(143, 122, 78, 0.2);
      transform: translateY(-2px);
    }

    .job-card:hover a {
      color: #8f7a4e !important;
    }

    .job-logo {
      width: 60px;
      height: 60px;
      object-fit: contain;
      border-radius: 8px;
      background: #f8f9fa;
    }

    .text-truncate {
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }
  </style>
</head>

<body>
  <div class="container my-5">

    <?php if (count($jobs) > 0): ?>
      <div class="row g-4">
        <?php foreach ($jobs as $job): ?>
          <div class="col-md-4 d-flex">
            <div class="card job-card flex-fill shadow-sm rounded-3 border-0">
              <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                  <img
                    src="<?php echo htmlspecialchars($job['image'] ?? 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=60&h=60&fit=crop'); ?>"
                    alt="Company Logo" class="job-logo rounded-circle me-3 shadow-sm" />

                  <div>
                    <h5 class="card-title mb-1 text-truncate" title="<?php echo htmlspecialchars($job['title']); ?>">
                      <a href="view-job.php?id=<?php echo $job['id']; ?>"
                        class="text-decoration-none text-primary fw-semibold">
                        <?php echo htmlspecialchars($job['title']); ?>
                      </a>
                    </h5>
                    <small class="text-muted d-block text-truncate"
                      title="<?php echo htmlspecialchars($job['company']); ?>">
                      <?php echo htmlspecialchars($job['company']); ?>
                    </small>
                  </div>
                </div>

                <p class="card-text text-secondary mb-3 flex-grow-1"
                  style="min-height: 60px; overflow: hidden; text-overflow: ellipsis;">
                  <?php echo htmlspecialchars(substr($job['description'], 0, 100)) . (strlen($job['description']) > 100 ? '...' : ''); ?>
                </p>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                  <span class="badge bg-success"><?php echo htmlspecialchars($job['category']); ?></span>
                  <span class="text-muted small"><?php echo htmlspecialchars($job['location']); ?></span>
                </div>

                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                  <small class="text-muted">
                    Posted by <strong><?php echo htmlspecialchars($job['employer_name']); ?></strong><br>
                    <time datetime="<?php echo htmlspecialchars(date("Y-m-d", strtotime($job['created_at']))); ?>">
                      <?php echo date("F j, Y", strtotime($job['created_at'])); ?>
                    </time>
                  </small>
                  <span class="badge bg-primary px-3 py-2 rounded-pill">Full-Time</span>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">No jobs available at the moment.</div>
    <?php endif; ?>
  </div>


  </div>
</body>

</html>