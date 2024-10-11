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
                        // Database configuration
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

                        $result = $conn->query("SELECT id, service_name, description, cost FROM services");

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
                            echo "<tr><td colspan='4' class='text-center'>No services available.</td></tr>";
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

<!-- Display Booking Information -->
<!-- Display Booking Information -->
<!-- Display Booking Information -->
<div id="booking-info" class="mt-5 <?php echo ($activeSection === 'bookings') ? '' : 'hidden'; ?>">
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

            $result = $conn->query("SELECT id, name, number, email, reason, branch, date, time FROM bookings");

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
                            <td>
                                <a href='delete_booking.php?id=" . urlencode($row['id']) . "' class='text-danger'>
                                    <i class='fas fa-trash'></i>
                                </a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>No bookings available.</td></tr>";
            }

            $conn->close(); // Close the connection after using it
            ?>
        </tbody>
    </table>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Functions to display the appropriate section
    function showUsers() {
        window.location.href = "?section=users"; // Redirect to the users section
    }

    function showServices() {
        window.location.href = "?section=services"; // Redirect to the services section
    }

    function showBranches() {
        window.location.href = "?section=branches"; // Redirect to the branches section
    }
    function showBookings() {
        window.location.href = "?section=bookings"; // Redirect to the branches section
    }
</script>
</body>
</html>
