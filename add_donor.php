<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!is_admin()) {
    redirect("login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $blood_type = sanitize_input($_POST['blood_type']);
    $genotype = sanitize_input($_POST['genotype']);
    $rh_factor = sanitize_input($_POST['rh_factor']);
    $kell = sanitize_input($_POST['kell']);
    $last_donation_date = sanitize_input($_POST['last_donation_date']);
    $medical_history = sanitize_input($_POST['medical_history']);

    $sql = "INSERT INTO donors (name, email, phone, blood_type, genotype, rh_factor, kell, last_donation_date, medical_history) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "sssssssss", $name, $email, $phone, $blood_type, $genotype, $rh_factor, $kell, $last_donation_date, $medical_history);
        
        if(mysqli_stmt_execute($stmt)){
            set_message("Donor added successfully.");
            redirect("dashboard.php");
        } else{
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
    <title>Add New Donor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add New Donor</h2>
        <?php display_message(); ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" required>
            </div>
            <div class="form-group">
                <label>Blood Type</label>
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
                <label>Genotype</label>
                <select name="genotype" required>
                    <option value="AA">AA</option>
                    <option value="AS">AS</option>
                    <option value="SS">SS</option>
                    <option value="AC">AC</option>
                    <option value="CC">CC</option>
                    <option value="SC">SC</option>
                </select>
            </div>
            <div class="form-group">
                <label>Rh Factor</label>
                <select name="rh_factor" required>
                    <option value="Positive">Positive</option>
                    <option value="Negative">Negative</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kell Antigen</label>
                <select name="kell" required>
                    <option value="Positive">Positive</option>
                    <option value="Negative">Negative</option>
                </select>
            </div>
            <div class="form-group">
                <label>Last Donation Date</label>
                <input type="date" name="last_donation_date">
            </div>
            <div class="form-group">
                <label>Medical History</label>
                <textarea name="medical_history"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Donor">
            </div>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>