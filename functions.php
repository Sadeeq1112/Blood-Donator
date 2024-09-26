<?php
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function is_admin() {
    return isset($_SESSION['user_id']) && $_SESSION['is_admin'];
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function set_message($message) {
    $_SESSION['message'] = $message;
}

function display_message() {
    if(isset($_SESSION['message'])) {
        echo '<div class="message">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
}
?>