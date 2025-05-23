<?php
include_once("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $image = $_FILES['image']['tmp_name'];
    $imageData = file_get_contents($image);
    $imageName = $_FILES['image']['name'];
    $imageType = $_FILES['image']['type'];

    $stmt = $conn->prepare("INSERT INTO user_photos (image_name, image_type, image_data) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $imageName);
    $stmt->bindParam(2, $imageType);
    $stmt->bindParam(3, $imageData, PDO::PARAM_LOB);

    if ($stmt->execute()) {
        echo "Image uploaded successfully.";
        // header("Location:post-job.php");
    } else {
        echo "Upload failed.";
    }
}
?>
