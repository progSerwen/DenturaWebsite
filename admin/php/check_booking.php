<?php
session_start();
$conn = new mysqli("localhost", "root", "", "dentura");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && $_GET['action'] == 'accept') {
    $id = $_GET['id'];
    
    // Update the status to 'Accepted'
    $sql = "UPDATE bookings SET status = 'Accepted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Booking accepted successfully.";
    } else {
        $_SESSION['message'] = "Error accepting booking.";
    }

    $stmt->close();
}

$conn->close();
header("Location: view_bookings.php?message=" . urlencode($_SESSION['message']));
exit();
?>
