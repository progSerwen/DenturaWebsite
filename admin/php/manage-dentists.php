<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                // Logic to add a new dentist
                $name = $_POST['name'];
                $stmt = $conn->prepare("INSERT INTO dentists (name) VALUES (?)");
                $stmt->bind_param("s", $name);
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Dentist added successfully.";
                } else {
                    $_SESSION['message'] = "Error adding dentist: " . $stmt->error;
                }
                $stmt->close();
                break;

            case 'update':
                // Logic to update an existing dentist
                $id = $_POST['id'];
                $name = $_POST['name'];
                $stmt = $conn->prepare("UPDATE dentists SET name = ? WHERE id = ?");
                $stmt->bind_param("si", $name, $id);
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Dentist updated successfully.";
                } else {
                    $_SESSION['message'] = "Error updating dentist: " . $stmt->error;
                }
                $stmt->close();
                break;

            case 'delete':
                // Logic to delete a dentist
                $id = $_POST['id'];
                $stmt = $conn->prepare("DELETE FROM dentists WHERE id = ?");
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    $_SESSION['message'] = "Dentist deleted successfully.";
                } else {
                    $_SESSION['message'] = "Error deleting dentist: " . $stmt->error;
                }
                $stmt->close();
                break;
        }
        // Redirect back to the admin dashboard or handle AJAX response
        header("Location: frontend/view_dentists.php");
        exit();
    }
}

// Fetch dentists for display
$result = $conn->query("SELECT * FROM dentists");

$dentists = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dentists[] = $row;
    }
}

// Close the connection
$conn->close();
?>
