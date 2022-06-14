<?php

    session_start();
    
    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {
        // INCLUDE ALL THE REQUIRED FILES:
        include('../../../config/app_config.php');
        include('../scripts/menu.php');
        include('../scripts/tables.php');

        $link = connectDB(); // Get the db connection

        $flag = false;
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d');
        $tables = $tempTable = [];
        $tableCount = $bookedCount = $availableTables = 0;

        // GET THE TABLE DETAILS
        $tableData = getAllTablesCount($link);
        $bookedData = getBookedTablesCount($link, $date);
        
        if(mysqli_num_rows($tableData) > 0) {
            $totalTables = mysqli_fetch_assoc($tableData);
        }

        if(mysqli_num_rows($bookedData) > 0) {
            $bookedTables = mysqli_fetch_assoc($bookedData);
        }

        $tableCount = (int) $totalTables['quantity'];
        $bookedCount = (int) $bookedTables['quantity'];

        ($tableCount >= $bookedCount) ? $availableTables = $tableCount - $bookedCount : 0;

        // ---------------------------------------------------------------------------------

        $allTable = getAllTables($link);
        $allBookedTables = getTotalBookedTableQuantity($link, $date);

        foreach ($allTable as $tableKey => $tabeleValue) {
            foreach ($allBookedTables as $btKey => $btValue) {
                if($tabeleValue['type'] == $btValue['type']) {
                    $flag = true;
                    $tempTable['id']= $btValue['table_id'];
                    $tempTable['quantity']= $btValue['quantity'];
                    $tempTable['booked_quantity']= $btValue['booked_quantity'];
                    ((int) $btValue['quantity'] >= (int) $btValue['booked_quantity']) ? 
                        $tempTable['remaining_quantity']= (int) $btValue['quantity'] - (int) $btValue['booked_quantity'] : $tempTable['remaining_Quantity'] = 0;
                }
            }
            
            if(!$flag) {
                $tempTable['id']= $tabeleValue['id'];
                $tempTable['quantity']= $tabeleValue['quantity'];
                $tempTable['booked_quantity']= 0;
                $tempTable['remaining_quantity']= $tabeleValue['quantity'];
            }
            $flag=false;
            $tables[$tabeleValue['type']] = $tempTable;
        }
?>

        <!DOCTYPE html>
        <html lang="en">

            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width,initial-scale=1">
                <title>RMS</title>
                <!-- Custom Stylesheet -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
                <link href="../../../css/style.css" rel="stylesheet">
                <link rel="stylesheet" href="../../../plugins/sweetalert2/dist/sweetalert2.min.css">

                <style>
                    .custom-font-success {
                        color: green;
                        font-weight: 700;
                    }

                    .custom-font-danger {
                        color: red;
                        font-weight: 700;
                    }

                    .center-text{
                        text-align:center;
                    }
                </style>
            </head>

            <body>
                <!--*******************
                    Preloader start
                ********************-->
                <div id="preloader">
                    <div class="loader">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
                        </svg>
                    </div>
                </div>
                <!--*******************
                    Preloader end
                ********************-->

                
                <!--**********************************
                    Main wrapper start
                ***********************************-->
                <div id="main-wrapper">

                    <!--**********************************
                        Nav header start
                    ***********************************-->
                    <div class="nav-header">
                        <div class="brand-logo">
                            <a href="index.html">
                                <b class="logo-abbr">RMS </b>
                                <span class="logo-compact">RMS</span>
                                <span class="brand-title">
                                    <label for="">RMS</label>
                                </span>
                            </a>
                        </div>
                    </div>
                    <!--**********************************
                        Nav header end
                    ***********************************-->

                    <!--**********************************
                        Header start
                    ***********************************-->
                    <div class="header">    
                        <div class="header-content clearfix">
                            
                            <div class="nav-control">
                                <div class="hamburger">
                                    <span class="toggle-icon"><i class="icon-menu"></i></span>
                                </div>
                            </div>
                            
                            <div class="header-right">
                                <ul class="clearfix">
                                    
                                    <li class="icons dropdown">
                                        <div class="user-img c-pointer position-relative"   data-toggle="dropdown">
                                            <span class="activity active"></span>
                                            <img src="../../../images/avatar/7.png" height="40" width="40" alt="">
                                        </div>
                                        <div class="drop-down dropdown-profile   dropdown-menu">
                                            <div class="dropdown-content-body">
                                                <ul>
                                                    <li>
                                                        <a href="app-profile.html"><i class="icon-user"></i> <span>Profile</span></a>
                                                    </li>                                       
                                                    <hr class="my-1">
                                                    <li>
                                                        <a href="../../common/logout.php"><i class="icon-key"></i> <span>Logout</span></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--**********************************
                        Header end ti-comment-alt
                    ***********************************-->

                    <!--**********************************
                        Sidebar start
                    ***********************************-->
                    <div class="nk-sidebar">           
                        <div class="nk-nav-scroll">
                            <ul class="metismenu" id="menu">
                                
                                <li>
                                    <a href="../dashboard/main.php" aria-expanded="false">
                                        <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                                    </a>
                                </li>

                                <li class="nav-label">Order Management</li>

                                <li>
                                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                        <i class="icon-grid menu-icon"></i><span class="nav-text">Check Table</span>
                                    </a>
                                    <ul aria-expanded="false">
                                        <li class="active"><a href="./book_table.php">Table Details</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                        <i class="icon-book-open menu-icon"></i><span class="nav-text">Menu</span>
                                    </a>
                                    <ul aria-expanded="false">
                                        <li><a href="../order/menu.php">Check Menu</a></li>
                                    </ul>

                                </li>

                                <li>
                                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                        <i class="icon-layers menu-icon"></i><span class="nav-text">Orders</span>
                                    </a>
                                    <ul aria-expanded="false">
                                        <li><a href="../order/order.php">Check Orders</a></li>
                                        <li><a href="../transaction/list.php">Transactions</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!--**********************************
                        Sidebar end
                    ***********************************-->

                    <!--**********************************
                        Content body start
                    ***********************************-->
                    <div class="content-body">

                        <div class="row page-titles mx-0">
                            <div class="col p-md-0">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Check Table</a></li>
                                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Table Details</a></li>
                                </ol>
                            </div>
                        </div>
                        <!-- row -->

                        <div class="container-fluid mt-3">
                            <div class="row">

                                <?php
                                    foreach ($tables as $key=>$value) { 
                                ?>

                                    <div class="col-md-6 col-lg-3">
                                        <div class="card text-center">
                                            <div class="card-body">
                                                <h4 class="card-title custom-font-success"><u><?php echo $key; ?></u></h4>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <i class="fa fa-sitemap fa-3x"></i>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small>Total Tables:</small>
                                                    </div>
                                                    <div class="offset-md-2 col-md-4">
                                                        <h3><?php echo $value['quantity'];?></h3>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small>Reserved:</small>
                                                    </div>
                                                    <div class="offset-md-2 col-md-4">
                                                        <h3><?php echo $value['booked_quantity'];?></h3>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <small>Available:</small>
                                                    </div>
                                                    <div class="offset-md-2 col-md-4">
                                                        <h3><?php echo $value['remaining_quantity'];?></h3>
                                                    </div>
                                                </div>

                                                <br>
                                                <?php
                                                    if($value['remaining_quantity'] > 0){
                                                ?>
                                                        <form action="../scripts/book_table.php" method="POST">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="hidden" name="table_id" value="<?php echo $value['id']; ?>">
                                                                    <input name="quantity" class="center-text" type="number" min="0" max="<?php echo $value['remaining_quantity']; ?>" value="0">
                                                                </div>
                                                                <div class="offset-md-2 col-md-4">
                                                                    <?php ?>
                                                                    <button type="submit" class="btn mb-1 btn-warning btn-rounded btn-sm" onclick="changeAlertStorage();">Book</button>
                                                                </div>
                                                            </div>
                                                        </form>

                                                <?php 
                                                    } else{
                                                ?>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input name="quantity" class="center-text" type="number" min="0" max="<?php echo $value['remaining_quantity']; ?>" value="0" readonly>
                                                        </div>
                                                        <div class="offset-md-2 col-md-4 disabled-button">
                                                            <button type="button" class="btn mb-1 btn-secondary btn-rounded btn-sm">Book</button>
                                                        </div>
                                                    </div>
                                                <?php

                                                }?>
                                            </div>
                                            <?php 
                                                if((int) $value['remaining_quantity'] > 0) {
                                            ?>
                                                <div class="card-footer custom-font-success">Available for booking</div>

                                            <?php
                                                } else {
                                            ?>
                                                <div class="card-footer custom-font-danger">Not available for booking</div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                               
                            </div>
                        </div>
                        <!-- #/ container -->
                    </div>
                    <!--**********************************
                        Content body end
                    ***********************************-->
                    
                </div>
                <!--**********************************
                    Main wrapper end
                ***********************************-->

                <!--**********************************
                    Scripts
                ***********************************-->
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
                <script src="../../../plugins/common/common.min.js"></script>
                <script src="../../../js/custom.min.js"></script>
                <script src="../../../js/settings.js"></script>
                <script src="../../../js/gleek.js"></script>
                <script src="../../../js/styleSwitcher.js"></script>

                <script src="../../../plugins/sweetalert2/dist/sweetalert2.min.js"></script>

                <script>
                    console.log(typeof(localStorage.getItem("isSweetAlert")));
                    if(localStorage.getItem("isSweetAlert") === "true") {
                        localStorage.getItem("isSweetAlert");
                        alertArray = localStorage.getItem("alertData").split(',');

                        setTimeout(() => {
                            sweetAlert(alertArray[1], alertArray[2], alertArray[3]);
                            localStorage.setItem("isSweetAlert", false);
                            localStorage.setItem("alertData", "");
                        }, 1000);
                    }

                    function changeAlertStorage() {
                        localStorage.setItem('isSweetAlert',true);
                        localStorage.setItem('alertData', 'sweet-success,Table Booked,Your booking got confirmed!,success');
                    }
                </script>

            </body>
        </html>

<?php
    }else {
        header('location: ../../auth/login.php');
    }
?>