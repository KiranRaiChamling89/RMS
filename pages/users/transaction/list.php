<?php
    session_start();
    
    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {

        include('../../../config/app_config.php');
        
        $link = connectDB();

        date_default_timezone_set("Asia/Kolkata");
        $date = date('Y-m-d');

        $user = $_SESSION['userData'];

        function getDBData($query, $link) {
            
            $result = mysqli_query($link, $query);

            return $result;
        }

        $transactionQuery = "SELECT 
                                u.id as user_id,
                                u.name,
                                tb.type, 
                                SUM(t.actual_amount * t.quantity) amount, 
                                SUM(t.tax) tax, 
                                SUM(t.quantity) as quantity,
                                SUM((t.actual_amount * t.quantity)+t.tax) as final_amount, 
                                t.status,
                                t.created_at,
                                t.updated_at,
                                sec_to_time(TIMESTAMPDIFF(SECOND,t.created_at,t.updated_at)) AS total_time
                            FROM rms_db.rms_transactions t
                            JOIN rms_booked_tables bt on bt.id = t.booked_tables_id
                            JOIN rms_users u on u.id = bt.user_id AND u.id = ".$user['id']." 
                            JOIN rms_tables tb on bt.table_id = tb.id
                            WHERE t.status = 'PAID' AND date(t.updated_at) = '".$date."'
                            GROUP BY type";
        
        $data = getDBData($transactionQuery, $link);
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
                                        <img src="../../../images/user/1.png" height="40" width="40" alt="">
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
                                        <li><a href="../order/order.php">Check Orders</a></li>
                                        <li clas="active"><a href="./list.php">Transactions</a></li>
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
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Transactions</a></li>
                                <li class="breadcrumb-item active"><a href="javascript:void(0)">Paid Transactions</a></li>
                            </ol>
                        </div>
                    </div>
                    <!-- row -->

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="custom-card-header">
                                            <h4 class="card-title">RMS Transactions</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>Customer</th>
                                                        <th>Table</th>
                                                        <th>Amount</th>
                                                        <th>Oders</th>
                                                        <th>Tax</th>
                                                        <th>Final Amount</th>
                                                        <th>Status</th>
                                                        <th>Started At</th>
                                                        <th>Billed At</th>
                                                        <th>Total Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <?php 
                                                            if (mysqli_num_rows($data) > 0) {
                                                                // output data of each row
                                                                while($row = mysqli_fetch_assoc($data)) {?>
                                                                    <tr>
                                                                        <td><?php echo $row['name']; ?></td>
                                                                        <td><?php echo $row['type']; ?></td>
                                                                        <td><?php echo $row['amount']; ?></td>
                                                                        <td><?php echo $row['quantity']; ?></td>
                                                                        <td><?php echo $row['tax']; ?></td>
                                                                        <td><?php echo $row['final_amount']; ?></td>
                                                                        <td><?php echo $row['status']; ?></td>
                                                                        <td><?php echo $row['created_at']; ?></td>
                                                                        <td><?php echo $row['updated_at']; ?></td>
                                                                        <td><?php echo $row['total_time']; ?></td>
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

            <script src="../../../plugins/tables/js/jquery.dataTables.min.js"></script>
            <script src="../../../plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
            <script src="../../../plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

        </body>
    </html>

<?php 
    } else {
        header('Location: ../../auth');
    }
?>