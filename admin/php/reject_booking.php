<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dentura");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && $_GET['action'] == 'reject') {
    $id = $_GET['id'];
    
    // Update the status to 'Rejected'
    $sql = "UPDATE bookings SET status = 'Rejected' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Booking rejected successfully.";
    } else {
        $_SESSION['message'] = "Error rejecting booking.";
    }

    $stmt->close();
}

$conn->close();
header("Location: admin_dashboard.php?section=bookings&message=" . urlencode($_SESSION['message']));
exit();
?>
