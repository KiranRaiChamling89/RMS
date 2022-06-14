<?php
    session_start();
    
    if(count($_SESSION) == 0) {
        $_SESSION['loggedIn'] = 0;
    }
    
    $isLoggedIn = $_SESSION['loggedIn'];

    if($isLoggedIn == 1) {

        include('../../../rms/config/app_config.php');
        
        $link = connectDB();

        $menu_query = "SELECT 
                            m.id, 
                            m.name, 
                            m.ingridents, 
                            c.name as category, 
                            t.name as type, 
                            m.price, 
                            m.status, 
                            m.created_at 
                        FROM rms_menus m 
                        JOIN rms_category c ON m.category_id = c.id AND c.status = '1' 
                        JOIN rms_types t ON m.type = t.id and t.status = '1'
                        WHERE m.status = '1'";

        $category_query = "SELECT * FROM rms_category c WHERE c.status = '1'";
        $foodType_query = "SELECT * FROM rms_types t WHERE t.status = '1'";

        function getDBData($query, $link) {
            
            $result = mysqli_query($link, $query);

            return $result;
        }

        $data = getDBData($menu_query, $link);

        $categories = getDBData($category_query, $link);

        $foodTypes = getDBData($foodType_query, $link);
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>RMS</title>
        <!-- Custom Stylesheet -->
        <link href="../../plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="../../css/style.css" rel="stylesheet">
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
                            <a href="../dashboard/main.php" aria-expanded="false">
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
                                <i class="icon-link menu-icon"></i><span class="nav-text">Category </span>
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
                                <li class="active"><a href="list.php">List All Menu</a></li>
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Menu Management</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">List Menus</a></li>
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
                                        <h4 class="card-title">RMS Menus</h4>
                                        <button type="button" class="btn mb-1 btn-primary btn-sm custom-card-btn" data-toggle="modal" data-target="#addMenuModal">Add New</button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Ingridents</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Type</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <?php 
                                                        if (mysqli_num_rows($data) > 0) {
                                                            // output data of each row
                                                            while($row = mysqli_fetch_assoc($data)) {?>
                                                                <tr>
                                                                    <td><?php echo $row['name']; ?></td>
                                                                    <td><?php echo $row['ingridents']; ?></td>
                                                                    <td><?php echo $row['category']; ?></td>
                                                                    <td><?php echo $row['price']; ?></td>
                                                                    <td><?php echo $row['type']; ?></td>
                                                                    <td>
                                                                        <?php
                                                                            if($row['status'] === '1') {
                                                                                echo("<span style='color: green'>ACTIVE</span>");
                                                                            } else {
                                                                                echo("<span style='color: red'>INACTIVE</span>");
                                                                            }
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $row['created_at']; ?></td>
                                                                    <td>
                                                                    <button type="button" class="btn mb-1 btn-primary btn-sm" data-toggle="modal" data-target="#editMenuModal">Edit</button>
                                                                    <button type="button" class="btn mb-1 btn-danger btn-sm" onclick="deleteMenu(<?php $row['id']?>)">Delete</button>
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
                                                                    </tr>
                                                                ';
                                                        }
                                                    ?>
                                                </tr>
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

            <div class="modal fade" id="addMenuModal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Menu</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <form action="./add_Menu.php" method="POST">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Enter Menu Name" required>
                                </div>

                                <div class="form-group">
                                    <textarea type="text" name="ingridents" class="form-control h-150px" rows="3" placeholder="Enter Menu Ingridents" required></textarea>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" id="category" name="category_id">
                                        <?php
                                            if (mysqli_num_rows($categories) > 0) {
                                                // output data of each row
                                                echo "<option value=''>Select Category</option>";
                                                while($row = mysqli_fetch_assoc($categories)) {?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="number" name="price" class="form-control" value="0.0" placeholder="Enter Price" required>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" id="type" name="type">
                                        <?php
                                            if (mysqli_num_rows($foodTypes) > 0) {
                                                // output data of each row
                                                echo "<option value=''>Select Food Type</option>";
                                                while($row = mysqli_fetch_assoc($foodTypes)) {?>
                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php }} ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" id="status" name="status">
                                        <option active value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Submit</button>
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
        <script src="../../plugins/common/common.min.js"></script>
        <script src="../../js/custom.min.js"></script>
        <script src="../../js/settings.js"></script>
        <script src="../../js/gleek.js"></script>
        <script src="../../js/styleSwitcher.js"></script>

        <script src="../../plugins/tables/js/jquery.dataTables.min.js"></script>
        <script src="../../plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
        <script src="../../plugins/tables/js/datatable-init/datatable-basic.min.js"></script>

    </body>
</html>
    <?php 
        } else {
            header('Location: ../auth/login.php');
        }
    ?>