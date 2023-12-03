<?php 
$db_config = include("./DB_config/dbConfig.php");
$host = $db_config["host"];
$username = $db_config["username"];
$password = $db_config["password"];

$mysqli = new mysqli($host, $username, $password, "medicalDoctor");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>