<?php
session_start();
include_once("config.php");

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'employer') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title       = trim($_POST['title']);
    $company     = trim($_POST['company']);
    $location    = trim($_POST['location']);
    $category    = trim($_POST['category']);
    $description = trim($_POST['description']);
    $posted_by   = $_SESSION['user_id'];

    $imagePath = null;

    // Handle file upload if image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Allowed extensions
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Sanitize file name and create unique name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Directory in your project to save images
            $uploadFileDir = './uploads/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagePath = $newFileName; // Save only the file name or relative path
            } else {
                // Handle error moving file
                die("There was an error moving the uploaded file.");
            }
        } else {
            die("Upload failed. Allowed file types: " . implode(", ", $allowedfileExtensions));
        }
    }

    $stmt = $conn->prepare("INSERT INTO jobs (title, company, location, category, description, posted_by, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $company, $location, $category, $description, $posted_by, $imagePath]);

    header("Location: dashboard.php");
    exit;
}
?>
