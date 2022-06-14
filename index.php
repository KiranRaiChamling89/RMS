
<?php
    header('Access-Control-Allow-Origin: *'); 
    session_start();

    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
    $isLoggedIn = $_SESSION['loggedIn'];   

    if($isLoggedIn == 1) {
         $userData = $_SESSION['userData'];
         switch ($userData['role']) {
             case 2:
                 header('location: ./pages/users/dashboard/main.php');
                 break;
             
             default:
                 header('location: ./pages/dashboard/main.php');
                 break;
         } 
    } else {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>RMS</title>
    <!-- Custom Stylesheet -->
    <link href="./css/style.css" rel="stylesheet">
    <style>
        .content-body {
            width: 65%;
        }
    </style>

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    
        <div class="content-body">
            <div class="row">
                <div class="col-12">
                    <h4 class="d-inline">Resturant Management System</h4>
                    <p>Easiest way to <code class="highlighter-rouge">Book & Manage</code> Resturant. </br>To start as a customer start by booking order and use the login card if you already have an account with us. Thanks for visiting RMS.</p>
                    <br><br>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Get Started</h5>
                                    <p class="card-text">If you are an existing customer then use this direct link to login to RMS. We are delighted to have you as our premium partner. Subscribe to get the best offers. <br>Thank you!</p><a href="./pages/auth/login.php" class="btn btn-primary w-100">LOG IN</a>
                                </div>
                            </div>
                        </div>
        
                        <div class="col-lg-6">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Connect with RMS</h5>
                                    <p class="card-text">RMS is one of the best place to visit no mater if you are alone, with friends, family. Sign  up and get a best deal from us and enjoy the best meal in town. <br>Thank you!</p><a href="./pages/auth/registration.php" class="btn btn-primary w-100">SIGN UP</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Col -->
                </div>
            </div>
        </div>

    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

</body>

</html>

<?php } ?>