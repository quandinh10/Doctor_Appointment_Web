<?php
unset($_SESSION['ID']);
unset($_SESSION['email']);
unset($_SESSION['role']);
unset($_SESSION['availableSlot']);
unset($_SESSION['loginSuccess']);
setcookie('email', '', time() - 3600);
header('Location: index.php');
?>
