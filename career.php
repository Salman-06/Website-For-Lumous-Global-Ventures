<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['fullName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $workExperience = $_POST['workExperience'];
    $education = $_POST['education'];
    $applyingRole = $_POST['applyingRole'];
    $resume = $_FILES['resume'];
    $submitTime = date("Y-m-d H:i:s");

    // Convert options for work experience, education, and applying role
    $workExperienceOptions = ["Yes", "No"];
    $educationOptions = ["UG", "PG"];
    $applyingRoleOptions = ["Marketing", "HR/Operations", "Psychologist", "Media"];
    
    $workExperience = $workExperienceOptions[$workExperience] ?? $workExperience;
    $education = $educationOptions[$education] ?? $education;
    $applyingRole = $applyingRoleOptions[$applyingRole] ?? $applyingRole;

    // Database connection
    $conn = new mysqli("localhost", "u648102058_lmsusr", "Lum0us!23", "u648102058_lumous");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Save file
    $resumePath = "uploads/" . basename($resume['name']);
    $resumeURL = "https://lumousglobal.com/" . $resumePath;
    move_uploaded_file($resume['tmp_name'], $resumePath);

    // Insert data
    $stmt = $conn->prepare("INSERT INTO applications (full_name, phone, email, work_experience, education, applying_role, resume, submit_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $fullName, $phone, $email, $workExperience, $education, $applyingRole, $resumePath, $submitTime);
    if ($stmt->execute()) {
        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lumousglobalventures@gmail.com'; // Replace with your Gmail
            $mail->Password = 'gjob ypje ktiy vxsb'; // Replace with your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('your_email@gmail.com', $fullName); // Placeholder "from" for Gmail requirements
            $mail->addReplyTo($email, $fullName); // Set reply-to to the sender's email
            $mail->addAddress('lumousglobalventures@gmail.com'); // Add your email to receive notifications
            $mail->addAddress('msallubarick@gmail.com'); // Second recipient
            $mail->addAddress('salmanshaa1825@gmail.com'); // Third recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Application Submitted';
            $mail->Body = "<h3>New Application Details:</h3>
            <p><strong>Name:</strong> $fullName</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Work Experience:</strong> $workExperience</p>
            <p><strong>Education:</strong> $education</p>
            <p><strong>Applying Role:</strong> $applyingRole</p>
            <p><strong>Resume:</strong> <a href='$resumeURL'>Download</a></p>";

            $mail->send();
            echo "<script>alert('Application submitted successfully!'); window.location.href = 'career.html';</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Failed to save application.";
    }

    $stmt->close();
    $conn->close();
}
?>
