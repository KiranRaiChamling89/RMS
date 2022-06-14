<?php

    session_start();

    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }

    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {

        include('../../../config/app_config.php');

        $link = connectDB();

        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:s:i');

        if(isset($_POST)) {
            $id = $_POST['id'];
            $status = $_POST['status'];

            $query = "UPDATE rms_orders SET status='".$status."', updated_at='".$date."' WHERE id=".$id;
            
            $result = mysqli_query( $link, $query);
           
        }
    }

    header('location: ./list.php');
?>