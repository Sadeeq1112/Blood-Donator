<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!is_admin()) {
    redirect("login.php");
}

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $sql = "DELETE FROM donors WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET["id"]);
        
        if (mysqli_stmt_execute($stmt)) {
            set_message("Donor deleted successfully.");
            redirect("dashboard.php");
        } else {
            set_message("Oops! Something went wrong. Please try again later.");
        }
    }
    mysqli_stmt_close($stmt);
} else {
    redirect("dashboard.php");
}

mysqli_close($conn);
?><?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!is_admin()) {
    redirect("login.php");
}

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $sql = "DELETE FROM donors WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET["id"]);
        
        if (mysqli_stmt_execute($stmt)) {
            set_message("Donor deleted successfully.");
            redirect("dashboard.php");
        } else {
            set_message("Oops! Something went wrong. Please try again later.");
        }
    }
    mysqli_stmt_close($stmt);
} else {
    redirect("dashboard.php");
}

mysqli_close($conn);
?><?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!is_admin()) {
    redirect("login.php");
}

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $sql = "DELETE FROM donors WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET["id"]);
        
        if (mysqli_stmt_execute($stmt)) {
            set_message("Donor deleted successfully.");
            redirect("dashboard.php");
        } else {
            set_message("Oops! Something went wrong. Please try again later.");
        }
    }
    mysqli_stmt_close($stmt);
} else {
    redirect("dashboard.php");
}

mysqli_close($conn);
?><?php
session_start();
require_once 'config.php';
require_once 'functions.php';

if (!is_admin()) {
    redirect("login.php");
}

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $sql = "DELETE FROM donors WHERE id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET["id"]);
        
        if (mysqli_stmt_execute($stmt)) {
            set_message("Donor deleted successfully.");
            redirect("dashboard.php");
        } else {
            set_message("Oops! Something went wrong. Please try again later.");
        }
    }
    mysqli_stmt_close($stmt);
} else {
    redirect("dashboard.php");
}

mysqli_close($conn);
?>