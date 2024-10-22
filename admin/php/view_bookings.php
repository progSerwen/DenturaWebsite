<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: loginadmin.php"); // Redirect to login if not logged in
    exit();
}

// Determine the active section
$activeSection = 'users'; // Default active section

// Check the active section from URL parameters
if (isset($_GET['section'])) {
    $activeSection = $_GET['section'];
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DenturAdmin</title>
    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/admin/css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    <style>
        /* Additional CSS for hiding/showing sections */
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<?php
// Database configuration for booking notifications
$conn = new mysqli("localhost", "root", "", "dentura");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Count new (pending) bookings
$result = $conn->query("SELECT COUNT(*) as newBookings FROM bookings WHERE status = 'Pending'");
$newBookings = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $newBookings = $row['newBookings'];
}
$conn->close();
?>


<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="/assets/images/DENTURA.png" alt="DenturAdmin Logo" style="height: 100px;"> <!-- Adjust height as needed -->
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link text-dark">Hello, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b> !</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="#" id="notification-btn">
                        <i class="fas fa-bell"></i> Notifications 
                        <?php if ($newBookings > 0): ?>
                            <span class="badge badge-danger"><?php echo $newBookings; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <!-- Logout Button -->
                <li class="nav-item">
                    <a href="logout.php" class="nav-link text-dark">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <h4 class="text-center">D E N T U R A D M I N</h4>
                <ul class="nav flex-column">
                    <li class="nav-item active">
                        <a class="nav-link" href="manage_admin.php">
                            <i class="fas fa-user-shield"></i> Manage Admins
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="frontend/view_dentists.php">
                            <i class="fas fa-user-md"></i> Dentists
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="frontend/view_services.php">
                            <i class="fas fa-tools"></i> Services
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="frontend/view_branches.php">
                            <i class="fas fa-building"></i> Branches
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="view_bookings.php">
                            <i class="fas fa-calendar-check"></i> View Bookings
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h1 class="text-center mt-5 dashboard-header">Welcome to the D E N T U R A D M I N</h1>

            <?php
            if (isset($_SESSION['delete_success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['delete_success'] . "</div>";
                unset($_SESSION['delete_success']);
            }

            if (isset($_SESSION['delete_error'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['delete_error'] . "</div>";
                unset($_SESSION['delete_error']);
            }
            ?>

            <!-- Filter Buttons -->
            <div class="text-center mt-4">
                <a href="view_bookings.php?filter=all" class="btn btn-primary">All Bookings</a>
                <a href="view_bookings.php?filter=pending" class="btn btn-warning">Pending</a>
                <a href="view_bookings.php?filter=accepted" class="btn btn-success">Accepted</a>
                <a href="view_bookings.php?filter=rejected" class="btn btn-danger">Rejected</a>
            </div>

            <div class="text-center mt-4">
                <?php
                $sortState = isset($_GET['sort']) && $_GET['sort'] === 'latest' ? 'recent' : 'latest';
                $buttonText = $sortState === 'latest' ? 'Latest' : 'Recent';
                ?>
                <a href="view_bookings.php?sort=<?php echo $sortState; ?>" id="sort-button" class="btn btn-info"><?php echo $buttonText; ?></a>
            </div>

            <!-- Display Bookings Information -->
            <div id="bookings-info" class="mt-5">
                <?php
                // Determine the filter and sort
                $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                $query = "SELECT id, name, number, email, reason, branch, date, time, COALESCE(status, 'Pending') AS status FROM bookings ";

                // Apply filter and sorting
                if ($filter === 'pending') {
                    $query .= "WHERE status = 'Pending' ";
                } elseif ($filter === 'accepted') {
                    $query .= "WHERE status = 'Accepted' ";
                } elseif ($filter === 'rejected') {
                    $query .= "WHERE status = 'Rejected' ";
                }

                $query .= "ORDER BY date DESC";

                // Display success message if booking status has been updated
                if (isset($_GET['message'])) {
                    $message = htmlspecialchars($_GET['message']);
                    echo "<div class='alert alert-success'>Status: $message!</div>";
                }
                ?>

                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Reason</th>
                            <th>Branch</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    $conn = new mysqli("localhost", "root", "", "dentura");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookingStatus = htmlspecialchars($row['status']);
            echo "<tr>
                    <td>" . htmlspecialchars($row['id']) . "</td>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['number']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>" . htmlspecialchars($row['reason']) . "</td>
                    <td>" . htmlspecialchars($row['branch']) . "</td>
                    <td>" . htmlspecialchars($row['date']) . "</td>
                    <td>" . htmlspecialchars($row['time']) . "</td>
                    <td>" . htmlspecialchars($row['status']) . "</td>
                    <td>";
            
            // Show action buttons based on the booking status
            if ($bookingStatus === 'Pending') {
                echo "<a href='#' class='text-success mr-3 action-button' data-id='" . htmlspecialchars($row['id']) . "' data-action='accept' title='Accept Booking'>
                        <i class='fas fa-check'></i>
                      </a>
                      <a href='#' class='text-danger mr-3 action-button' data-id='" . htmlspecialchars($row['id']) . "' data-action='reject' title='Reject Booking'>
                        <i class='fas fa-times'></i>
                      </a>";
            }
            // Always show the delete button
            echo "<a href='#' class='text-danger action-button' data-id='" . htmlspecialchars($row['id']) . "' data-action='delete' title='Delete Booking'>
                    <i class='fas fa-trash'></i>
                  </a>
                  </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='10' class='text-center'>No bookings available.</td></tr>";
    }

    $conn->close();
    ?>
</tbody>

                </table>
            </div>
        </main>
    </div>
</div>

<!-- Bootstrap Modal for Confirmation -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to perform this action?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmButton">Confirm</button>
            </div>
        </div>
    </div>
</div>





<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


<script>
    let currentAction = '';
    let currentId = '';

    // Handle the click event for action buttons
    document.querySelectorAll('.action-button').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default anchor behavior
            currentAction = this.dataset.action;
            currentId = this.dataset.id;

            // Show the modal
            $('#confirmModal').modal('show');
        });
    });

    // Confirm action
    document.getElementById('confirmButton').addEventListener('click', function () {
        // Redirect based on the action and id
        window.location.href = `reject_booking.php?id=${currentId}&action=${currentAction}`;
    });
