<?php 

    session_start();

    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {

        require_once('../../../config/app_config.php');

        $link = connectDB();

        $data = $_POST['data'];

        
        if(isset($data)){

            date_default_timezone_set("Asia/Kolkata");
            $date = date("Y-m-d");
            
            $sale_id = random_strings();
            $userData = $_SESSION['userData'];

            $tableQuery = "SELECT bt.id FROM rms_booked_tables bt where bt.user_id = ".$userData['id']." AND status = 'booked' AND date(bt.created_at) = '".$date."'";
            $stmt = mysqli_query($link, $tableQuery);
            $count = mysqli_num_rows($stmt);
            $tableData = mysqli_fetch_assoc($stmt);
            
            
            foreach ($data as $key => $value) {
                
                $sale_id = $sale_id; 
                $booked_table_id = (int)$tableData['id']; 
                $menu_id = (int)$value['id']; 
                $actual_amount = (float)$value['price']; 
                $tax = (float)($value['price'] * .18) + (float)($value['price'] * .1); 
                $total_amount = (float)((int)$value['quantity'] * (float)$value['price']);
                $status = 'ORDERED'; 
                $quantity = (int)$value['quantity'];
                $t_status = "DUE"; 
                $created_at = $date;
                
                $insertQuery1 = "INSERT INTO rms_orders (sale_id, booked_tables_id, menu_id, status, created_at) VALUES('".$sale_id."', ".$booked_table_id.", ".$menu_id.", '".$status."', '".$created_at."')";
                $insertQuery2 = "INSERT INTO rms_transactions (booked_tables_id, actual_amount, tax, quantity, total_amount, status, created_at) VALUES(".$booked_table_id.", ".$actual_amount.", ".$tax.", ".$quantity.", ".$total_amount.", '".$t_status."', '".$created_at."')";
                
                if(mysqli_query($link, $insertQuery1)){

                    if(mysqli_query($link, $insertQuery2)){
                        echo "SUCCESS";
                        header("location: ./menu.php");
                    }
                } else {
                    die(" rollback :" . mysqli_error($link));
                    $rollBackQuery = "DELETE FROM rms_orders WHERE sale_id = '".$sale_id."'";
                    if(mysqli_query($link, $rollBackQuery)) {
                        echo "Rollbacked";
                    }
                }
            }    
        }
    }

    function random_strings()
    {
    
        // String of all alphanumeric character
        $number_result = '0123456789';
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
        // Shuffle the $str_result and returns substring
        // of specified length
        $rnd_num = substr(str_shuffle($number_result),1,6);
        $rnd_str = substr(str_shuffle($str_result),0,14);

        return str_shuffle($rnd_str.$rnd_num);
    }
?>