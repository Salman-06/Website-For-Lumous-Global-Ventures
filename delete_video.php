<?php
$conn = new mysqli("localhost", "root", "", "lumous");
$id = $_GET['id'];

$result = $conn->query("SELECT file_path FROM videos WHERE id = $id");
$file = $result->fetch_assoc()['file_path'];

if (file_exists($file)) {
    unlink($file); // Delete the file from the server
}

$conn->query("DELETE FROM videos WHERE id = $id");
?>
