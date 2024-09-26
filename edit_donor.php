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

    $sql = "UPDATE donors SET name=?, email=?, phone=?, blood_type=?, genotype=?, rh_factor=?, kell=?, last_donation_date=?, medical_history=? WHERE id=?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "sssssssssi", $name, $email, $phone, $blood_type, $genotype, $rh_factor, $kell, $last_donation_date, $medical_history, $_GET['id']);
        
        if(mysqli_stmt_execute($stmt)){
            set_message("Donor updated successfully.");
            redirect("dashboard.php");
        } else{
            set_message("Oops! Something went wrong. Please try again later.");
        }
        mysqli_stmt_close($stmt);
    }
}

$id = $_GET['id'];
$sql = "SELECT * FROM donors WHERE id=?";
if($stmt = mysqli_prepare($conn, $sql)){
    mysqli_stmt_bind_param($stmt, "i", $id);
    if(mysqli_stmt_execute($stmt)){
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Donor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Donor</h2>
        <?php display_message(); ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id"; ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" value="<?php echo $row['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label>Blood Type</label>
                <select name="blood_type" required>
                    <?php
                    $blood_types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                    foreach ($blood_types as $type) {
                        echo "<option value=\"$type\"" . ($row['blood_type'] == $type ? ' selected' : '') . ">$type</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Genotype</label>
                <select name="genotype" required>
                    <?php
                    $genotypes = ['AA', 'AS', 'SS', 'AC', 'CC', 'SC'];
                    foreach ($genotypes as $type) {
                        echo "<option value=\"$type\"" . ($row['genotype'] == $type ? ' selected' : '') . ">$type</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Rh Factor</label>
                <select name="rh_factor" required>
                    <option value="Positive" <?php echo ($row['rh_factor'] == 'Positive') ? 'selected' : ''; ?>>Positive</option>
                    <option value="Negative" <?php echo ($row['rh_factor'] == 'Negative') ? 'selected' : ''; ?>>Negative</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kell Antigen</label>
                <select name="kell" required>
                    <option value="Positive" <?php echo ($row['kell'] == 'Positive') ? 'selected' : ''; ?>>Positive</option>
                    <option value="Negative" <?php echo ($row['kell'] == 'Negative') ? 'selected' : ''; ?>>Negative</option>
                </select>
            </div>
            <div class="form-group">
                <label>Last Donation Date</label>
                <input type="date" name="last_donation_date" value="<?php echo $row['last_donation_date']; ?>">
            </div>
            <div class="form-group">
                <label>Medical History</label>
                <textarea name="medical_history"><?php echo $row['medical_history']; ?></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Update Donor">
            </div>
        </form>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>