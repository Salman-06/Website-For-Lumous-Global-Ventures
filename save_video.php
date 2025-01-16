<?php
// save_video.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $title = $_POST['title'];
    $video = $_FILES['video'];

    // Validate inputs
    if (!$date || !$title || !$video) {
        die("All fields are required.");
    }

    // Validate video file type
    $allowedTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/mkv'];
    if (!in_array($video['type'], $allowedTypes)) {
        die("Invalid video format. Only MP4, AVI, MOV, and MKV are allowed.");
    }

    // Save the video to the server
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
        
    }

    $filePath = $uploadDir . uniqid() . "_" . basename($video['name']);
    if (!move_uploaded_file($video['tmp_name'], $filePath)) {
        die("Failed to upload video.");
    }

    // Save video details to the database
    $mysqli = new mysqli("localhost", "u648102058_lmsusr", "Lum0us!23", "u648102058_lumous");

    if ($mysqli->connect_error) {
        die("Database connection failed: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("INSERT INTO videos (date, title, filepath) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $date, $title, $filePath);

    if ($stmt->execute()) {
        echo "Video saved successfully.";
    } else {
        echo "Error saving video: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
