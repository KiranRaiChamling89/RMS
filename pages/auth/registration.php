
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

        //Define variables and initialize with empty values

        $name = $email = $password = $confirm_password = "";
        $name_err = $email_err = $password_err = $confirm_password_err = "";

        // Processing form data when form is submitted
    
        if($_SERVER['REQUEST_METHOD'] == "POST") {
        
            $name = trim($_POST["name"]);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            $role = '2';
            $status = '1';

            

            // Password and confirm password validataion
            if(strcmp($password, $confirm_password) != 0) {
                $confirm_password_err = "Password not confirmed!";
            }

            // Validate the email in database

            $query = 'SELECT id FROM rms_users WHERE email = ? AND status = ?';
            
            echo $query;

            if($stmt1 = mysqli_prepare($link, $query)){

                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt1, "ss", $param_email, $param_status);

                // Set parameters
                $param_email = $email;
                $param_status = $status;

                if(mysqli_stmt_execute($stmt1)){
                    /* store result */
                    mysqli_stmt_store_result($stmt1);
                    echo mysqli_stmt_num_rows($stmt1);
                    if(mysqli_stmt_num_rows($stmt1) == 1){
                        $email_err = "This email is already taken.";
                        echo $email_err;
                    } else {
                        echo "INSIDE ELSE";
                        if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
                    
                            // Prepare an insert statement
                            $sql = "INSERT INTO rms_users (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)";
                            
                            if($stmt = mysqli_prepare($link, $sql)){
                                // Bind variables to the prepared statement as parameters
                                mysqli_stmt_bind_param($stmt, "sssss", $param_name, $param_email, $param_password, $param_role, $param_status);
                                
                                // Set parameters
                                $param_email = $email;
                                $param_name = $name;
                                $param_role = $role;
                                $param_status = $status;
                                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                            
                                // Attempt to execute the prepared statement
            
                                if(mysqli_stmt_execute($stmt)){
                                    // Redirect to login page
                                    header("location: login.php");
                                } else{
                                    echo "Oops! Something went wrong. Please try again later.";
                                }
                    
                                // Close statement
                                mysqli_stmt_close($stmt);
                            }
                            else {
                                echo "error";
                            }
                        } else {
                            echo "something";
                        }
                    }

                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                

                // Close statement
                mysqli_close($link);
            } else {
                echo "ELSE CONDITION";
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
                                    <a class="text-center" href="index.html"> <h4>Resturant Management System</h4></a>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="mt-5 mb-5 login-input">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control" placeholder="Password"required>
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password"required>
                                        </div>
                                        
                                        <button type="submit" class="btn login-form__btn submit w-100">Sign Up</button>
                                    </form>
                                    <p class="mt-5 login-form__footer">Already have account? <a href="../../../rms/pages/auth/login.php" class="text-primary">Sign In</a> here</p>
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

<?php } ?>