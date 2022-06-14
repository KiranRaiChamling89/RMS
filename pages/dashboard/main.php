<?php
    session_start();

    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {
        include('../../config/app_config.php');
    
        $link = connectDB();

        $allTableQuery = "SELECT COUNT(id) as tables_count FROM rms_db.rms_tables WHERE status = 1"; 
        $allUsersQuery = "SELECT COUNT(id) as total_users FROM rms_db.rms_users WHERE role = 2";
        $activeUsersQuery = "SELECT COUNT(id) as total_users FROM rms_db.rms_users WHERE role = 2 AND status = 1";
        $inactiveUsersQuery = "SELECT COUNT(id) as total_users FROM rms_db.rms_users WHERE role = 2 AND status = 0";

        //DECLARE ARRAY
        $allUsers = $activeUsers = $inactiveUsers = $totalTables = [];
        
        $data1 = mysqli_query($link, $allUsersQuery);
        $data2 = mysqli_query($link, $activeUsersQuery);
        $data3 = mysqli_query($link, $inactiveUsersQuery);
        $data4 = mysqli_query($link, $allTableQuery);

        if(mysqli_num_rows($data1)>0) {
            $allUsers = mysqli_fetch_array($data1);
        }
        if(mysqli_num_rows($data2)>0) {
            $activeUsers = mysqli_fetch_array($data2);
        }
        if(mysqli_num_rows($data3)>0) {
            $inactiveUsers = mysqli_fetch_array($data3);
        }
        if(mysqli_num_rows($data4)>0) {
            $totalTables = mysqli_fetch_array($data4);
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
        <link href="../../css/style.css" rel="stylesheet">
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
                                    <img src="../../images/avatar/7.png" height="40" width="40" alt="">
                                </div>
                                <div class="drop-down dropdown-profile   dropdown-menu">
                                    <div class="dropdown-content-body">
                                        <ul>
                                            <li><a href="app-profile.html"><i class="icon-user"></i> <span>Profile</span></a></li>
                                            <hr class="my-2">
                                            <li><a href="../common/logout.php"><i class="icon-key"></i> <span>Logout</span></a></li>
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
                            <a href="./main.php" aria-expanded="false">
                                <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-label">App Management</li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-cup menu-icon"></i><span class="nav-text">Food Type</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../food_types/list.php">List All Food Type</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-link menu-icon"></i><span class="nav-text">Category</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../category/list.php">List All Categories</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-layers menu-icon"></i><span class="nav-text">Stock</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../stock/list.php">List All Stocks</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-book-open menu-icon"></i><span class="nav-text">Menu</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../menu/list.php">List All Menu</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-grid menu-icon"></i><span class="nav-text">Table</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../table/list.php">List All Tables</a></li>
                            </ul>
                        </li>

                        <li class="nav-label">Order Management</li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-grid menu-icon"></i><span class="nav-text">Orders</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../orders/order/list.php">List All Orders</a></li>
                                <li><a href="../orders/bills/list.php">Bills</a></li>
                                <li><a href="../orders/transaction/list.php">Transactions</a></li>
                            </ul>
                        </li>

                        <li class="nav-label">General</li>
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card gradient-1">
                                <div class="card-body">
                                    <h3 class="card-title text-white">Available Table</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white"><?php echo $totalTables['tables_count']?></h2>
                                    </div>
                                    <span class="float-right display-5 opacity-5"><i class="fa fa-sitemap"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card gradient-3">
                                <div class="card-body">
                                    <h3 class="card-title text-white">Total Customers</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white"><?php echo $allUsers['total_users']?></h2>
                                    </div>
                                    <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card gradient-4">
                                <div class="card-body">
                                    <h3 class="card-title text-white">Active Customer</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white"><?php echo $activeUsers['total_users']?></h2>
                                    </div>
                                    <span class="float-right display-5 opacity-5"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card gradient-4">
                                <div class="card-body">
                                    <h3 class="card-title text-white">Inactive Customer</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white"><?php echo $inactiveUsers['total_users']?></h2>
                                    </div>
                                    <span class="float-right display-5 opacity-5"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>
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
        <script src="../../plugins/common/common.min.js"></script>
        <script src="../../js/custom.min.js"></script>
        <script src="../../js/settings.js"></script>
        <script src="../../js/gleek.js"></script>
        <script src="../../js/styleSwitcher.js"></script>

    </body>
</html>

<?php
    } else {
        $userData = $_SESSION['userData'];
        header('location: ../auth/login.php'); 
    }
?>