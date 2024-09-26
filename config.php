<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'bfsllkdc_sadeeq');
define('DB_PASSWORD', '09030037973Ab,');
define('DB_NAME', 'bfsllkdc_blood');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>