<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'job_seeker') {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Job ID not specified.");
}

$job_id = $_GET['id'];

$stmt = $conn->prepare("SELECT jobs.*, users.username AS employer_name FROM jobs JOIN users ON jobs.posted_by = users.id WHERE jobs.id = ?");
$stmt->execute([$job_id]);
$job = $stmt->fetch();

if (!$job) {
    die("Job not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title><?php echo htmlspecialchars($job['title']); ?> - HireHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px 0 60px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .job-header {
            display: flex;
            align-items: center;
            gap: 20px;
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
            margin-bottom: 35px;
        }

        .job-header img {
            width: 130px;
            height: 130px;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgb(0 0 0 / 0.1);
        }

        .job-header-content h1 {
            margin: 0 0 10px;
            font-size: 1.9rem;
            color: #f47f4c;
            font-weight: 700;
        }

        .job-header-content h4 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #555;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            font-size: 14px;
            color: #666;
            text-decoration: none;
            margin-top: 10px;
            transition: color 0.25s ease;
        }

        .back-link svg {
            margin-right: 6px;
        }

        .back-link:hover {
            color: #f47f4c;
        }

        .form-wrapper {
            background-color: #fff;
            padding: 30px 35px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgb(0 0 0 / 0.07);
        }

        .form-wrapper h3 {
            font-size: 1.8rem;
            margin-bottom: 25px;
            border-bottom: 3px solid #f04e23;
            padding-bottom: 8px;
            color: #333;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-row > div {
            flex: 1;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #444;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #f47f4c;
            box-shadow: 0 0 6px rgba(244, 127, 76, 0.5);
        }

        .radio-group {
            margin-top: 8px;
        }

        .radio-group label {
            font-weight: normal;
            margin-bottom: 10px;
            display: block;
            cursor: pointer;
        }

        .radio-group input[type="radio"] {
            margin-right: 8px;
            cursor: pointer;
        }

        .submit-btn {
            background-color: #f04e23;
            color: white;
            padding: 14px 30px;
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            max-width: 300px;
            display: block;
            margin: 30px auto 0;
        }

        .submit-btn:hover {
            background-color: #d7411e;
        }

        .success-message {
            color: #2d7a2d;
            font-weight: 600;
            text-align: center;
            margin-top: 25px;
            font-size: 1.2rem;
        }

        .footer-links {
            margin-top: 40px;
            text-align: center;
            font-size: 15px;
        }

        .footer-links a {
            color: #f47f4c;
            text-decoration: none;
            margin: 0 15px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #d7411e;
        }

        @media (max-width: 768px) {
            .job-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .form-row {
                flex-direction: column;
            }

            .submit-btn {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="job-header">
            <img src="<?php echo htmlspecialchars($job['image']); ?>" alt="Job Image" />
            <div class="job-header-content">
                <h1>You are applying to <?php echo htmlspecialchars($job['company']); ?></h1>
                <h4><?php echo htmlspecialchars($job['category']); ?></h4>
                <a href="browse-jobs.php" class="back-link" title="Go back to job listings">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#666" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    Back to Job Listings
                </a>
            </div>
        </div>

        <div class="form-wrapper">
            <form action="applyJobLogic.php" method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">

                <h3>Personal Information</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name *</label>
                        <input type="text" id="first_name" name="first_name" required placeholder="John" />
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name *</label>
                        <input type="text" id="last_name" name="last_name" required placeholder="Doe" />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="gender">Gender *</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth *</label>
                        <div class="form-row" style="gap: 10px;">
                            <select name="dob_day" required aria-label="Day">
                                <option value="">Day</option>
                                <?php for ($d = 1; $d <= 31; $d++) echo "<option>$d</option>"; ?>
                            </select>
                            <select name="dob_month" required aria-label="Month">
                                <option value="">Month</option>
                                <?php
                                $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                                foreach ($months as $m) echo "<option>$m</option>";
                                ?>
                            </select>
                            <select name="dob_year" required aria-label="Year">
                                <option value="">Year</option>
                                <?php for ($y = date('Y') - 65; $y <= date('Y') - 16; $y++) echo "<option>$y</option>"; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="city">City *</label>
                        <input type="text" id="city" name="city" required placeholder="Your city" />
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="text" id="phone" name="phone" required placeholder="+1 234 567 8900" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required placeholder="you@example.com" />
                </div>

                <h3>Education</h3>
                <div class="form-group">
                    <label for="education_level">Education Level *</label>
                    <select id="education_level" name="education_level" required>
                        <option value="">Select education level</option>
                        <option value="High School">High School</option>
                        <option value="Bachelor's">Bachelor's</option>
                        <option value="Master's">Master's</option>
                        <option value="PhD">PhD</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <h3>Work Experience</h3>
                <div class="form-group">
                    <label>How many years of experience do you have in this field?</label>
                    <div class="radio-group">
                        <label><input type="radio" name="experience" value="More than 5 years" required> More than 5 years</label>
                        <label><input type="radio" name="experience" value="3 - 5 years"> 3 - 5 years</label>
                        <label><input type="radio" name="experience" value="1 - 3 years"> 1 - 3 years</label>
                        <label><input type="radio" name="experience" value="Less than 1 year"> Less than 1 year</label>
                        <label><input type="radio" name="experience" value="No experience"> No experience</label>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Submit Application</button>
            </form>
        </div>

        <?php if (isset($_GET['applied'])): ?>
            <p class="success-message">Application submitted successfully!</p>
        <?php endif; ?>

        <div class="footer-links">

            <a href="dashboard.php">Back to Dashboard</a>
        </div>
    </div>
</body>

</html>
