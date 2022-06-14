<?php
    session_start();
    require_once('../../../rms/config/app_config.php');

    $link = connectDB();

    $type = trim(ucwords($_POST['type']));
    $quantity = (int)$_POST['quantity'];
    $status = trim($_POST['status']);

    if(isset($type)) {
        $selectQuery = "SELECT id FROM rms_tables WHERE type = ?";
        $stmt = mysqli_prepare($link, $selectQuery);
        
        mysqli_stmt_bind_param($stmt, "s", $param_type);
        $param_type = $type;

        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            echo mysqli_stmt_num_rows($stmt);
            if(mysqli_stmt_num_rows($stmt) > 0){
                $_SESSION['error'] = "Table Type: ".$type." exists. Duplicate entry is not allowed!";
            } else {
                $currentDT = date("Ymdhis");
                $insertQuery = "INSERT INTO rms_tables (type, quantity, status, created_at) VALUES (?, ?, ?, ?)";
                if($stmt1 = mysqli_prepare($link, $insertQuery)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt1, "siss", $param_type, $param_quantity, $param_status, $param_created_at);

                    $param_type = $type;
                    $param_quantity = $quantity;
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