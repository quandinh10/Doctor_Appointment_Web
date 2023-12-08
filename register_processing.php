<!-- Section: Design Block -->
<?php
    include "session.php";
    require_once 'config.php';

$_SESSION['showSuccess'] = false; // sign up successfully
$_SESSION['showWrongPass'] = false; //check pass and repass 
$_SESSION['showError'] = false; // error message
$_SESSION['exists'] = false; // username or email exists
$_SESSION['emptyInfo'] = false; // empty information


$firstname = $_POST['firstnameRes'];
$lastname = $_POST['lastnameRes'];
$email = $_POST['emailRes'];
$password = $_POST['passRes'];
$repass = $_POST['rePassRes'];


if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($repass)) {
    $_SESSION['emptyInfo'] = true;
    header('Location: index.php?page=register');   
}
else{
    $sql = "SELECT * from user where Email = '$email'";
    $result = mysqli_query($mysqli,$sql);
    $num = mysqli_num_rows($result); 
    if($num>0)  
    { 
        $_SESSION['exists'] = true; 
        header('Location: index.php?page=login');
    }
    else { 
        if(($password == $repass)) { 
    
            $hash = password_hash($password,    
                                PASSWORD_DEFAULT); 
                
            // Password Hashing is used here.  
            $sql = "INSERT INTO `user` ( `Firstname`, `Lastname`,  
                `Email`, `Password`, `Role`) VALUES ('$firstname', '$lastname',  
                '$email', '$hash', 'patient')"; 
    
            $result = mysqli_query($mysqli, $sql); 
    
            if ($result) { 
                $_SESSION['showSuccess'] = true;  
                header('Location: index.php?page=login');
            }
            else {
                $_SESSION['showError'] = true;  
                header('Location: index.php?page=register');
            }
        }  
        else {  
            $_SESSION['showWrongPass'] = true;  
            header('Location: index.php?page=register');
        }       
    }// end if
    
}

?>