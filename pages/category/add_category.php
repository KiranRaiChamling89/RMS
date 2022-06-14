<?php
    session_start();
    require_once('../../../rms/config/app_config.php');

    $name = trim(ucwords($_POST['name']));
    $status = trim($_POST['status']);

    $link = connectDB();

    if(isset($name)) {
        $selectQuery = "SELECT id FROM rms_category WHERE name = ?";
        $stmt = mysqli_prepare($link, $selectQuery);
        
        mysqli_stmt_bind_param($stmt, "s", $param_name);
        $param_name = $name;

        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            echo mysqli_stmt_num_rows($stmt);
            if(mysqli_stmt_num_rows($stmt) > 0){
                $_SESSION['error'] = "Category: ".$name." exists. Duplicate entry is not allowed!";
            } else {
                $currentDT = date("Ymdhis");
                $insertQuery = "INSERT INTO rms_category (name, status, created_at) VALUES (?, ?, ?)";
                if($stmt1 = mysqli_prepare($link, $insertQuery)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt1, "sss", $param_name, $param_status, $param_created_at);

                    $param_name = $name;
                    $param_status = $status;
                    $param_created_at = $currentDT;

                    if(mysqli_stmt_execute($stmt1)){
                        // Redirect to login page
                        header("location: list.php");
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
        
                    // Close statement
                    mysqli_stmt_close($stmt);
                    mysqli_stmt_close($stmt1);
                }
            }
        }
    }
    
    
?>