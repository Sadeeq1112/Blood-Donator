<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!is_admin()) {
    redirect("login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type = sanitize_input($_POST['blood_type']);
    $message = sanitize_input($_POST['message']);

    $sql = "INSERT INTO notifications (blood_type, message) VALUES (?, ?)";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $blood_type, $message);
        
        if (mysqli_stmt_execute($stmt)) {
            // Send email to donors with matching blood type
            $donor_sql = "SELECT email FROM donors WHERE blood_type = ?";
            if ($donor_stmt = mysqli_prepare($conn, $donor_sql)) {
                mysqli_stmt_bind_param($donor_stmt, "s", $blood_type);
                mysqli_stmt_execute($donor_stmt);
                $result = mysqli_stmt_get_result($donor_stmt);
                
                while ($row = mysqli_fetch_assoc($result)) {
                    // In a real-world scenario, you would use a proper email sending library here
                    mail($row['email'], "Blood Donation Needed", $message);
                }
                
                mysqli_stmt_close($donor_stmt);
            }
            
            set_message("Notification sent successfully.");
            redirect("dashboard.php");
        } else {
            set_message("Oops! Something went wrong. Please try again later.");
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Notification</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Send Notification</h2>
        <?php display_message(); ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Blood Type Needed</label>
                <select name="blood_type" required>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Send Notification">
            </div>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>