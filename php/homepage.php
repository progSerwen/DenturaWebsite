<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denture Ni Ano</title>
    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/homepage.css"> <!-- Link to your external CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome for icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <!-- Include the Navigation Bar -->
    <?php include 'navigationbar.php'; ?>

    <div class="d-flex align-items-center justify-content-center flex-column flex-lg-row mt-4">
        <div class="image-container me-4">
            <img src="/assets/images/Saly-44.png" alt="image"> <!-- Replace with your image source -->
        </div>

        <main class="text-container">
            <h1>Welcome to Dentura</h1>
            <p>This is your number 1 dental clinic in Pangasinan. We are here to provide you with the best dental care services.</p>
            <a href="booking_form.php" class="btn btn-appointment btn-lg">Book an Appointment</a>
        </main>
    </div>

    <br>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Patients visits per year</h6>
                        <h2 class="text-right"><i class="fa fa-person f-left"></i><span>23000+</span></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Qualified collaborators</h6>
                        <h2 class="text-right"><i class="fa-solid fa-user f-left"></i><span>9+</span></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Satisfied patients</h6>
                        <h2 class="text-right"><i class="fa-solid fa-user f-left"></i><span>99.6%</span></h2>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card bg-c-pink order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Clinics Locations</h6>
                        <h2 class="text-right"><i class="fa-solid fa-house f-left"></i><span>3</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div>
        <h2 class="text-center">Latest Reviews</h2>

        <br>

        <?php include 'review.php'; ?>

    </div>

    <?php include 'about.php'; ?>


    <div>
        <h2 class="text-center">Meet our Expert Team</h2>
    </div>
    <br>
    <br>
    
    <?php include 'team.php'; ?>

    <br>
    <br>

    <div>
        <br>
    </div>

    <?php include 'mission.php'; ?>

    <div>
        <br>
    </div>

    <br>
    <br>
    <br>
    <br>

    <?php include 'branch.php'; ?>

    <br>
    <br>
    <br>
    <br>
    <br>

    <div class="d-flex align-items-center justify-content-center flex-column flex-lg-row mt-3">
        <div class="image-container me-4">
            <img src="/assets/images/Saly-44.png" alt="image"> <!-- Replace with your image source -->
        </div>

        <main class="text-container">
            <h1>We Are open And Welcoming Patients</h1>
            <a href="booking_form.php" class="btn btn-appointment btn-lg">Book an Appointment</a>
        </main>
    </div>

   
    

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
