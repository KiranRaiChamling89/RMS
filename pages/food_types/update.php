<?php
    session_start();
    require_once('../../../rms/config/app_config.php');

    $link=connectDB();

    $id = (int)$_POST['id'];
    $name = trim(ucwords($_POST['name']));
    $status = trim($_POST['status']);

    if(isset($id)) {
        $selectQuery = "SELECT id FROM rms_types WHERE id = ?";
        $stmt = mysqli_prepare($link, $selectQuery);
        
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;

        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            echo mysqli_stmt_num_rows($stmt);
            if(mysqli_stmt_num_rows($stmt) > 0){
                $currentDT = date("Ymdhis");
                $updatetQuery = "UPDATE rms_types SET name = ?, status = ?, updated_at = ? WHERE id = ?";
                if($stmt1 = mysqli_prepare($link, $updatetQuery)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt1, "sssi", $param_name, $param_status, $param_updated_at, $param_id);

                    $param_id = $id;
                    $param_name = $name;
                    $param_status = $status;
                    $param_updated_at = $currentDT;

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
            } else {
                $_SESSION['error'] = "id not found!";
            }
        }
    }
    
    
?>