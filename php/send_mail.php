<?php
// send_mail.php

session_start(); // Start the session

require __DIR__ . '/../vendor/autoload.php'; // Include the PHPMailer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fullName = htmlspecialchars(trim($_POST['fullName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['notification'] = "Invalid email format"; // Set notification for invalid email
        header("Location: contactus.php"); // Redirect back to contactus.php
        exit;
    }

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                         // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';                  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                              // Enable SMTP authentication
        $mail->Username   = 'prog.sherwin@gmail.com';          // SMTP username
        $mail->Password   = 'kguhywhcrukkhatz';                // SMTP password (consider using environment variables for security)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption
        $mail->Port       = 587;                               // TCP port to connect to

        // Recipients
        $mail->setFrom($email, $fullName);                     // Use user email as sender
        $mail->addAddress('prog.sherwin@gmail.com');           // Add a recipient

        // Content
        $mail->isHTML(true);                                   // Set email format to HTML
        $mail->Subject = 'Dentura User Message';
        $mail->Body    = nl2br("Full Name: $fullName<br>Email: $email<br><br>Message:<br>$message");
        $mail->AltBody = "Full Name: $fullName\nEmail: $email\n\nMessage:\n$message"; // For non-HTML mail clients

        // Send the email
        $mail->send();
        $_SESSION['contact_success'] = true; // Set session variable for success
    } catch (Exception $e) {
        $_SESSION['contact_success'] = false; // Email sending failed
        $_SESSION['email_error'] = $mail->ErrorInfo; // Store the error message
    }
    
    header("Location: contactus.php"); // Redirect to the contact us page
    exit();
} else {
    $_SESSION['notification'] = "Invalid request method."; // Handle invalid request method
    header("Location: contactus.php"); // Redirect back to contactus.php
    exit();
}
