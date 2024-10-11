<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dentura</title>
    <link rel="icon" href="/assets/images/dlogo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/contactus.css"> <!-- Link to external CSS file -->
</head>
<body>
    <?php include 'navigationbar.php'; ?>

    <div class="container-fluid d-flex align-items-center justify-content-center vh-100">
        <div class="row w-75">
            <div class="col-md-6 contact-form">
                <h5 class="text-center excited-text">We're excited to hear from you</h5>
                <h2 class="text-center"><strong>Contact Us</strong> </h2>
                <form action="send_mail.php" method="POST"> <!-- Updated form action -->
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder="Your message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-submit btn-block" style="background-color: #0085BE; color: #ffffff;">Submit</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="image-container">
                    <img src="/assets/images/saly12.png" alt="Contact Us" class="contact-image img-fluid">
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php if (isset($contact_success) && $contact_success): ?>
        <script>
            alert("Thank you for contacting us! Thank you for choosing Dentura.");
            window.location.href = 'contactus.php'; // Redirect to contact form after alert
        </script>
    <?php endif; ?>
</body>
</html>
