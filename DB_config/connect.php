<?php
$db_config = include_once("./db_config.php");
$host = $db_config["host"];
$username = $db_config["username"];
$password = $db_config["password"];
// Create a connection
$mysqli = new mysqli($host, $username, $password, "");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Create database "OnlineStore"
$sql = "CREATE DATABASE IF NOT EXISTS medicalDoctor";
if ($mysqli->query($sql) === TRUE) {
    echo "Database created successfully <br>";
} else {
    echo "Error creating database: " . $mysqli->error;
}

// Select the database
$mysqli->select_db("medicalDoctor");

// Create table "patient"
$sql = "CREATE TABLE IF NOT EXISTS user (
    UserID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Firstname VARCHAR(255) NOT NULL,
    Lastname VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    -- ID CHAR(15) GENERATED ALWAYS AS (CONCAT('UID', LPAD(userID,8,'0'))),
    Role ENUM('patient', 'doctor')
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Table user created successfully\n";
} else {
    echo "Error creating table: " . $mysqli->error;
}


// Create table "slot"
$sql = "CREATE TABLE IF NOT EXISTS slot (
    SlotID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Date DATE, 
    DayofWeek ENUM('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'),
    TimeSlot TIME,
    Status ENUM('available','busy', 'appointment') DEFAULT 'available',
    PatientID INT UNSIGNED NULL,
    FOREIGN KEY (PatientID) REFERENCES user(UserID)
)";

if ($mysqli->query($sql) === TRUE) {
    echo "Table slot created successfully\n";
} else {
    echo "Error creating table: " . $mysqli->error;
}
// Close the connection
$mysqli->close();
?>
