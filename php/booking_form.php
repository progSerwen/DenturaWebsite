<?php
// Start the session conditionally
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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

// Fetch service names for the reason dropdown
$reasons = [];
$reasonQuery = "SELECT service_name FROM services";
$result = $conn->query($reasonQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reasons[] = $row['service_name'];
    }
}

// Fetch branch locations for the branch dropdown
$branches = [];
$branchQuery = "SELECT location FROM branches";
$result = $conn->query($branchQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $branches[] = $row['location'];
    }
}

// Check for success message
$booking_success = isset($_SESSION['booking_success']) ? $_SESSION['booking_success'] : false;
if ($booking_success) {
    // Clear the session variable after showing the alert
    unset($_SESSION['booking_success']);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dentura</title>
    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/book.css"> <!-- Link to external CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome for icons -->
</head>
<body>
    <?php include 'navigationbar.php'; ?>

    <div class="container-fluid d-flex align-items-center justify-content-center vh-100">
        <div class="row w-75">
            <div class="col-md-6">
                <div class="image-container">
                    <img src="/assets/images/saly10.png" alt="Book an Appointment" class="contact-image">
                </div>
            </div>
            <div class="col-md-6 booking-form">
                <h5 class="text-center excited-text">We're excited to assist you</h5>
                <h2 class="text-center">Book an Appointment</h2>

                <form method="POST" action="process_booking.php"> <!-- Change to your processing file -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="tel" class="form-control" id="number" name="number" placeholder="Enter your number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="reason"><i class="fas fa-book"></i> Reason for Booking</label>
                        <select class="form-control" id="reason" name="reason" required>
                            <option value="" disabled selected>Select your reason</option>
                            <?php foreach ($reasons as $reason): ?>
                                <option value="<?php echo htmlspecialchars($reason); ?>"><?php echo htmlspecialchars($reason); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="branch"><i class="fas fa-map-marker-alt"></i> Branch</label>
                        <select class="form-control" id="branch" name="branch" required>
                            <option value="" disabled selected>Select a branch</option>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?php echo htmlspecialchars($branch); ?>"><?php echo htmlspecialchars($branch); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                            </div>
                            <input type="time" class="form-control" id="time" name="time" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-submit btn-block" style="background-color: #0085BE; color: #ffffff;">Book Now</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php if ($booking_success): ?>
        <script>
            alert("Your booking was successful! Thank you for choosing Dentura.");
            window.location.href = 'booking_form.php'; // Redirect to booking form after alert
    </script>
    <?php endif; ?>
</body>
</html>
