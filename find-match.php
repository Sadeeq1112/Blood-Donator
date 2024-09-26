<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!is_admin()) {
    redirect("login.php");
}

function get_compatible_blood_types($blood_type) {
    $sql = "SELECT donor_blood_type FROM blood_compatibility WHERE recipient_blood_type = ? ORDER BY compatibility_level";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $blood_type);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $compatible_types = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $compatible_types[] = $row['donor_blood_type'];
    }
    mysqli_stmt_close($stmt);
    return $compatible_types;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type = sanitize_input($_POST['blood_type']);
    $genotype = sanitize_input($_POST['genotype']);
    $rh_factor = sanitize_input($_POST['rh_factor']);
    $kell = sanitize_input($_POST['kell']);

    $compatible_types = get_compatible_blood_types($blood_type);
    $compatible_types_str = "'" . implode("','", $compatible_types) . "'";

    $sql = "SELECT * FROM donors WHERE blood_type IN ($compatible_types_str)";
    if (!empty($genotype)) {
        $sql .= " AND genotype = '$genotype'";
    }
    if (!empty($rh_factor)) {
        $sql .= " AND rh_factor = '$rh_factor'";
    }
    if (!empty($kell)) {
        $sql .= " AND kell = '$kell'";
    }
    $sql .= " ORDER BY FIELD(blood_type, $compatible_types_str)";

    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Find Matching Donors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Find Matching Donors</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">