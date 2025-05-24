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
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="job-details">
        <div class="job-card">
            <div class="image">
                <img src="<?php echo htmlspecialchars($job['image']); ?>" alt="Job Image" style="width: 100%; border-radius: 10px;" />

            </div>
            <div class="j-cont">
                <h3 class="applying-text">You are applying in <?php echo htmlspecialchars($job['company']); ?></h3>
                <h3 class="job-title"><?php echo htmlspecialchars($job['category']); ?></h3>
            </div>
            <div class="b-app">
                <a href="browse-jobs.php" class="back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    Go back to Application
                </a>
            </div>
        </div>
    </div>



    <style>
        .job-details,
        .job-card,
        .applying-text,
        .job-title,
        .back-link {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .applying-text {
            font-size: 18px;
            font-weight: 600;
            color: #f47f4c;
            margin: 0 0 4px;
        }

        .job-title {
            font-size: 15px;
            font-weight: 500;
            color: #333;
            margin: 0;
        }

        .back-link {
            display: flex;
            align-items: center;
            font-size: 13px;
            color: #666;
            text-decoration: none;
            gap: 6px;
        }

        .back-link:hover {
            color: #f47f4c;
        }

        .job-details {
            display: flex;
            justify-content: center;
            padding: 30px 0;
        }

        .job-card {
            display: flex;
            align-items: center;
            background-color: #f7f7f7;
            padding: 20px 25px;
            border-radius: 10px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            gap: 20px;
        }

        .image img {
            width: 130px;
            height: auto;
            border-radius: 6px;
        }

        .j-cont {
            flex-grow: 1;
            margin-left: 15px;
        }

        .applying-text {
            font-size: 18px;
            font-weight: 600;
            color: #f47f4c;
            margin: 0 0 5px;
        }

        .job-title {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .b-app {
            margin-left: auto;
        }

        .back-link {
            font-size: 14px;
            color: #666;
            text-decoration: none;
        }

        .back-link:hover {
            color: #f47f4c;
        }

        .form-wrapper {
            max-width: 750px;
            margin: 40px auto;
            padding: 30px;
            border: 1px solid #ccc;
            background-color: #fafafa;
            border-radius: 10px;
            font-family: Arial, sans-serif;
        }

        .form-wrapper h3 {
            font-size: 22px;
            margin-bottom: 20px;
            border-bottom: 2px solid #f04e23;
            padding-bottom: 5px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row>div {
            flex: 1;
        }

        .radio-group {
            margin-top: 10px;
        }

        .radio-group label {
            display: block;
            font-weight: normal;
            margin-bottom: 8px;
        }

        .submit-btn {
            background-color: #f04e23;
            color: white;
            padding: 12px 25px;
            border: none;
            font-weight: bold;
            font-size: 15px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

    <div class="form-wrapper">
        <form action="applyJobLogic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">

            <h3>Personal Information</h3>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name *</label>
                    <input type="text" name="first_name" required>
                </div>
                <div class="form-group">
                    <label>Last Name *</label>
                    <input type="text" name="last_name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Gender *</label>
                    <select name="gender" required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date of Birth *</label>
                    <div class="form-row">
                        <select name="dob_day" required>
                            <option value="">Day</option>
                            <?php for ($d = 1; $d <= 31; $d++)
                                echo "<option>$d</option>"; ?>
                        </select>
                        <select name="dob_month" required>
                            <option value="">Month</option>
                            <?php
                            $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                            foreach ($months as $m)
                                echo "<option>$m</option>";
                            ?>
                        </select>
                        <select name="dob_year" required>
                            <option value="">Year</option>
                            <?php for ($y = date('Y') - 65; $y <= date('Y') - 16; $y++)
                                echo "<option>$y</option>"; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>City *</label>
                    <input type="text" name="city" required>
                </div>
                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="text" name="phone" required>
                </div>
            </div>

            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email" required>
            </div>

            <h3>Education</h3>
            <div class="form-group">
                <label>Education Level *</label>
                <select name="education_level" required>
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
                    <label><input type="radio" name="experience" value="More than 5 years" required> More than 5
                        years</label>
                    <label><input type="radio" name="experience" value="3 - 5 years"> 3 - 5 years</label>
                    <label><input type="radio" name="experience" value="1 - 3 years"> 1 - 3 years</label>
                    <label><input type="radio" name="experience" value="Less than 1 year"> Less than 1 year</label>
                    <label><input type="radio" name="experience" value="No experience"> No experience</label>
                </div>
            </div>



            <div class="form-group">
                <button type="submit" class="submit-btn">Submit Application</button>
            </div>
        </form>
    </div>

    <?php if (isset($_GET['applied'])): ?>
        <p style="color: green;">Application submitted successfully!</p>
    <?php endif; ?>

    <p><a href="browse-jobs.php">Back to Job Listings</a></p>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>

</html>