<?php
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

// Pagination setup
$itemsPerPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;

// Get total photo count
$totalPhotosQuery = "SELECT COUNT(*) AS total FROM photos";
$totalPhotosResult = $conn->query($totalPhotosQuery);
$totalPhotos = $totalPhotosResult->fetch_assoc()['total'];
$totalPages = ceil($totalPhotos / $itemsPerPage);

// Fetch photos for the current page
$query = "SELECT id, title, date, file_path FROM photos ORDER BY date DESC LIMIT $offset, $itemsPerPage";
$result = $conn->query($query);

$photos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $photos[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'date' => $row['date'],
            'filepath' => $row['file_path']
        ];
    }
}

// Return data as JSON
header('Content-Type: application/json');
echo json_encode([
    'photos' => $photos,
    'totalPages' => $totalPages,
]);

$conn->close();
?>
