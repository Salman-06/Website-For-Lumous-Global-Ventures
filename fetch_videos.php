<?php
// fetch_videos.php

$mysqli = new mysqli("localhost", "u648102058_lmsusr", "Lum0us!23", "u648102058_lumous");

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Get total number of videos
$totalResult = $mysqli->query("SELECT COUNT(*) as total FROM videos");
if (!$totalResult) {
    die("Error fetching total videos: " . $mysqli->error);
}
$totalVideos = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalVideos / $limit);

// Fetch videos with pagination
$query = "SELECT * FROM videos ORDER BY date DESC LIMIT $limit OFFSET $offset";
$result = $mysqli->query($query);
if (!$result) {
    die("Error fetching videos: " . $mysqli->error);
}

$videos = [];
while ($row = $result->fetch_assoc()) {
    $videos[] = [
        'id' => $row['id'],
        'date' => $row['date'],
        'title' => $row['title'],
        'filepath' => $row['filepath']
    ];
}

header('Content-Type: application/json');
echo json_encode([
    'videos' => $videos,
    'totalPages' => $totalPages
]);

$mysqli->close();
?>
