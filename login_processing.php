<?php
include 'session.php';
require_once 'config.php';


$_SESSION['loginInfo'] = false;
$_SESSION['loginSuccess'] = false;

$email = $_POST['email'];
$password = $_POST['password'];

// Prepare a SQL query to find the user with the entered email
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists and if the password is correct
if ($row = $result->fetch_assoc()) {
    $_SESSION['email'] = $row['email'];
    if (password_verify($password, $row['password'])) {
        // Assign values to session variables
        $_SESSION['ID'] = $row['ID'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['availableSlot'] = $row['availableSlot'];
        // Redirect to the dashboard
        header("Location: index.php?page=home");
        $_SESSION['loginSuccess'] = true;
    } else {
        $_SESSION['loginInfo'] = true;
        header("Location: index.php?page=login");
    }
} else {
    $_SESSION['loginInfo'] = true;
    header("Location: index.php?page=login");
}

// Close the connection
$mysqli->close();
?>
