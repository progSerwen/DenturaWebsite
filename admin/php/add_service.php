<?php
session_start();

// Database configuration
$servername = "localhost"; // Database host
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (usually empty)
$dbname = "dentura"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to add a new service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['service'])) {
    $newService = htmlspecialchars(trim($_POST['service']));
    $description = htmlspecialchars(trim($_POST['description']));
    $cost = htmlspecialchars(trim($_POST['cost']));

    // Prepare and bind the statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO services (service_name, description, cost) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $newService, $description, $cost); // 's' for string, 'd' for double

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to admin_dashboard.php after adding the service
        header('Location: admin_dashboard.php');
        exit;
    } else {
        echo "Error: " . $stmt->error; // Handle errors (you may want to display a user-friendly message)
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/admin/css/add_service.css"> <!-- Link to your external CSS file -->
</head>
<body>
<div class="container">
    <div class="form-box">
        <h1 class="mt-5">Add Dental Service</h1>
        
        <form method="post" action="">
            <div class="form-group mb-3">
                <label for="service" class="form-label">Service Name</label>
                <input type="text" class="form-control" id="service" name="service" required>
            </div>
            <div class="form-group mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="cost" class="form-label">Cost</label>
                <input type="number" class="form-control" id="cost" name="cost" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Service</button>
        </form>
        
        <div class="mt-4">
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
