<?php
// Create a connection
$db_config = include('./DB_config/dbConfig.php');
$host = $db_config["host"];
$username = $db_config["username"];
$password = $db_config["password"];
$mysqli = new mysqli($host, $username, $password, "medicalDoctor");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// // Create database "OnlineStore"
// $sql = "CREATE DATABASE IF NOT EXISTS medicalDoctor";
// if ($mysqli->query($sql) === TRUE) {
//     echo "Database created successfully <br>";
// } else {
//     echo "Error creating database: " . $mysqli->error;
// }

// Select the database
$mysqli->select_db("medicalDoctor");

// Create table "patient"
$sql = "CREATE TABLE IF NOT EXISTS user (
    userID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ID CHAR(15) GENERATED ALWAYS AS (CONCAT('UID', LPAD(userID,8,'0'))),
    availableSlot ENUM('0', '1', '2'),
    role ENUM('patient', 'doctor')
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Table user created successfully\n";
} else {
    echo "Error creating table: " . $mysqli->error;
}


// Create table "slot"
$sql = "CREATE TABLE IF NOT EXISTS slot (
    slotID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    DayofWeek ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'),
    StartTime TIME,
    EndTime TIME,
    statusSlot ENUM('available','busy') DEFAULT 'available',
    patientID CHAR(10) DEFAULT NULL
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Table slot created successfully\n";
} else {
    echo "Error creating table: " . $mysqli->error;
}
// Close the connection
$mysqli->close();
?>
