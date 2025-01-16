<?php
// signup.php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name']);
    $username = clean_input($_POST['username']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Check if username exists
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    if($stmt->get_result()->num_rows > 0) {
        echo "<script>
            alert('Username already exists!');
            window.location.href='login.html';
        </script>";
        exit();
    }
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, username, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $username, $email, $phone, $password);
    
    if ($stmt->execute()) {
        echo "<script>
            alert('Registration successful! Please login.');
            window.location.href='loginDash.html';
        </script>";
        exit();
    } else {
        echo "<script>
            alert('Registration failed! Please try again.');
            window.location.href='login.html';
        </script>";
        exit();
    }
}
?>