</script>

<script>
$(document).ready(function() {
    let actionId = null;
    let actionType = '';

    $('.action-button').on('click', function(e) {
        e.preventDefault(); // Prevent default anchor behavior
        actionId = $(this).data('id');
        actionType = $(this).data('action');
        
        // Show the confirmation modal
        $('#confirmationModal').modal('show');
    });

    $('#confirmButton').on('click', function() {
        if (actionType === 'accept') {
            window.location.href = 'check_booking.php?id=' + actionId + '&action=accept';
        } else if (actionType === 'reject') {
            window.location.href = 'reject_booking.php?id=' + actionId + '&action=reject';
        } else if (actionType === 'delete') {
            window.location.href = 'delete_booking.php?id=' + actionId;
        }
    });
});
</script>


<script>
    $(document).ready(function () {
        // Show SweetAlert for pending bookings when the notification button is clicked
        $('#notification-btn').on('click', function (e) {
            e.preventDefault(); // Prevent the default link behavior
            if (<?php echo $newBookings; ?> > 0) {
                swal({
                    title: "Pending Appointments",
                    text: "You have <strong><?php echo $newBookings; ?></strong> pending appointments. Please review them in Bookings!",
                    html: true,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Go to Bookings",
                    cancelButtonText: "Close",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }, function (isConfirm) {
                    if (isConfirm) {
                        window.location.href = "view_bookings.php"; // Redirect to bookings section
                    }
                });
            }
        });

        // Example: Using SweetAlert for success messages (optional)
        <?php if (isset($_SESSION['delete_success'])): ?>
            swal("Deleted!", "<?php echo $_SESSION['delete_success']; ?>", "success");
            <?php unset($_SESSION['delete_success']); // Clear the message after displaying ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['delete_error'])): ?>
            swal("Error!", "<?php echo $_SESSION['delete_error']; ?>", "error");
            <?php unset($_SESSION['delete_error']); // Clear the message after displaying ?>
        <?php endif; ?>
    });
</script>


</body>
</html>
