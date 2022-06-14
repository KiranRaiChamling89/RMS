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
        // include('../scripts/tables.php');

        $link = connectDB(); // Get the db connection

        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d H:s:i');

        $orders = getOrders($link, $_SESSION['userData']['id']);
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
                                        <li><a href="../table/book_table.php">Table Details</a></li>
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
                                        <li class="active"><a href="./order.php">Check Orders</a></li>
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
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Check Orders</a></li>
                                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Orders</a></li>
                                </ol>
                            </div>
                        </div>
                        <!-- row -->

                        <div class="container-fluid mt-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="custom-card-header">
                                                <h4 class="card-title">RMS Orders</h4>
                                                <span>Note: This page will auto-reload in every 30 secs.</span>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
                                                <table class="table table-bordered zero-configuration">
                                                    <thead>
                                                        <tr>
                                                            <th>Sale Id</th>
                                                            <th>Item</th>
                                                            <th>Category</th>
                                                            <th>Food Type</th>
                                                            <th>Price (INR)</th>
                                                            <th>Status</th>
                                                            <th>Wait Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php 
                                                                if (mysqli_num_rows($orders) > 0) {
                                                                    // output data of each row
                                                                    while($row = mysqli_fetch_assoc($orders)) {?>
                                                                        <tr>
                                                                            <td><?php echo $row['sale_id']; ?></td>
                                                                            <td><?php echo $row['name']; ?></td>
                                                                            <td><?php echo $row['category']; ?></td>
                                                                            <td><?php echo $row['food_type']; ?></td>
                                                                            <td><?php echo $row['price']; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                    if($row['status'] === 'ORDERED') {
                                                                                        echo("<span style='color: red; font-weight: 700;'>ORDERED</span>");
                                                                                    } elseif($row['status'] === 'PREPARING'){
                                                                                        echo("<span style='color: green; font-weight: 700;'>PREPARING</span>");
                                                                                    } elseif($row['status'] === 'SERVED'){
                                                                                        echo("<span style='color: orange; font-weight: 700;'>SERVED</span>");
                                                                                    }else {
                                                                                        echo("<span style='color: gray'>COMPLETED</span>");
                                                                                    }
                                                                                ?>
                                                                            </td>
                                                                            <td>NA</td>
                                                                        </tr>
                                                            <?php
                                                                    }
                                                                } else {
                                                                    echo '
                                                                            <tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                            </tr>
                                                                        ';
                                                                }
                                                            ?>
                                                    </tbody>
                                                </table>
                                            </div>
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
                <script src="../../../plugins/common/common.min.js"></script>
                <script src="../../../js/custom.min.js"></script>
                <script src="../../../js/settings.js"></script>
                <script src="../../../js/gleek.js"></script>
                <script src="../../../js/styleSwitcher.js"></script>

                <script>
                    setInterval(() => {
                        location.reload();
                    }, 30000);
                </script>

            </body>
        </html>

<?php
    }else {
        header('location: ../../auth/login.php');
    }
?>