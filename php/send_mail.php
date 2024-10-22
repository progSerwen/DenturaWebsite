<?php
session_start(); // Start the session

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

    // Prepare the email
    $to = 'prog.sherwin@gmail.com'; // Admin email address
    $subject = 'Dentura User Message';
    $body = nl2br("Full Name: $fullName<br>Email: $email<br><br>Message:<br>$message");
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-type: text/html\r\n"; // Set HTML email format

    // Send the email
    if (mail($to, $subject, $body, $headers)) {
        $_SESSION['contact_success'] = true; // Set session variable for success
    } else {
        $_SESSION['contact_success'] = false; // Email sending failed
    }
    
    header("Location: contactus.php"); // Redirect to the contact us page
    exit();
} else {
    $_SESSION['notification'] = "Invalid request method."; // Handle invalid request method
    header("Location: contactus.php"); // Redirect back to contactus.php
    exit();
}
