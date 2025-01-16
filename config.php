<?php
// Database configuration
$db_host = "localhost";    // Database host
$db_user = "u648102058_lmsusr";         // Database username
$db_pass = "Lum0us!23";             // Database password
$db_name = "u648102058_lumous";    // Database name

// Create database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to handle special characters properly
$conn->set_charset("utf8mb4");

// Error reporting (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));

// Define constants
define('BASE_URL', 'http://localhost/lgv/lumous/login.html#'); // Change this to your project URL
define('SITE_NAME', 'Lumous');

// Security functions
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to generate secure random token
function generate_token($length = 32) {
    return bin2hex(random_bytes($length));
}

// Function to redirect with message
function redirect($url, $message = '', $type = 'success') {
    if ($message) {
        $_SESSION['message'] = $message;
        $_SESSION['message_type'] = $type;
    }
    header("Location: $url");
    exit();
}

// Time zone setting
date_default_timezone_set('Asia/Kolkata'); // Change according to your timezone

?>