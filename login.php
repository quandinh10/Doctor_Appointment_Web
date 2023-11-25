<?php
if (isset($_SESSION['loginInfo']) && $_SESSION['loginInfo']) {
    // Display your content or perform actions
    echo ' <div class="alert alert-danger  
    alert-dismissible fade show fixed-bottom" role="alert"> 

    <strong>Error!</strong> Email or password is incorrect.  
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div> ';

    // Optionally, reset showAlert to false to prevent it from displaying again
    $_SESSION['loginInfo'] = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<section class="vh-100">
  <div class="container py-5 h-100">
    <div class="row d-flex align-items-center justify-content-center h-100">
      <div class="col-md-8 col-lg-7 col-xl-6">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
          class="img-fluid" alt="Phone image">
      </div>
      <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
        <form action="login_processing.php" method="post" id="form" onsubmit="return validateInputs()">
          <!-- Email input -->
          <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign in</p>
          <div class="form-outline mb-4 input-control">
            <input type="email" name="email" id="email" placeholder="Email address" class="form-control form-control-lg" 
            value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>"/>
            <div class="error"></div>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4 input-control">
            <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-lg" />
            <div class="error"></div>
          </div>

          <div class="d-flex justify-content-around align-items-center mb-4">
            <!-- Checkbox -->
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
              <label class="form-check-label" for="form1Example3"> Remember me </label>
            </div>
            <span><a href="index.php?page=register">Register?</a></span>
          </div>

          <!-- Submit button -->
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary btn-lg mt-4 w-75">Sign in</button>
          </div>
          
        </form>
        <script src="login_validation.js"></script>
      </div>
    </div>
  </div>
</section>
</body>
