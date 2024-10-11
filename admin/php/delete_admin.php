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

// Check if the username is set in the URL
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Attempt to execute the statement
    if ($stmt->execute()) {
        $_SESSION['delete_success'] = "Admin user deleted successfully!";
    } else {
        $_SESSION['delete_error'] = "Error deleting admin user: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    $_SESSION['delete_error'] = "No username provided.";
}

// Close the connection
$conn->close();

// Redirect back to the admin dashboard
header("Location: admin_dashboard.php?section=users");
exit();
?>
