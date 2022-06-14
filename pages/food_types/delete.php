<?php 

    session_start();

    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {
        
        require_once('../../../rms/config/app_config.php');

        $link = connectDB();


        $id = $_POST['id'];
        $table_name = trim($_POST['table_name']);

        $query = "DELETE FROM ".$table_name." WHERE id=".$id;

       echo (mysqli_query($link, $query)) ? true : false;
    }
?>