<?php
// Database configuration
$servername = "localhost"; // Database host
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password (usually empty)
$dbname = "dentura"; // Your database name

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if service_name is set in the URL
if (isset($_GET['service_name'])) {
    // Sanitize the service name
    $service_name = $conn->real_escape_string($_GET['service_name']);

    // Fetch the service details
    $query = "SELECT id, service_name, description, cost FROM services WHERE service_name = '$service_name'";
    $result = $conn->query($query);

    // Check if a service was found
    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
    } else {
        echo "Service not found.";
        exit;
    }
} else {
    echo "No service specified.";
    exit;
}

// Handle form submission for updating service details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $new_service_name = $conn->real_escape_string($_POST['service_name']);
    $new_description = $conn->real_escape_string($_POST['description']);
    $new_cost = $conn->real_escape_string($_POST['cost']);

    // Update the service in the database
    $update_query = "UPDATE services SET service_name='$new_service_name', description='$new_description', cost='$new_cost' WHERE id='$id'";

    if ($conn->query($update_query) === TRUE) {
        // Redirect to admin_dashboard.php on success
        header("Location: admin_dashboard.php");
        exit(); // Ensure no further code is executed after redirect
    } else {
        echo "Error updating service: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <link rel="stylesheet" href="/admin/css/edit_service.css"> <!-- Add your CSS file -->
</head>
<body>
    <div class="container"> <!-- Container div added -->
        <h2>Edit Service</h2>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($service['id']); ?>">
            
            <div>
                <label for="service_name">Service Name:</label>
                <input type="text" id="service_name" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
            </div>
            
            <div>
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($service['description']); ?></textarea>
            </div>
            
            <div>
                <label for="cost">Cost:</label>
                <input type="number" id="cost" name="cost" value="<?php echo htmlspecialchars($service['cost']); ?>" required>
            </div>
            
            <div>
                <button type="submit">Update Service</button>
            </div>
        </form>
        
        <a href="frontend/view_services.php">Back to Services</a> <!-- Link to go back to services list -->
    </div>
</body>
</html>
