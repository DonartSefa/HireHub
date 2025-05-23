<?php
include_once("config.php");

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT image_type, image_data FROM user_photos WHERE id = ?");
$stmt->execute([$id]);
$image = $stmt->fetch();

if ($image) {
    header("Content-Type: " . $image['image_type']);
    echo $image['image_data'];
    exit;
}
?>
