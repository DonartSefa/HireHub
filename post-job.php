<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Post a Job - HireHub</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <h2>Post a New Job</h2>
    <form action="postJobLogic.php" method="POST">

        

        <label for="title">Job Title</label>
        <input type="text" name="title" required>

        <label for="company">Company Name</label>
        <input type="text" name="company" required>

        <label for="location">Location</label>
        <input type="text" name="location" required>

        <label for="category">Category</label>
        <input type="text" name="category" required>

        <label for="description">Job Description</label>
        <textarea name="description" rows="6" required></textarea>

        <button type="submit">Post Job</button>
    </form>

 <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for="image">Upload Image:</label>
            <input type="file" name="image" id="image" required>
            <button type="submit">Upload</button>
        </form>
        
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>

</html>