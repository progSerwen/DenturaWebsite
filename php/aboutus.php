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
    <link rel="stylesheet" href="/css/aboutus.css"> <!-- Link to your external CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome for icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <!-- Include the Navigation Bar -->

    <?php include 'navigationbar.php'; ?>

    <br>
    <br>
    <br>

    <!-- About Us Section -->
    <section class="about-us mt-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="/assets/images/group1.png" alt="Dentura Team" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <h5 class="mb-2">About Us</h5>
                    <h1 class="mb-4">What is Dentura?</h1>
                    <p>Welcome to Dentura, where we believe that a healthy, beautiful smile is the foundation of confidence and well-being. Our mission is to provide top-tier dental care in a friendly, relaxing environment. Whether you need routine check-ups or more advanced treatments, our experienced team is here to cater to all your dental needs.</p>
                    <p>At Dentura, we combine modern technology with a personalized touch to deliver the highest standards of care. Our team of skilled dentists, hygienists, and specialists are passionate about creating a positive experience for every patient, ensuring comfort and peace of mind at every visit. We are committed to listening to your concerns and working with you to create the perfect treatment plan.</p>
                    <p>From preventive care to cosmetic dentistry, implants, and orthodontics, Dentura offers a full spectrum of services designed to keep your smile healthy and radiant. We also offer specialized care for children, ensuring that the entire family can benefit from our expertise in a single, welcoming setting.</p>
                    <p>At Dentura, your dental health is our priority. Our goal is to make every patient feel cared for and confident in their dental care journey. Thank you for choosing us to be a part of your smile story—we look forward to helping you achieve a lifetime of healthy, happy smiles!</p>
           
                </div>
        </div>
    </section>

    <br>
    <br>

    <div>
        <h3 class="text-center expert-title">Meet our Expert Partners</h3>
        <h2 class="text-center">Our Dentists</h2>

        <br>

        <?php include 'teamus.php'; ?>

    </div>

    <br>
    <br>
    <br>

 
    <div>
    <h3 class="text-center expert-title">Patient Testimonials</h3>
        <h2 class="text-center">Latest Reviews</h2>

        <br>

        <?php include 'review.php'; ?>

    </div>

    <br>
    <br>
    <br>

    <div>
        <h3 class="text-center expert-title">Explore our Department</h3>
        <h2 class="text-center">Dentura Clinic</h2>

        <br>

        <?php include 'branch.php'; ?>

   </div>

   <br>
   <br>
   <br>

   <div>

   </div>

    



    <!-- Footer -->

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
