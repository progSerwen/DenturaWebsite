<?php
session_start();

// Check if the user is logged in (if needed)
if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php");
    exit();
}

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

// Check if the booking ID is set in the URL
if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    // Prepare and bind the statement to delete the booking
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("s", $bookingId); // Assuming id is a string; change to "i" if it's an integer.

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['delete_success'] = "Booking deleted successfully."; // Set session variable for success
    } else {
        $_SESSION['delete_error'] = "Error deleting booking: " . $stmt->error; // Set session variable for error
    }

    $stmt->close();
} else {
    $_SESSION['delete_error'] = "Error: Missing booking ID.";
}

// Close the connection
$conn->close();

// Redirect back to the admin dashboard or the bookings section
header("Location: admin_dashboard.php?section=bookings");
exit();
?>
