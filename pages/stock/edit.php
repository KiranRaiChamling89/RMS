<?php
    session_start();
    require_once('../../../rms/config/app_config.php');

    $link = connectDB();

    $name = trim(ucwords($_POST['name']));
    $description = trim(ucfirst($_POST['description']));
    $category_id = (int)$_POST['category_id'];
    $in_quantity = (float)$_POST['in_quantity'];
    $unit = trim($_POST['unit']);
    $unit_price = (float)$_POST['unit_price'];
    $total_cost = (float)$_POST['total_cost'];
    $in_date = trim($_POST['in_date']);
    $status = trim($_POST['status']);

    if(isset($name)) {
        $selectQuery = "SELECT id FROM rms_stock WHERE item_name = ?";
        $stmt = mysqli_prepare($link, $selectQuery);
        
        mysqli_stmt_bind_param($stmt, "s", $param_name);
        $param_name = $name;

        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            echo mysqli_stmt_num_rows($stmt);
            if(mysqli_stmt_num_rows($stmt) > 0){
                $_SESSION['error'] = "Stock: ".$name." exists. Duplicate entry is not allowed!";
            } else {
                $currentDT = date("Ymdhis");
                $insertQuery = "INSERT INTO rms_stock (item_name, description, category_id, in_quantity, unit, unit_price, total_cost, in_date, remaining_quantity, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                if($stmt1 = mysqli_prepare($link, $insertQuery)){
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt1, "ssidsddsdss", $param_name, $param_description, $param_category_id, $param_in_quantity, $param_unit, $param_unit_price, $param_total_cost, $param_in_date, $param_remaining_quantity, $param_status, $param_created_at);

                    $param_name = $name;
                    $param_description = $description;
                    $param_category_id = $category_id;
                    $param_in_quantity = $in_quantity;
                    $param_unit = $unit;
                    $param_unit_price = $unit_price;
                    $param_total_cost = $total_cost;
                    $param_in_date = $in_date;
                    $param_remaining_quantity = $in_quantity;
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