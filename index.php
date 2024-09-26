<?php
session_start();
require_once 'config.php';
require_once 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blood Donation Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Blood Donation Management System</h1>
        <p>Our mission is to connect donors with recipients in need of blood. Whether you are a donor or someone in need of blood, we are here to help.</p>
        
        <nav>
            <ul>
                <li><a href="dashboard.php">Admin Dashboard</a></li>
                <li><a href="blood_request.php">Submit Blood Request</a></li>
                <li><a href="find-match.php">Find Matching Donors</a></li>
                <li><a href="send_notification.php">Send Notification</a></li>
            </ul>
        </nav>
        
        <section>
            <h2>About Us</h2>
            <p>We are dedicated to ensuring that everyone has access to the blood they need. Our platform allows donors to register and keep track of their donation history, while recipients can easily submit requests and find matching donors.</p>
        </section>
        
        <section>
            <h2>How It Works</h2>
            <p>Donors can register and update their information, including blood type, genotype, Rh factor, and Kell antigen status. Recipients can submit blood requests, and our system will match them with compatible donors based on these factors.</p>
        </section>
        
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Blood Donation Management System. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>