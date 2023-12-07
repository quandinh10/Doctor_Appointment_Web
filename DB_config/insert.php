<?php
$db_config = include_once("./db_config.php");
$host = $db_config["host"];
$username = $db_config["username"];
$password = $db_config["password"];
// Create a connection
$mysqli = new mysqli($host, $username, $password, "medicalDoctor");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$hashed_password_new_user = password_hash('superdoctor123', PASSWORD_DEFAULT);
$product_sql = "INSERT INTO user (firstname, lastname, email, password, availableSlot, role) VALUES ('user', 'new', 'abc@gmail.com', '$hashed_password_new_user', 0,'doctor')";
if ($mysqli->query($product_sql) === TRUE) {
    echo "New doctor inserted successfully.<br>";
} else {
    echo "Error inserting products: " . $mysqli->error . "<br>";
}

$mysqli->close();
?>
