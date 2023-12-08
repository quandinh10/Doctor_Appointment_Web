<?php
include 'session.php';
?>
<?php
$imagePaths = [
  "avatar/dog.png",
  "avatar/duck.png",
  "avatar/fatcat.png",
  "avatar/owl.png",
  "avatar/sadcat.png",
  "avatar/saddog.png",
  "avatar/tiger.png",
  "avatar/tuanloc.png",
  "avatar/doraemon.png",
];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/doctor.png">
  <title>MedicalCenter</title>
  <link rel="stylesheet" href="index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="calendar/css/style.css"> -->
  <link rel="stylesheet" href="calendar/css/custom.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="calendar/js/jquery.min.js"></script>
  <script src="calendar/js/popper.js"></script>
  <script src="calendar/js/bootstrap.min.js"></script>
  <!-- <script src="calendar/js/main.js"></script> -->
  <script src="calendar/js/custom.js"></script>
  <!-- <script src="save_status.js"></script> -->
  <style>
    .container-fluid.container {
      position: relative;
      /* Ensure relative positioning */
      z-index: 2;
      /* Set a higher z-index to ensure the navbar is on top of the carousel */
    }
  </style>
  <nav class="navbar navbar-dark bg-dark navbar-expand-lg d-flex justify-content-between">
    <div class="container-fluid container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="doctor.png" alt="" width="50" height="44" class="d-inline-block align-text-top">
        <p class="my-0 px-2 fw-bold" style="color: antiquewhite;">
          MedicalCenter
        </p>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 px-4 fw-bold">
          <li class="nav-item px-4">
            <a class="nav-link active" aria-current="page" href="index.php?page=home" style="color: antiquewhite;">Home</a>
          </li>
          <?php
          if (isset($_SESSION['loginSuccess']) && $_SESSION['loginSuccess']) {
            echo '<li class="nav-item px-4">
                    <a class="nav-link" href="index.php?page=logout" style="color: antiquewhite;">Logout</a>
                    </li>';
          } else {
            echo '<li class="nav-item px-4">
                    <a class="nav-link" href="index.php?page=login" style="color: antiquewhite;">Login</a>
                    </li>';
          }
          ?>

          <?php
          if (isset($_SESSION['loginSuccess']) && $_SESSION['loginSuccess']) {
            $ID = $_SESSION['ID'];
            $role = $_SESSION['role'];
            $randomImage = $imagePaths[rand(0, count($imagePaths) - 1)];
            echo '
                    <li class="nav-item px-4" style="width: 300px;">
                      <div class="row">
                        <div class="col px-0 col-1" style="width:50px;">
                          <div class="circle">
                            <img src="' . $randomImage . '" alt="Your Image">
                          </div>
                        </div>
                        <div class="col ms-4 mt-2" style="width: 200px;">
                          <p class="my-0" style="color: antiquewhite">Role: ' . $role . '</p>
                        </div>
                      </div>
                    </li>';
          } else {
            echo '<li class="nav-item px-4">
                    <a class="nav-link" href="index.php?page=register" style="color: antiquewhite;">Register</a>     
                    </li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>
  <?php
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $valid_pages = ['home', 'product', 'login', 'register', 'logout'];
    if (in_array($page, $valid_pages)) {
      include($page . '.php');
    } else {
      echo "Page not found";
    }
  }
  else {
    include('home.php');
  }
  ?>
</body>

</html>