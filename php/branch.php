<?php
// Database connection
$servername = "localhost";
$username = "root"; // Adjust this based on your DB setup
$password = "";
$dbname = "dentura"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log the error and show a generic error message
    error_log("Connection failed: " . $conn->connect_error);
    die("We are currently experiencing technical difficulties. Please try again later.");
}

// SQL query to fetch branches
$sql = "SELECT location, link FROM branches";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch List - Dentura</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/branch.css"> <!-- Link to the external CSS file -->
</head>
<body>

<div class="container">
    <h3 class="mb-4">Dentura Branches</h3>
    <div class="list-group">
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Validate URL
                if (filter_var($row["link"], FILTER_VALIDATE_URL)) {
                    echo '<a href="' . $row["link"] . '" class="list-group-item list-group-item-action" target="_blank">' . htmlspecialchars($row["location"]) . '</a>';
                } else {
                    echo '<p class="list-group-item list-group-item-danger">Invalid link for ' . htmlspecialchars($row["location"]) . '</p>';
                }
            }
        } else {
            echo '<p>No branches available.</p>';
        }
        $conn->close();
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
