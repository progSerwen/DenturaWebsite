<?php
session_start();



// Include the PHPMailer autoload file
require __DIR__ . '/../vendor/autoload.php'; // Adjust the path if necessary

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Use your database password
$dbname = "dentura"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is set
if (isset($_POST['name'], $_POST['email'], $_POST['number'], $_POST['reason'], $_POST['branch'], $_POST['date'], $_POST['time'])) {
    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, number, reason, branch, date, time) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $number, $reason, $branch, $date, $time);

    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $reason = $_POST['reason'];
    $branch = $_POST['branch'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Execute the statement
    if ($stmt->execute()) {
        // Send confirmation email
        $mail = new PHPMailer(true); // Create a new PHPMailer instance

        try {
            // Server settings
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'prog.sherwin@gmail.com'; // SMTP username (your email)
            $mail->Password = 'kguhywhcrukkhatz'; // SMTP password (your email password)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('your_email@gmail.com', 'Dentura Booking'); // Sender email and name
            $mail->addAddress($email, $name); // Add the user's email as recipient
            $mail->addBCC('prog.sherwin@gmail.com'); // Add your email (admin) as BCC

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Booking Confirmation';
            $mail->Body = nl2br("Dear $name,<br><br>Thank you for booking with us!<br><br>Your booking details are as follows:<br>Name: $name<br>Email: $email<br>Number: $number<br>Reason: $reason<br>Branch: $branch<br>Date: $date<br>Time: $time<br><br>We look forward to seeing you!<br><br>Best Regards,<br>Dentura Team");

            // Send the email
            $mail->send();

            $_SESSION['booking_success'] = true; // Set session variable for success
        } catch (Exception $e) {
            $_SESSION['booking_success'] = false; // Email sending failed
            $_SESSION['email_error'] = $mail->ErrorInfo; // Store the error message
        }
        
        header("Location: booking_form.php"); // Redirect to the booking form
        exit();
    } else {
        echo "Error: " . $stmt->error; // Database insertion error
    }

    $stmt->close();
} else {
    echo "Error: Missing form data.";
}

$conn->close();
?>
