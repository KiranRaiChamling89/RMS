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

        $code = genRandCode();
    
        //Define variables and initialize with empty values

        $email = "";
   
        // Processing form data when form is submitted
    
        if($_SERVER['REQUEST_METHOD'] == "POST") {
        
            $email = trim($_POST['email']);
            $to_email = $email;
            $subject = "Forget Password Verification Code";
            $body = "This is your verification code ".$code;
            $headers = "From: g22glechamhell@gmail.com";
            
            if (mail($to_email, $subject, $body, $headers)) {
                $_SESSION['code'] = $code;
                $_SESSION['email'] = $email;

                header('location: ./verify_code.php');
            } else {
                echo "Email sending failed!";
            }
        }
    }

?>