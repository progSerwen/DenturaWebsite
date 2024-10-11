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
        <a class="navbar-brand" href="#">DenturAdmin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?section=bookings">
                        <i class="fas fa-bell"></i> Notifications 
                        <?php if ($newBookings > 0): ?>
                            <span class="badge badge-danger"><?php echo $newBookings; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <span class="nav-link">Welcome to DenturAdmin</span>
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
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeSection === 'users') ? 'active' : ''; ?>" href="?section=users" onclick="showUsers()">
                            <i class="fas fa-user-shield"></i> Manage Admin Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeSection === 'services') ? 'active' : ''; ?>" href="?section=services" onclick="showServices()">
                            <i class="fas fa-tools"></i> Services
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeSection === 'branches') ? 'active' : ''; ?>" href="?section=branches" onclick="showBranches()">
                            <i class="fas fa-building"></i> Branches
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($activeSection === 'bookings') ? 'active' : ''; ?>" href="?section=bookings" onclick="showBookings()">
                            <i class="fas fa-calendar-check"></i> View Bookings
                        </a>
                    </li>
                </ul>
                <div class="text-center mt-4">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h1 class="text-center mt-5 dashboard-header">Welcome to the D E N T U R A D M I N</h1>
            <h3 class="text-center">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>

            <?php
            if (isset($_SESSION['delete_success'])) {
                echo "<div class='alert alert-success'>" . $_SESSION['delete_success'] . "</div>";
                unset($_SESSION['delete_success']); // Clear the message after displaying
            }

            if (isset($_SESSION['delete_error'])) {
                echo "<div class='alert alert-danger'>" . $_SESSION['delete_error'] . "</div>";
                unset($_SESSION['delete_error']); // Clear the message after displaying
            }
            ?>

            <!-- Display Users Information -->
            <div id="user-info" class="mt-5 <?php echo ($activeSection === 'users') ? '' : 'hidden'; ?>">
                <div class="mb-3">
                    <a href="signupadmin.php" class="btn btn-primary">Add New Admin</a>
                </div>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = new mysqli("localhost", "root", "", "dentura");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $result = $conn->query("SELECT fullname, username FROM admins");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['fullname']) . "</td>
                                        <td>" . htmlspecialchars($row['username']) . "</td>
                                        <td>
                                            <a href='edit_admin.php?username=" . urlencode($row['username']) . "' class='text-warning mr-3'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                            <a href='delete_admin.php?username=" . urlencode($row['username']) . "' class='text-danger'>
                                                <i class='fas fa-trash'></i>
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No registered admins found.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Display Services Information -->
            <div id="service-info" class="mt-5 <?php echo ($activeSection === 'services') ? '' : 'hidden'; ?>">
                <div class="mb-3">
                    <a href="add_service.php" class="btn btn-primary">Add New Service</a>
                </div>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Service Id</th>
                            <th>Service Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = new mysqli("localhost", "root", "", "dentura");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $result = $conn->query("SELECT id, service_name, description FROM services");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['id']) . "</td>
                                        <td>" . htmlspecialchars($row['service_name']) . "</td>
                                        <td>" . htmlspecialchars($row['description']) . "</td>
                                        <td>
                                            <a href='edit_service.php?service_name=" . urlencode($row['service_name']) . "' class='text-warning mr-3'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                            <a href='delete_service.php?service_name=" . urlencode($row['service_name']) . "' class='text-danger'>
                                                <i class='fas fa-trash'></i>
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No registered services found.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Display Branches Information -->
            <div id="branch-info" class="mt-5 <?php echo ($activeSection === 'branches') ? '' : 'hidden'; ?>">
                <div class="mb-3">
                    <a href="add_branch.php" class="btn btn-primary">Add New Branch</a>
                </div>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Branch Id</th>
                            <th>Branch Location</th>
                            <th>Branch Link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conn = new mysqli("localhost", "root", "", "dentura");

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $result = $conn->query("SELECT id, location, link FROM branches");

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['id']) . "</td>
                                        <td>" . htmlspecialchars($row['location']) . "</td>
                                        <td><a href='" . htmlspecialchars($row['link']) . "' target='_blank'>" . htmlspecialchars($row['link']) . "</a></td>
                                        <td>
                                            <a href='edit_branch.php?id=" . urlencode($row['id']) . "' class='text-warning mr-3'>
                                                <i class='fas fa-edit'></i>
                                            </a>
                                            <a href='delete_branch.php?id=" . urlencode($row['id']) . "' class='text-danger'>
                                                <i class='fas fa-trash'></i>
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center'>No branches available.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Display Bookings Information -->
            <div id="bookings-info" class="mt-5 <?php echo ($activeSection === 'bookings') ? '' : 'hidden'; ?>">
            <?php
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
                          <th>Status</th> <!-- Added Status Header -->
                          <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
            // Create a new connection for the bookings section
            $conn = new mysqli("localhost", "root", "", "dentura");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query("SELECT id, name, number, email, reason, branch, date, time, COALESCE(status, 'Pending') AS status FROM bookings");


            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['number']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['reason']) . "</td>
                            <td>" . htmlspecialchars($row['branch']) . "</td>
                            <td>" . htmlspecialchars($row['date']) . "</td>
                            <td>" . htmlspecialchars($row['time']) . "</td>
                            <td>" . htmlspecialchars($row['status']) . "</td> <!-- Display status value -->
                            <td>
                                <a href='check_booking.php?id=" . urlencode($row['id']) . "&action=accept' class='text-success mr-3' title='Accept Booking'>
                                    <i class='fas fa-check'></i>
                                </a>
                                <a href='reject_booking.php?id=" . urlencode($row['id']) . "&action=reject' class='text-danger mr-3' title='Reject Booking'>
                                    <i class='fas fa-times'></i>
                                </a>
                                <a href='delete_booking.php?id=" . urlencode($row['id']) . "' class='text-danger' title='Delete Booking'>
                                    <i class='fas fa-trash'></i>
                                </a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='10' class='text-center'>No bookings available.</td></tr>";
            }

            $conn->close(); // Close the connection after using it
            ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function showUsers() {
        document.getElementById("user-info").classList.remove("hidden");
        document.getElementById("service-info").classList.add("hidden");
        document.getElementById("branches-info").classList.add("hidden");
        document.getElementById("bookings-info").classList.add("hidden");
    }

    function showServices() {
        document.getElementById("user-info").classList.add("hidden");
        document.getElementById("service-info").classList.remove("hidden");
        document.getElementById("branches-info").classList.add("hidden");
        document.getElementById("bookings-info").classList.add("hidden");
    }

    function showBranches() {
        document.getElementById("user-info").classList.add("hidden");
        document.getElementById("service-info").classList.add("hidden");
        document.getElementById("branches-info").classList.remove("hidden");
        document.getElementById("bookings-info").classList.add("hidden");
    }

    function showBookings() {
        document.getElementById("user-info").classList.add("hidden");
        document.getElementById("service-info").classList.add("hidden");
        document.getElementById("branches-info").classList.add("hidden");
        document.getElementById("bookings-info").classList.remove("hidden");
    }
</script>

</body>
</html>
