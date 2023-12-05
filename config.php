<?php 
$db_config = include_once("./DB_config/db_config.php");
$host = $db_config["host"];
$username = $db_config["username"];
$password = $db_config["password"];
$mysqli = new mysqli($host, $username, $password, "medicalDoctor");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>