<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
      color: inherit;
      /* inherit text color */
      text-decoration: none;
      height: 100%;
    }

    a.job-link:hover {
      color: #8f7a4e;
      /* same hover color as before */
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


  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = trim($_POST['personality'] ?? '');

    if (empty($input)) {
      echo "Please enter a personality description.";
      exit;
    }

    // 1. Connect to the database
    $conn = new mysqli("localhost", "root", "", "hirehub");

    if ($conn->connect_error) {
      die("Database connection failed: " . $conn->connect_error);
    }

    // 2. Fetch job info
    $sql = "SELECT id, title, company, image, category, posted_by, created_at, location, description FROM jobs";
    $result = $conn->query($sql);

    if (!$result || $result->num_rows === 0) {
      echo "No job titles found in the database.";
      exit;
    }

    $jobMap = [];
    foreach ($result as $row) {
      $jobMap[$row['title']] = [
        'id' => $row['id'],
        'company' => $row['company'],
        'image' => $row['image'],
        'category' => $row['category'],
        'location' => $row['location'],
        'posted_by' => $row['posted_by'],
        'created_at' => $row['created_at'],
        'description' => $row['description']
      ];
    }

    $jobText = implode(", ", array_keys($jobMap));

    // 3. Build AI prompt
    $prompt = "Based on this personality description, suggest the most suitable careers ONLY from the following list:\n\n" .
      $jobText . "\n\n" .
      "Personality Description:\n" . $input;

    // 4. OpenAI API call
    $apiKey = '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'; // Keep this secure!
    $url = 'https://api.openai.com/v1/chat/completions';

    $data = [
      "model" => "gpt-4o-mini",
      "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant that suggests career paths based ONLY on a provided job list."],
        ["role" => "user", "content" => $prompt],
      ],
      "max_tokens" => 256,
      "temperature" => 0.7,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Content-Type: application/json",
      "Authorization: Bearer $apiKey"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    if (!isset($result['choices'][0]['message']['content'])) {
      echo "No response from OpenAI API.";
      exit;
    }

    $reply = $result['choices'][0]['message']['content'];

    // 5. Extract AI-suggested titles
    $matchedJobs = [];
    foreach ($jobMap as $title => $details) {
      if (stripos($reply, $title) !== false) {
        $matchedJobs[] = array_merge(['title' => $title], $details);
      }
    }



    // 6. Show AI suggestions as job cards
    echo "<div class='container'>";
    echo "<h2>Your Career Suggestions</h2>";

    if (empty($matchedJobs)) {
      echo "<p>No exact matches found. AI Response:</p><pre>" . htmlspecialchars($reply) . "</pre>";
    } else {
      foreach ($matchedJobs as $job) {
        echo '<div class="col-md-4 d-flex">
        <a href="view-job.php?id=' . urlencode($job['id']) . '" class="job-link">
          <div class="card job-card flex-fill shadow-sm rounded-3 border-0">
            <div class="card-body d-flex flex-column">
              <div class="d-flex align-items-center mb-3">
                <img
                  src="' . htmlspecialchars($job['image'] ?? 'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=60&h=60&fit=crop') . '"
                  alt="Company Logo" class="job-logo rounded-circle me-3 shadow-sm" />

                <div>
                  <h5 class="card-title mb-1 text-truncate" title="' . htmlspecialchars($job['title']) . '">
                    ' . htmlspecialchars($job['title']) . '
                  </h5>
                  <small class="text-muted d-block text-truncate"
                    title="' . htmlspecialchars($job['company']) . '">
                    ' . htmlspecialchars($job['company']) . '
                  </small>
                </div>
              </div>

              <p class="card-text text-secondary mb-3 flex-grow-1"
                style="min-height: 60px; overflow: hidden; text-overflow: ellipsis;">'
          . htmlspecialchars(substr($job['description'] ?? 'No description available', 0, 100))
          . (strlen($job['description'] ?? '') > 100 ? '...' : '') . '
              </p>

              <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <span class="badge bg-success">' . htmlspecialchars($job['category'] ?? 'Uncategorized') . '</span>
                <span class="text-muted small">' . htmlspecialchars($job['location'] ?? 'Location not specified') . '</span>
              </div>

              <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-auto">
                <small class="text-muted">
                  Posted by <strong>' . htmlspecialchars($job['employer_name'] ?? 'Unknown employer') . '</strong><br>';

        if (!empty($job['created_at'])) {
          echo '<time datetime="' . htmlspecialchars(date("Y-m-d", strtotime($job['created_at']))) . '">'
            . date("F j, Y", strtotime($job['created_at'])) .
            '</time>';
        } else {
          echo 'Date not available';
        }

        echo '</small>
                <span class="badge bg-primary px-3 py-2 rounded-pill">Full-Time</span>
              </div>
            </div>
          </div>
        </a>
      </div>';
        ;
      }
    }

    echo "</div>";
  }
  ?>


</head>

<body>

</body>
<!-- Optional Bootstrap JavaScript Bundle with Popper (add before </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+0I3RqFwS43Q8df5W4Ud4vJbXhTOe" crossorigin="anonymous"></script>

</html>

