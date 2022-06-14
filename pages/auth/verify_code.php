

<?php
    session_start();
    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
     $isLoggedIn = $_SESSION['loggedIn'];
 
     if($isLoggedIn == 1) {
         $userData = $_SESSION['userData'];
         switch ($userData['role']) {
             case 2:
                 header('location: ../users/dashboard/main.php');
                 break;
             
             default:
                 header('location: ../dashboard/main.php');
                 break;
         } 
     } else {
 
        include('../../config/app_config.php');
        
        $link = connectDB();
    
        
        // Processing form data when form is submitted
        
        $actualCode = $_SESSION['code'];
        $userEmail = $_SESSION['email'];
        echo $actualCode;
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            

            $code = trim($_POST['code']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);

            //Validate the email in database

            if($code === $actualCode) {
                if($password === $confirm_password){

                    $query = "SELECT id FROM rms_users WHERE status= '1' AND email = '".$userEmail."'";
                    $stm = mysqli_query($link, $query);
    
                    if(mysqli_num_rows($stm) > 0) {
                        $user = mysqli_fetch_array($stm);

                        $newPassword = password_hash($password, PASSWORD_DEFAULT);

                        
                        $updateQuery = "UPDATE rms_users SET password='".$newPassword."' WHERE id=".(int)$user['id'];
                        
                        mysqli_query($link, $updateQuery);
                            
                        header('location: ./login.php');
    
                    } else {
                        echo mysqli_error($link); die;
                    
                    }
                } else {
                    echo "<script>alert('Couldn\'t confirm your password. Please try again.')</script>";    
                }

            }
            else {
                echo "<script>alert('Verification code mismatch!')</script>";
            }
        }
     }
?>


<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>RMS</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="../../css/style.css" rel="stylesheet">
    
</head>

<body class="h-100">

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
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="../../index.php"> <h4>Resturant Management System</h4></a>
                                <p>Change Password with verification code. Please check your email to get your verification code.</p>
        
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="mt-5 mb-5 login-input">
                                    <div class="form-group">
                                        <input type="text" name="code" class="form-control" placeholder="Enter Verification Code" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Enter New Password" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                                    </div>

                                    <button class="btn login-form__btn submit w-100">Reset Password</button>
                                </form>
                                
                                <!-- <p class="mt-5 login-form__footer"> <a href="./registration.php" class="text-primary">Sign Up</a> now</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../plugins/common/common.min.js"></script>
    <script src="../../js/custom.min.js"></script>
    <script src="../../js/settings.js"></script>
    <script src="../../js/gleek.js"></script>
    <script src="../../js/styleSwitcher.js"></script>
</body>
</html>