<?php
session_start(); // Start session

// Database connection
$conn = new mysqli('localhost', 'root', '', 'dentura');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Initialize variables
$fullname = '';
$username = '';
$password = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from the POST request
    $fullname = $_POST['fullname'];
    $username = $_POST['username']; // Username is readonly, so we are not changing it
    $password = $_POST['password']; // Optional field

    // Prepare the update query
    if (!empty($password)) {
        // Hash the password before updating
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE admins SET fullname = ?, password = ? WHERE username = ?");
        $stmt->bind_param("sss", $fullname, $hashed_password, $username);
    } else {
        // Update without changing the password
        $stmt = $conn->prepare("UPDATE admins SET fullname = ? WHERE username = ?");
        $stmt->bind_param("ss", $fullname, $username);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Admin details updated successfully!'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    // Check if 'username' is passed in the query string (GET request)
    if (isset($_GET['username'])) {
        $username = $_GET['username'];

        // Fetch admin details from the database
        $stmt = $conn->prepare("SELECT fullname, username FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin) {
            $fullname = $admin['fullname'];
            $username = $admin['username'];
        } else {
            echo "<p class='text-danger text-center'>Admin not found.</p>";
            exit();
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<p class='text-danger text-center'>No username provided.</p>";
        exit();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DenturAdmin</title> <!-- Title for the dashboard -->
    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon"> <!-- Favicon link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- For icons -->
    <link rel="stylesheet" href="/admin/css/edit_admin.css"> <!-- Link to external CSS -->
</head>
<body>

<div class="container d-flex align-items-center justify-content-center min-vh-100"> <!-- Center the form -->
    <div class="form-box">
        <h1 class="text-center">Update Information</h1>

        <!-- Admin Edit Form -->
        <form action="edit_admin.php" method="POST">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
                    </div>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" >
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password (leave blank if not changing)</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" id="password" name="password" placeholder="New Password">
                    <div class="input-group-append">
                        <span class="input-group-text" id="togglePassword" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Update Admin</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');

        // Toggle the type attribute
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
</body>
</html>
