<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php"); // Redirect to login if not logged in
    exit();
}

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

// Initialize variables for form data and error message
$location = $link = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location'];
    $link = $_POST['link'];

    // Check if inputs are empty
    if (empty($location) || empty($link)) {
        $error = "Please fill out both the branch location and link.";
    } else {
        // Insert branch data into the database
        $stmt = $conn->prepare("INSERT INTO branches (location, link) VALUES (?, ?)");
        $stmt->bind_param("ss", $location, $link);

        if ($stmt->execute()) {
            // Redirect to the branches list after successful insertion
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Error adding branch: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DenturAdmin</title> <!-- Title for the dashboard -->
    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon"> <!-- Favicon link -->
    <link rel="stylesheet" href="/admin/css/add_branch.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Add New Branch</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form action="add_branch.php" method="POST">
        <div class="form-group">
            <label for="location">Branch Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter branch location" value="<?php echo htmlspecialchars($location); ?>">
        </div>
        <div class="form-group">
            <label for="link">Location Link</label>
            <input type="url" class="form-control" id="link" name="link" placeholder="Enter Google Maps or other link" value="<?php echo htmlspecialchars($link); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Add Branch</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
