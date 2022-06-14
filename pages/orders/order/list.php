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

        $query = "SELECT 
                    o.id,
                    o.sale_id, 
                    u.name as customer,
                    o.status, 
                    o.created_at, 
                    m.name as item, 
                    c.name as category, 
                    t.name as food_type, 
                    m.price, 
                    tb.type as table_name 
                FROM rms_orders o
                JOIN rms_menus m ON m.id = o.menu_id
                JOIN rms_booked_tables bt ON bt.id = o.booked_tables_id
                JOIN rms_tables tb ON tb.id = bt.table_id
                JOIN rms_category c on  c.id = m.category_id
                JOIN rms_types t on t.id = m.type
                JOIN rms_users u on u.id = bt.user_id
                WHERE date(o.created_at) = '".$date."' 
                AND o.status IN ('ORDERED', 'PREPARING', 'SERVED') 
                ORDER BY o.created_at";

        function getDBData($query, $link) {
            
            $result = mysqli_query($link, $query);

            return $result;
        }

        $data = getDBData($query, $link);

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
                                <li class="active"><a href="./list.php">List All Orders</a></li>
                                <li><a href="../bills/list.php">Bills</a></li>
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Food Type Management</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">List Food Types</a></li>
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
                                        <h4 class="card-title">RMS Orders</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Sale Id</th>
                                                    <th>Customer</th>
                                                    <th>Item</th>
                                                    <th>Catgory</th>
                                                    <th>Food Type</th>
                                                    <th>Price</th>
                                                    <th>Received At</th>
                                                    <th>Table Type</th>
                                                    <th>status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    <?php 
                                                        if (mysqli_num_rows($data) > 0) {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($data)) {?>
                                                                <tr>
                                                                    <td><?php echo $row['sale_id']; ?></td>
                                                                    <td><?php echo $row['customer']; ?></td>
                                                                    <td><?php echo $row['item']; ?></td>
                                                                    <td><?php echo $row['category']; ?></td>
                                                                    <td><?php echo $row['food_type']; ?></td>
                                                                    <td><?php echo $row['price']; ?></td>
                                                                    <td><?php echo $row['created_at']; ?></td>
                                                                    <td><?php echo $row['table_name']; ?></td>
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
                                                                    <td>
                                                                        <button type="button" class="btn mb-1 btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editOrderModal" onclick="updateOrder(<?php echo '\''.$row['id'].'\',\''.$row['status'].'\''; ?>);">Change Status</button>
                                                                    </td>
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

            <div class="modal fade" id="editOrderModal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Order</h5>
                            <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <form action="./update.php" method="POST">
                            <div class="modal-body">
                                
                                <input type="hidden" name="id" id="order_id">

                                <div class="form-group">
                                    <select class="form-control" id="order_status" name="status">    
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
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

            function deleteType(id) {

                    var post_data = {
                        id:id,
                        table_name: 'rms_types'
                    }

                    $.ajax({
                        url: "./delete.php", 
                        type: "post",
                        data: post_data,
                        success: function(result){
                            
                            localStorage.setItem('isSweetAlert',true);

                            if(result) {
                                localStorage.setItem('alertData', 'sweet-success,Delete Status,Food Type deleted successfully,success');
                            } else {
                                localStorage.setItem('alertData', 'sweet-error,Delete Status,Unable to delete the food type. Please try again later,error');
                            }

                            location.reload();
                        }
                    });

                }
        </script>

    </body>
    </html>
<?php 
    } else {
        header('Location: ../../auth/login.php');
    }
?>
