<?php
$db_config = include_once("./db_config.php");
$host = $db_config["host"];
$username = $db_config["username"];
$password = $db_config["password"];
$doctor_email = $db_config["doctor_email"];
$default_dr_password = $db_config["default_dr_password"];
// Create a connection
$mysqli = new mysqli($host, $username, $password, "medicalDoctor");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$hashed_password_new_user = password_hash($default_dr_password, PASSWORD_DEFAULT);
$product_sql = "INSERT INTO user (Firstname, Lastname, Email, Password, Role) VALUES ('Doctor', 'Nguyen', '$doctor_email', '$hashed_password_new_user','doctor')";
if ($mysqli->query($product_sql) === TRUE) {
    echo "New doctor inserted successfully.<br>";
} else {
    echo "Error inserting products: " . $mysqli->error . "<br>";
}

$mysqli->close();
?>
