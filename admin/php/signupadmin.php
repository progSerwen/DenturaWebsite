<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DenturAdmin</title> <!-- Title added here -->
    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon"> <!-- Favicon link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/admin/css/signupadmin.css"> <!-- Link to external CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome for icons -->
</head>
<body>

<div class="container mt-5">
    <img src="/assets/images/DENTURA.png" alt="Logo" class="img-fluid mb-4" style="display: block; margin: auto; width: 200px; height: 200px; object-fit: cover;"> <!-- Set image size -->
    
    <div class="form-container">
        <h3 class="text-center mb-3">Admin</h3> <!-- Added bottom margin here -->
        <form action="register_admin.php" method="POST">
            <div class="form-group">
                <span class="form-icon"><i class="fas fa-user"></i></span>
                <input type="text" name="fullname" class="form-control" placeholder="Fullname" required>
            </div>
            <div class="form-group">
                <span class="form-icon"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <span class="form-icon"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <p class="text-center mt-3">
            <a href="loginadmin.php" class="login-link">Log in here</a>
        </p><!-- Link added here -->
    </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
