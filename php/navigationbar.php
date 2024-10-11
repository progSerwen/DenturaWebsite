<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dentura</title>

    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/navigationbar.css"> <!-- Link to your external CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome for icons -->
</head>
<body>
    <!-- Start Session -->
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg custom-navbar sticky-top"> <!-- Use custom class -->
        <div class="container">
            <a class="navbar-brand" href="homepage.php">
                <img src="/assets/images/DENTURA.png" alt="DENTURA" style="width: 100px; height: auto;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item category">
                        <a class="nav-link" aria-current="page" href="homepage.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Services
            </a>
            <li class="nav-item category">
                <a class="nav-link" aria-current="page" href="contactus.php">Contact Us</a>
            </li>
            <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                <?php
                // Fetch services from the database
                $servername = "localhost"; 
                $username = "root"; 
                $password = ""; 
                $dbname = "dentura"; 

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $services = [];
                $sql = "SELECT service_name FROM services";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $services[] = $row['service_name'];
                    }
                }

                $conn->close();

                if (empty($services)): ?>
                    <li><a class="dropdown-item" href="#">No services available</a></li>
                <?php else:
                    foreach ($services as $service): ?>
                        <li><a class="dropdown-item" href="#"><?php echo htmlspecialchars($service); ?></a></li>
                    <?php endforeach; 
                endif; ?>
            </ul>
        </li>

                    
                    <!-- <li class="nav-item">
                        <a href="contactus.php" class="btn btn-appointment btn-lg custom-btn" 
                        style="background-color: #0085BE; color: white; border: 2px solid #0085BE; text-align: center; text-decoration: none; padding: 5px 10px; transition: background-color 0.3s ease, color 0.3s ease;">
                            Contact Us
                        </a>
                    </li> -->
                </ul>
            </div>
        </div> 
    </nav>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
