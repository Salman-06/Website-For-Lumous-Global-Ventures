<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $host = 'localhost'; // Replace with your host
    $username = 'u648102058_lmsusr';  // Replace with your database username
    $password = 'Lum0us!23';      // Replace with your database password
    $database = 'u648102058_lumous'; // Replace with your database name

    $conn = new mysqli($host, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die('Database connection failed: ' . $conn->connect_error);
    }

    // Directory to save uploaded photos
    $uploadDir = 'uploads/';

    // Ensure the directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Get the submitted form data
    $title = $_POST['title'] ?? '';
    $date = $_POST['date'] ?? '';
    $photo = $_FILES['photo'] ?? null;

    // Validate form inputs
    if (empty($title) || empty($date) || !$photo) {
        echo '<script>alert("All fields are required."); window.location.href = "savePhotos.html";</script>';
        exit;
    }

    // Process the uploaded file
    $fileName = basename($photo['name']);
    $targetFile = $uploadDir . time() . '_' . $fileName;

    if (move_uploaded_file($photo['tmp_name'], $targetFile)) {
        // Save record to the database
        $stmt = $conn->prepare("INSERT INTO photos (title, date, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $title, $date, $targetFile);

        if ($stmt->execute()) {
            echo '<script>alert("Photo uploaded successfully."); window.location.href = "savePhotos.html";</script>';
        } else {
            echo '<script>alert("Failed to save photo record to database."); window.location.href = "savePhotos.html";</script>';
        }

        $stmt->close();
    } else {
        echo '<script>alert("There was an error uploading the photo. Please try again."); window.location.href = "savePhotos.html";</script>';
    }

    $conn->close();
} else {
    echo '<script>alert("Invalid request method."); window.location.href = "savePhotos.html";</script>';
}
?>
