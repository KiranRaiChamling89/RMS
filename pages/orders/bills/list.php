<?php    
    session_start();

    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {

        $userData = $_SESSION['userData'];
    
        include('../../../config/app_config.php');
    
        $link = connectDB();
        $dataArray = $usersArray = $ordersArray = [];
        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d');

        $users = getCustomer();
        if (mysqli_num_rows($users) > 0) {
            // output data of each row
            $i = 0;
            while($row = mysqli_fetch_assoc($users)) {
                $usersArray[$i] = $row;

                $query = "SELECT 
                            o.id as order_id,
                            u.id as user_id,
                            t.id as table_id,
                            bt.id as bt_id,
                            o.sale_id, 
                            u.name, 
                            t.type, 
                            o.status, 
                            m.name as item,
                            m.price
                        FROM rms_booked_tables bt
                        JOIN rms_users u ON u.id = bt.user_id
                        JOIN rms_orders o ON o.booked_tables_id = bt.id
                        JOIN rms_menus m ON m.id = o.menu_id
                        JOIN rms_tables t ON t.id = bt.table_id
                        WHERE bt.status = 'booked' AND u.id = ".$row['id'];

                $data = mysqli_query($link, $query);
                if (mysqli_num_rows($data) > 0) {
                    // output data of each row
                    $j = 0;
                    while($orders = mysqli_fetch_assoc($data)) {
                        $ordersArray[$i][$j] = $orders;
                        $j++;
                    }
                }
                $i++;
            }
        }

        // var_dump(count($ordersArray));die;


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>RMS</title>
        <!-- Custom Stylesheet -->
        <link href="../../../plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="../../../css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../../../plugins/sweetalert2/dist/sweetalert2.min.css">
        <style>
            .custom-card-header {
                display: flex;
                justify-content: left;
                position: relative;
            }
            .custom-card-btn {
                position: absolute;
                right: 0;
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
                                    <img src="../../images/user/1.png" height="40" width="40" alt="">
                                </div>
                                <div class="drop-down dropdown-profile   dropdown-menu">
                                    <div class="dropdown-content-body">
                                        <ul>
                                            <li><a href="app-profile.html"><i class="icon-user"></i> <span>Profile</span></a></li>
                                            <hr class="my-2">
                                            <li><a href="../../common/logout.php"><i class="icon-key"></i> <span>Logout</span></a></li>
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
                            <a href="../../dashboard/main.php" aria-expanded="false">
                                <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-label">App Management</li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-cup menu-icon"></i><span class="nav-text">Food Type</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../../food_types/list.php">List All Food Type</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-link menu-icon"></i><span class="nav-text">Category</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../../category/list.php">List All Categories</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-layers menu-icon"></i><span class="nav-text">Stock</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../../stock/list.php">List All Stocks</a></li>
                            </ul>
                        </li>


                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-book-open menu-icon"></i><span class="nav-text">Menu Management</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../../menu/list.php">List All Menu</a></li>
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-grid menu-icon"></i><span class="nav-text">Table </span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../../table/list.php">List All Tables</a></li>
                            </ul>
                        </li>

                        <li class="nav-label">Order Management</li>

                        <li>
                            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                <i class="icon-grid menu-icon"></i><span class="nav-text">Orders</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="../order/list.php">List All Orders</a></li>
                                <li class="active"><a href="./list.php">Bills</a></li>
                                <li><a href="../transaction/list.php">Transactions</a></li>
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Bills</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Bill Transaction</a></li>
                        </ol>
                    </div>
                </div>

                <div class="container-fluid mt-3">
                    <div class="row">
                        <?php
                            for ($i=0; $i < count($ordersArray); $i++) { 
                            
                                $isCompleted = false;
                                $count = 0;

                                for($j = 0; $j < count($ordersArray[$i]); $j++) {
                                    if($ordersArray[$i][$j]['status'] == 'COMPLETED') {
                                        $count ++;
                                    }
                                }

                                if($count == count($ordersArray[$i])){
                                    $isCompleted = true;
                                } else {
                                    $isCompleted = false; 
                                }
                        ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <small style="color:blue">Sale ID:</small>
                                            <small class="custom-font-success" style="color:burlywood"><?php echo $ordersArray[$i][0]['sale_id']; ?></small>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <small><b>Customer:</b> <?php echo $ordersArray[$i][0]['name']; ?></small>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <small><b>Booked Table:</b> <?php echo $ordersArray[$i][0]['type']; ?></small>
                                            </div>
                                            <hr>
                                            <div class="row text-center">
                                                <small><b>STATUS</b></small>
                                                <p>
                                                    <?php echo ($isCompleted) ? "<label style='color: red; font-weight: 700'>COMPLETED</label>": "<label style='color: green; font-weight: 700'>RESERVED</label>";?>
                                                </p>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <small><b>Menu</b></small>
                                                </div>
                                                <div class="col-md-4">
                                                    <small><b>Price</b></small>
                                                </div>
                                            </div>

                                            <?php 
                                                for ($j=0; $j < count($ordersArray[$i]); $j++) { 
                                                    
                                            ?>
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <b><small><?php echo $ordersArray[$i][$j]['item']; ?></small></b>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <b><small><?php echo $ordersArray[$i][$j]['price']; ?></small></b>
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>

                                            <br>
                                            <form action="./close_tab.php" method="post">
                                                <input type="hidden" name="user_id" value="<?php echo $ordersArray[$i][0]['user_id']; ?>">
                                                <input type="hidden" name="table_id" value="<?php echo $ordersArray[$i][0]['table_id']; ?>">
                                                <input type="hidden" name="bt_id" value="<?php echo $ordersArray[$i][0]['bt_id']; ?>">
                                                <div class="row">
                                                    <?php echo ($isCompleted) ? '<button type="submit" class="btn mb-1 btn-success btn-rounded btn-xl" style="color:white;">Generate Bill</button>': ''; ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        ?>
                       
                    </div>
                </div>
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

        <script src="../../../plugins/tables/js/jquery.dataTables.min.js"></script>
        <script src="../../../plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
        <script src="../../../plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
        <script src="../../../plugins/sweetalert2/dist/sweetalert2.min.js"></script>

        <script>

            function updateOrder(id, status) {

                document.getElementById("order_id").value = id;
                var codeBlock = '<option active value="">SELECT STATUS</option>';

                if(status === 'ORDERED') {
                    codeBlock += 
                                    '<option active value="PREPARING">PREPARING</option>\
                                    <option active value="SERVED">SERVED</option>\
                                    <option active value="COMPLETED">COMPLETED</option>';
                } else if(status === 'PREPARING') {
                    codeBlock += 
                                    '<option active value="SERVED">SERVED</option>\
                                    <option active value="COMPLETED">COMPLETED</option>';
                } else if(status === 'SERVED') {
                    codeBlock += 
                                    '<option active value="COMPLETED">COMPLETED</option>';
                }

                document.getElementById("order_status").innerHTML = codeBlock;
            }

            function pushUpdate() {
                localStorage.setItem('isSweetAlert',true);
                localStorage.setItem('alertData', 'sweet-success,Update Status,Food Type updated successfully,success');

                location.reload();
            }
        </script>

    </body>
    </html>
<?php 
    } else {
        header('Location: ../../auth/login.php');
    }
?>
