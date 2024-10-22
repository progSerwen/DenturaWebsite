<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php"); // Redirect to login if not logged in
    exit();
}

// Database configuration
$conn = new mysqli("localhost", "root", "", "dentura");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the service name is set in the URL
if (isset($_GET['service_name'])) {
    $service_name = $_GET['service_name'];

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM services WHERE service_name = ?");
    $stmt->bind_param("s", $service_name);

    // Attempt to execute the statement
    if ($stmt->execute()) {
        $_SESSION['delete_success'] = "Service deleted successfully!";
    } else {
        $_SESSION['delete_error'] = "Error deleting service: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    $_SESSION['delete_error'] = "No service name provided.";
}

// Close the connection
$conn->close();

// Redirect back to the admin dashboard
header("Location: frontend/view_services.php");
exit();
?>
