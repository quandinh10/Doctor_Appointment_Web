<?php 
$mysqli = new mysqli("localhost", "root", "", "medicalDoctor");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>