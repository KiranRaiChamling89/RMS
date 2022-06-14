<?php
    session_start();
    require_once('../../../rms/config/app_config.php');

    $link = connectDB();

    $name = trim(ucwords($_POST['name']));
    $ingridents = trim($_POST['ingridents']);
    $category_id = trim($_POST['category_id']);
    $price = trim($_POST['price']);
    $type = trim($_POST['type']);
    $status = trim($_POST['status']);

    if(isset($name)) {
        $selectQuery = "SELECT id FROM rms_menus WHERE name = ? AND category_id = ?";
        $stmt = mysqli_prepare($link, $selectQuery);
        
        mysqli_stmt_bind_param($stmt, "si", $param_name, $param_category_id);
        $param_name = $name;
        $param_category_id = $category_id;

        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            echo mysqli_stmt_num_rows($stmt);
            if(mysqli_stmt_num_rows($stmt) > 0){
                $_SESSION['error'] = "Menu: ".$name." with Category id: ".$category_id." exists. Duplicate entry is not allowed!";
            } else {
                $currentDT = date("Ymdhis");
                $insertQuery = "INSERT INTO rms_menus (name, ingridents, category_id, price, type, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
                if($stmt1 = mysqli_prepare($link, $insertQuery)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt1, "ssidsss", $param_name, $param_ingridents, $param_category_id, $param_price, $param_type, $param_status, $param_created_at);

                    $param_name = $name;
                    $param_ingridents = $ingridents;
                    $param_category_id = $category_id;
                    $param_price = $price;
                    $param_type = $type;
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