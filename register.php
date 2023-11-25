<?php
if (isset($_SESSION['showSuccess']) && $_SESSION['showSuccess']) {
  // Display your content or perform actions
  echo ' <div class="alert alert-success  
    alert-dismissible fade show fixed-bottom" role="alert"> 

    <strong>Success!</strong> Your account is  
    now created and you can login.  
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div> ';

  // Optionally, reset showAlert to false to prevent it from displaying again
  $_SESSION['showSuccess'] = false;
}

if (isset($_SESSION['emptyInfo']) && $_SESSION['emptyInfo']) {
  // Display your content or perform actions
  echo ' <div class="alert alert-danger 
  alert-dismissible fade show fixed-bottom" role="alert"> 

  <strong>Error!</strong> You must fill all required informations.  
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

</div> ';

  // Optionally, reset showAlert to false to prevent it from displaying again
  $_SESSION['emptyInfo'] = false;
}
if (isset($_SESSION['showWrongPass']) && $_SESSION['showWrongPass']) {
  // Display your content or perform actions
  echo ' <div class="alert alert-danger  
  alert-dismissible fade show fixed-bottom" role="alert"> 

  <strong>Error!</strong> Wrong password, please try again.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> ';

  // Optionally, reset showAlert to false to prevent it from displaying again
  $_SESSION['showWrongPass'] = false;
}
if (isset($_SESSION['exists']) && $_SESSION['exists']) {
  // Display your content or perform actions
  echo ' <div class="alert alert-danger 
  alert-dismissible fade show fixed-bottom" role="alert"> 

  <strong>Error!</strong> Username or email is already exists. Try again.  
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> 
</div> ';

  // Optionally, reset showAlert to false to prevent it from displaying again
  $_SESSION['exists'] = false;
}
if (isset($_SESSION['showError']) && $_SESSION['showError']) {
  // Display your content or perform actions
  echo ' <div class="alert alert-danger  
  alert-dismissible fade show fixed-bottom" role="alert"> 

  <strong>Error!</strong> Your account is not created successfully, Try again later.  
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> 
</div> ';

  // Optionally, reset showAlert to false to prevent it from displaying again
  $_SESSION['showError'] = false;
}

?>
<link rel="stylesheet" href="register.css">
<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                <form action ="register_processing.php" id="form" method="post" class="mx-1 mx-md-4" onsubmit="return validateInputs()">
                  <div class="d-flex flex-row align-items-center mb-4">
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="firstnameRes" placeholder="Firstname" name="firstnameRes" class="form-control" />
                      <div class="error mb-1"></div>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <div class="form-outline flex-fill mb-0">
                      <input type="text" id="lastnameRes" placeholder="Lastname" name="lastnameRes" class="form-control" />
                      <div class="error mb-1"></div>
                    </div>
                  </div>
                   
                  <div class="d-flex flex-row align-items-center mb-4">
                    <div class="form-outline flex-fill mb-0">
                      <input type="email" id="emailRes" placeholder="Email address" name="emailRes" class="form-control" />
                      <div class="error mb-1"></div>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <div class="form-outline flex-fill mb-0">
                      <input type="password" id="passRes" placeholder="Password" name="passRes" class="form-control" />
                      <div class="error mb-1"></div>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <div class="form-outline flex-fill mb-0">
                      <input type="password" id="rePassRes" placeholder="Repeat your password" name="rePassRes" class="form-control" />
                      <div class="error mb-1"></div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" class="btn btn-primary btn-lg mt-10 w-75">Register</button>
                  </div>
                </form>
                <script src="register_validation.js"></script>
              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp" class="img-fluid" alt="Sample image">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>