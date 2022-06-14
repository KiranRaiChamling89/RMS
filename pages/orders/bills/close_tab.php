<?php
    session_start();

    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }

    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {

        require_once('../../../config/app_config.php');

        $link = connectDB();

        $user_id = $_POST['user_id'];
        $table_id = $_POST['table_id'];
        $bt_id = $_POST['bt_id'];

        $btQuery = "SELECT COUNT(id) as id FROM rms_booked_tables WHERE user_id = ".$user_id." and id = ".$bt_id;
        
        $bookedTablesData = mysqli_query($link, $btQuery);

        if(mysqli_num_rows($bookedTablesData) > 0) {
            date_default_timezone_set("Asia/Kolkata");
            $date = date('Y-m-d H:s:i');

            $updateBTQuery = "UPDATE rms_booked_tables SET status = 'available', updated_at = '".$date."' WHERE user_id = ".$user_id." AND id = ".$bt_id;
            
            mysqli_query($link, $updateBTQuery);
            
            $transQuery = "SELECT COUNT(id) as id FROM rms_transactions WHERE booked_tables_id = ".$bt_id." AND status = 'DUE' AND date(created_at)= date('".$date."')";
            $transData = mysqli_query($link, $transQuery);
            
            if(mysqli_num_rows($transData) > 0) {
                $updateTransQuery = "UPDATE rms_transactions SET status = 'PAID', updated_at = '".$date."' WHERE status = 'DUE' AND booked_tables_id = ".$bt_id;

                mysqli_query($link, $updateTransQuery);

                header('location: ./list.php');
            } else {
                $updateBTQuery1 = "UPDATE rms_booked_tables SET status = 'booked', updated_at = '".$date."' WHERE user_id = ".$user_id." AND id = ".$bt_id;
            
                mysqli_query($link, $updateBTQuery1);
                
            }

        }
    }
?>