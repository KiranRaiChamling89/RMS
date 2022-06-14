<?php
    /* Database credentials. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'rms_db');
    
    function connectDB() {
        /* Attempt to connect to MySQL database */
        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
        // Check connection
        if($link === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        return $link;
    }

    function genRandCode(){
        $nums="0123456789";

        $randNo = substr(str_shuffle($nums),0,8);
        return $randNo;
    }

    function getCustomer($id=0) {
        $link = connectDB();
        date_default_timezone_set("Asia/Kolkata");
        $date = date("Y-m-d");
        if($id == 0)
            $query = "SELECT u.id, u.name from rms_users u JOIN rms_booked_tables bt ON bt.user_id = u.id AND bt.status = 'booked' AND date(bt.created_at) = '".$date."' WHERE u.role = 2 AND u.status=1";
        else
            $query = "SELECT u.id, u.name from rms_users u JOIN rms_booked_tables bt ON bt.user_id = u.id AND bt.status = 'booked' AND date(bt.created_at) = '".$date."' WHERE u.role = 2 AND u.status=1 AND u.id =".$id;
        
        $result = mysqli_query($link, $query);
        
        return $result;
    }
   
?>