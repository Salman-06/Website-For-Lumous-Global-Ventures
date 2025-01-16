<?php
// login.php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username']);
    $password = $_POST['password'];
    
    // Check username and password
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Redirect to index.html on successful login
            echo "<script>
                window.location.href='loginDash.html';
            </script>";
            exit();
        }
    }
    
    // Invalid credentials
    echo "<script>
        alert('Invalid username or password!');
        window.location.href='login.html';
    </script>";
    exit();
}
?>