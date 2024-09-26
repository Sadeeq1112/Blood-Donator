<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!is_admin()) {
    redirect("login.php");
}

// Advanced search and filter functionality
$search = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';
$blood_type = isset($_GET['blood_type']) ? sanitize_input($_GET['blood_type']) : '';
$genotype = isset($_GET['genotype']) ? sanitize_input($_GET['genotype']) : '';
$rh_factor = isset($_GET['rh_factor']) ? sanitize_input($_GET['rh_factor']) : '';
$kell = isset($_GET['kell']) ? sanitize_input($_GET['kell']) : '';

$sql = "SELECT * FROM donors WHERE 1=1";
if (!empty($search)) {
    $sql .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%')";
}
if (!empty($blood_type)) {
    $sql .= " AND blood_type = '$blood_type'";
}
if (!empty($genotype)) {
    $sql .= " AND genotype = '$genotype'";
}
if (!empty($rh_factor)) {
    $sql .= " AND rh_factor = '$rh_factor'";
}
if (!empty($kell)) {
    $sql .= " AND kell = '$kell'";
}

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <?php display_message(); ?>
        <a href="logout.php">Logout</a>
        <a href="add_donor.php">Add New Donor</a>
        <a href="send_notification.php">Send Notification</a>
        <a href="find-match.php">Find Matching Donors</a>

        <form action="" method="get">
            <input type="text" name="search" placeholder="Search donors" value="<?php echo $search; ?>">
            <select name="blood_type">
                <option value="">All Blood Types</option>
                <option value="A+" <?php if($blood_type == 'A+') echo 'selected'; ?>>A+</option>
                <option value="A-" <?php if($blood_type == 'A-') echo 'selected'; ?>>A-</option>
                <option value="B+" <?php if($blood_type == 'B+') echo 'selected'; ?>>B+</option>
                <option value="B-" <?php if($blood_type == 'B-') echo 'selected'; ?>>B-</option>
                <option value="AB+" <?php if($blood_type == 'AB+') echo 'selected'; ?>>AB+</option>
                <option value="AB-" <?php if($blood_type == 'AB-') echo 'selected'; ?>>AB-</option>
                <option value="O+" <?php if($blood_type == 'O+') echo 'selected'; ?>>O+</option>
                <option value="O-" <?php if($blood_type == 'O-') echo 'selected'; ?>>O-</option>
            </select>
            <select name="genotype">
                <option value="">All Genotypes</option>
                <option value="AA" <?php if($genotype == 'AA') echo 'selected'; ?>>AA</option>
                <option value="AS" <?php if($genotype == 'AS') echo 'selected'; ?>>AS</option>
                <option value="SS" <?php if($genotype == 'SS') echo 'selected'; ?>>SS</option>
                <option value="AC" <?php if($genotype == 'AC') echo 'selected'; ?>>AC</option>
                <option value="CC" <?php if($genotype == 'CC') echo 'selected'; ?>>CC</option>
                <option value="SC" <?php if($genotype == 'SC') echo 'selected'; ?>>SC</option>
            </select>
            <select name="rh_factor">
                <option value="">All Rh Factors</option>
                <option value="Positive" <?php if($rh_factor == 'Positive') echo 'selected'; ?>>Positive</option>
                <option value="Negative" <?php if($rh_factor == 'Negative') echo 'selected'; ?>>Negative</option>
            </select>
            <select name="kell">
                <option value="">All Kell Antigens</option>
                <option value="Positive" <?php if($kell == 'Positive') echo 'selected'; ?>>Positive</option>
                <option value="Negative" <?php if($kell == 'Negative') echo 'selected'; ?>>Negative</option>
            </select>
            <input type="submit" value="Search">
        </form>

        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Blood Type</th>
                <th>Genotype</th>
                <th>Rh Factor</th>
                <th>Kell Antigen</th>
                <th>Last Donation</th>
                <th>Actions</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['blood_type']; ?></td>
                <td><?php echo $row['genotype']; ?></td>
                <td><?php echo $row['rh_factor']; ?></td>
                <td><?php echo $row['kell']; ?></td>
                <td><?php echo $row['last_donation_date']; ?></td>
                <td>
                    <a href="edit_donor.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="delete_donor.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>