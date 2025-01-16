<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$servername = "localhost";
$username = "u648102058_lmsusr";
$password = "Lum0us!23";
$dbname = "u648102058_lumous";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form data
$full_name = $_POST['full_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];
$date = date('Y-m-d H:i:s');

// Insert data into the database
$sql = "INSERT INTO contacts (full_name, phone, email, message, date)
        VALUES ('$full_name', '$phone', '$email', '$message', '$date')";

if ($conn->query($sql) === TRUE) {
    // Send email notification
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lumousglobalventures@gmail.com'; // Replace with your Gmail
        $mail->Password = 'gjob ypje ktiy vxsb'; // Replace with your Gmail password or App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

       // Recipients
       $mail->setFrom('your_email@gmail.com', $full_name); // Placeholder "from" for Gmail requirements
       $mail->addReplyTo($email, $full_name); // Set reply-to to the sender's email
       $mail->addAddress('lumousglobalventures@gmail.com'); // Notification email address
       $mail->addAddress('msallubarick@gmail.com'); // Second recipient
       $mail->addAddress('salmanshaa1825@gmail.com'); // Third recipient

       // Content
       $mail->isHTML(true);
       $mail->Subject = 'New Contact Form Submission';
       $mail->Body = "
           <h2>New Contact Form Submission</h2>
           <p><strong>Name:</strong> $full_name</p>
           <p><strong>Phone Number:</strong> $phone</p>
           <p><strong>Email:</strong> $email</p>
           <p><strong>Message:</strong> $message</p>
           <p><strong>Date:</strong> $date</p>
       ";

       $mail->send();
   } catch (Exception $e) {
       echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
   }

   echo "<script>
           alert('Thank you for Contacting Lumous Global Ventures, We will get notified you!');
           window.location.href = 'contact.html';
         </script>";
} else {
   echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
