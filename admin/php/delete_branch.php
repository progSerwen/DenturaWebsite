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

// Check if the branch ID is set in the URL
if (isset($_GET['id'])) {
    $branchId = $_GET['id'];

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM branches WHERE id = ?");
    $stmt->bind_param("i", $branchId);

    // Attempt to execute the statement
    if ($stmt->execute()) {
        $_SESSION['delete_success'] = "Branch deleted successfully!";
    } else {
        $_SESSION['delete_error'] = "Error deleting branch: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
} else {
    $_SESSION['delete_error'] = "No branch ID provided.";
}

// Close the connection
$conn->close();

// Redirect back to the admin dashboard
header("Location: admin_dashboard.php?section=branches");
exit();
?>
