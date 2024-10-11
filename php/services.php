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

// Fetch services from the database
$services = [];
$sql = "SELECT service_name FROM services";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch all services into an array
    while ($row = $result->fetch_assoc()) {
        $services[] = $row['service_name'];
    }
} else {
    $services = []; // No services found
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Available Dental Services</h1>
        <ul class="list-group">
            <?php if (empty($services)): ?>
                <li class="list-group-item">No services available</li>
            <?php else: ?>
                <?php foreach ($services as $service): ?>
                    <li class="list-group-item"><?php echo htmlspecialchars($service); ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
