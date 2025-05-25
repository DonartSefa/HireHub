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

    /* Make the entire card clickable without affecting styling */
    a.job-link {
      display: block;
      color: inherit; /* inherit text color */
      text-decoration: none;
      height: 100%;
    }

    a.job-link:hover {
      color: #8f7a4e; /* same hover color as before */
      text-decoration: none;
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
    
</body>
</html>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include_once("config.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}

$query = trim($_POST['query'] ?? '');

if (empty($query)) {
    echo '<p class="no-jobs">Please enter a search query.</p>';
    exit;
}

// Split query into words, remove empty ones
$keywords = array_filter(preg_split('/\s+/', strtolower($query)));

if (count($keywords) === 0) {
    echo '<p class="no-jobs">Please enter a valid search query.</p>';
    exit;
}

// Build WHERE clause dynamically
$whereParts = [];
$params = [];
foreach ($keywords as $index => $word) {
    $param = ":kw$index";
    $like = "%$word%";
    $whereParts[] = "(LOWER(title) LIKE $param OR LOWER(description) LIKE $param OR LOWER(category) LIKE $param OR LOWER(company) LIKE $param OR LOWER(location) LIKE $param)";
    $params[$param] = $like;
}

$whereSql = implode(" OR ", $whereParts);

try {
    $sql = "SELECT jobs.*, users.username AS employer_name FROM jobs JOIN users ON jobs.posted_by = users.id WHERE $whereSql ORDER BY created_at DESC LIMIT 30";
    $stmt = $conn->prepare($sql);
    foreach ($params as $param => $value) {
        $stmt->bindValue($param, $value, PDO::PARAM_STR);
    }
    $stmt->execute();

    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$jobs) {
        echo '<p class="no-jobs">No jobs found matching your query: <strong>' . htmlspecialchars($query) . '</strong></p>';
        exit;
    }

    // Wrap jobs in a Bootstrap row with gutters
    echo '<div class="row g-4">';

    foreach ($jobs as $job) {
        ?>
        <div class="col-md-4 d-flex">
          <a href="view-job.php?id=<?php echo urlencode($job['id']); ?>" class="job-link" style="width: 100%;">
            <div class="card job-card flex-fill shadow-sm rounded-3 border-0 d-flex flex-column">
              <div class="card-body d-flex flex-column">
                <div class="d-flex align-items-center mb-3">
                  <img
                    src="<?php echo htmlspecialchars($job['image'] ?? 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=60&h=60&fit=crop'); ?>"
                    alt="Company Logo" class="job-logo rounded-circle me-3 shadow-sm" />

                  <div>
                    <h5 class="card-title mb-1 text-truncate" title="<?php echo htmlspecialchars($job['title']); ?>">
                      <?php echo htmlspecialchars($job['title']); ?>
                    </h5>
                    <small class="text-muted d-block text-truncate"
                      title="<?php echo htmlspecialchars($job['company']); ?>">
                      <?php echo htmlspecialchars($job['company']); ?>
                    </small>
                  </div>
                </div>

                <p class="card-text text-secondary mb-3 flex-grow-1"
                  style="min-height: 60px; overflow: hidden; text-overflow: ellipsis;">
                  <?php echo htmlspecialchars(mb_strimwidth($job['description'], 0, 100, '...')); ?>
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
          </a>
        </div>
        <?php
    }

    echo '</div>'; // close row

} catch (PDOException $e) {
    http_response_code(500);
    echo '<p class="no-jobs" style="color:red;">Database error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    exit;
}
?>
