<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = 'localhost';
$dbname = 'u648102058_lumous';
$username = 'u648102058_lmsusr';
$password = 'Lum0us!23';
$charset = 'utf8mb4';

$dsn = "mysql:servername=$servername;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Pagination and search
$limit = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$offset = ($page - 1) * $limit;

// Base query
$sql = "SELECT submit_time, full_name, phone, email, work_experience, education, applying_role, resume
        FROM applications";

// Add search condition
if (!empty($search)) {
    $sql .= " WHERE full_name LIKE :search";
}

$sql .= " LIMIT :offset, :limit";

// Prepare and execute query
$stmt = $pdo->prepare($sql);

if (!empty($search)) {
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

$stmt->execute();
$records = $stmt->fetchAll();

// Get total number of records for pagination
$countSql = "SELECT COUNT(*) FROM applications";
if (!empty($search)) {
    $countSql .= " WHERE full_name LIKE :search";
}
$countStmt = $pdo->prepare($countSql);
if (!empty($search)) {
    $countStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
}
$countStmt->execute();
$totalRecords = $countStmt->fetchColumn();
$totalPages = ceil($totalRecords / $limit);

// Output JSON response
header('Content-Type: application/json');
echo json_encode([
    'records' => $records,
    'totalPages' => $totalPages,
]);
