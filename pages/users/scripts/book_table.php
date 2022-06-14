<?php
    session_start();
    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {

        require_once("../../../config/app_config.php");
        $link = connectDB();
        date_default_timezone_set("Asia/Kolkata");
        $quantity =  (int) $_POST['quantity'];
        $table_id =  (int) $_POST['table_id'];
        $user_id = (int) $_SESSION['userData']['id'];
        $status = "booked";
        $date = date("Y-m-d");

        $crossCheckQuery = "SELECT distinct bt.table_id FROM rms_booked_tables bt where bt.user_id = ".$user_id." AND date(bt.created_at) = '".$date."' AND bt.status='booked'";
        $result = mysqli_query($link, $crossCheckQuery);
        if(mysqli_num_rows($result) > 0) {
            echo "You cannot book same table.";
        } else {

            if(isset($quantity) && $quantity > 0 && isset($table_id)) {
                $query = "INSERT INTO rms_booked_tables (table_id, user_id, quantity, status, created_at, updated_at) VALUES(?, ?, ?, ?, ?, ?)";
    
                if($stmt = mysqli_prepare($link, $query)){
                    mysqli_stmt_bind_param($stmt, "iiisss", $param_table_id, $param_user_id, $param_quantity, $param_status, $param_created_at, $param_updated_at);
                    $param_table_id = $table_id; 
                    $param_user_id = $user_id; 
                    $param_quantity = $quantity; 
                    $param_status = $status; 
                    $param_created_at = $date;
                    $param_updated_at = $date;
    
                    if(mysqli_stmt_execute($stmt)){
                        // Redirect to login page
                        header("location: ../table/book_table.php");
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                }
            } else {
                echo "You need to pass the quantity of the table for booking.";
            }
        }
    }
?>