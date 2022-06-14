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
        date_default_timezone_set("Asia/Kolkata");

        $userData = $_SESSION['userData'];
        $date = date("Y-m-d");
        $hasBooked = false;

        $link = connectDB(); // Get the db connection

        // GET THE TABLE DETAILS
        $menus = getMenuList($link);

        $data = getBookedTables($link, $userData, $date);
        $userbookedTable = [];
        $i = 0;

        if(mysqli_num_rows($data) > 0){
            $hasBooked = true;
            
            while($row = mysqli_fetch_assoc($data)){
                $userbookedTable[$i] = $row;
                $i++;
            }
        }


        // GET PAST ORDER RECORD

        // GET CURRENT BOOKING STATUS
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
                <link href="../../../plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

                <style>
                    .custome-cetered-text {
                        text-align: center;
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
                                        <li><a href="../table/book_table.php">Tables Details</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                        <i class="icon-book-open menu-icon"></i><span class="nav-text">Menu</span>
                                    </a>
                                    <ul aria-expanded="false">
                                        <li class="active"><a href="./menu.php">Check Menu</a></li>
                                    </ul>

                                </li>

                                <li>
                                    <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                                        <i class="icon-layers menu-icon"></i><span class="nav-text">Cart</span>
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
                                    <li class="breadcrumb-item"><a href="javascript:void(0)">Menu</a></li>
                                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Check Menu</a></li>
                                </ol>
                            </div>
                        </div>
                        <!-- row -->

                        <div class="container-fluid mt-3">
                            <?php if($hasBooked) {?>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="custom-media-object-1">
                                                    <?php for($i=0; $i<count($userbookedTable); $i++) { ?>
                                                        <div class="media border-bottom-1 p-t-15">
                                                            <i class="align-self-start mr-3 cc BTC f-s-30"></i>
                                                            <div class="media-body">
                                                                <div class="row">
                                                                    <div class="col-lg-5">
                                                                        <h5><?php echo $userbookedTable[$i]['type']; ?></h5>
                                                                        <p>Type of table</p>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <br>
                                                                        <p class="text-muted f-s-14"><strong><?php echo strtoupper($userbookedTable[$i]['status']); ?></strong></p>
                                                                    </div>
                                                                    <div class="col-lg-5 text-right">
                                                                        <h5 class="text-muted">No. of tables <i class="color-danger ti-minus m-r-5"></i> <span class="BTC m-l-20"><?php echo $userbookedTable[$i]['quantity']; ?></span></h5>
                                                                        <p class="f-s-13 text-muted"><?php echo $userbookedTable[$i]['created_at']; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <br>
                                                    <div class="media border-bottom-1 p-t-25">
                                                        <div class="media-body">
                                                            <div class="row">
                                                                <div class="col-lg-5">
                                                                    <h5>Order Food</h5>
                                                                    <p>Select the food from the menu below and click checkout button to order your meal.</p>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <br>
                                                                    <p class="text-muted f-s-14"><strong></strong></p>
                                                                </div>
                                                                <div class="col-lg-5 text-right">
                                                                    <h5 class="text-muted">Total <i class="color-danger ti-minus m-r-5"></i> Rs. <span class="BTC m-l-20" id="total"></span> /- without tax.</h5>
                                                                    <p class="f-s-13 text-muted"><strong>Quantity Ordered<i class="color-danger ti-minus m-r-5"></i><span id="quantity"></span> </strong></p>
                                                                    <p>
                                                                        <button type="button" class="btn mb-1 btn-warning btn-xs" data-bs-toggle="modal" data-bs-target="#checkouteModal" onclick="getDetails();">Checkout</button>
                                                                        <button id="clearCart" class="btn mb-1 btn-danger btn-xs" onclick="clearStorage();">Cancel Order</button>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row">

                                <?php
                                    foreach ($menus as $key=>$value) { 
                                ?>
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title custome-cetered-text"><?php echo $key; ?></h4>
                                                <hr>
                                            </div>
                                            <div class="card-body">

                                                <?php
                                                    foreach ($value as $k => $data) {
                                                ?>

                                                    <div class="row align-items-center justify-content-between">
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <h4><?php echo $data['name']; ?></h4>
                                                            </div>
                                                            <div class="row">
                                                                <label for=""><?php echo $data['ingridents']; ?></label>
                                                            </div>
                                                            <br>
                                                            <div class="row">
                                                                <?php if($hasBooked) {?>
                                                                    <div class="col-md-6">
                                                                        <input type="number" value="0" min="1" id="<?php echo $data['name'].$data['id']; ?>" required>
                                                                    </div>
                                                                    <div class="offset-md-1 col-md-3">
                                                                        <button class="btn mb-1 btn-primary btn-xs" onclick="addMenu('<?php echo $data['name'];?>', '<?php echo $data['id'];?>')">Add</button>
                                                                    </div>
                                                                <?php } else {?>
                                                                    <div class="col-md-12">
                                                                        <em><small>Please try booking the table first to order your food. Thanks!</small></em>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <input type="hidden" id="price<?php echo $data['name'].$data['id']; ?>" value="<?php echo $data['price'];?>">
                                                                <h4>RS. <?php echo $data['price']; ?> /-</h4>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                <?php 
                                                    }
                                                ?>


                                            </div>
                                        </div>
                                    </div>
                                <?php
                                    }
                                ?>
                               
                            </div>
                        </div>
                        <!-- #/ container -->
                    </div>

                    <div class="modal fade" id="checkouteModal">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Checkout</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <!-- <form action="./bill.php" method="POST"> -->
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="card">
                                                <div class="card-body" id="checkout_body">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success" onclick="confirmOrder();">Confirm Order</button>
                                    </div>
                                <!-- </form> -->
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

                <script src="../../../plugins/sweetalert2/dist/sweetalert2.min.js"></script>

                <script>

                    var cart = [];
                    var appendFlag = true;

                    qnt = document.getElementById("quantity");
                    amt = document.getElementById("total");

                    a = localStorage.getItem("total_amount");
                    b = localStorage.getItem("total_items");

                    if(localStorage.getItem("isSweetAlert") == "true") {
                        localStorage.getItem("isSweetAlert");
                        alertArray = localStorage.getItem("alertData").split(',');

                        setTimeout(() => {
                            sweetAlert(alertArray[1], alertArray[2], alertArray[3]);
                            localStorage.setItem("isSweetAlert", false);
                            localStorage.setItem("alertData", "");
                        }, 1000);
                    }
                    
                    if(a != null && a != undefined) {
                        amt.innerHTML = a;
                    }

                    if(b != null && b != undefined) {
                        qnt.innerHTML = b;
                    }
                    
                    function addMenu(name, id) {
                        localCart = [];
                        var localObj = {};
                        
                        var quantity = document.getElementById(name+id).value;
                        var price = document.getElementById("price"+name+id).value;

                        localObj = {
                            id: id,
                            name: name,
                            quantity: quantity,
                            price: price
                        };

                        var data = localStorage.getItem('cart');
                        
                        if(data != null && data != undefined) {
                            localCart = JSON.parse(data);
                        }
                        
                        localCart.push(localObj);
                        localStorage.setItem("cart", JSON.stringify(localCart));

                        calculateTotalQuantity();
                    }

                    function calculateTotalQuantity() {
                        items = 0;
                        amount = 0.0;
                        temp_items = 0;
                        temp_amount = 0.0;
                        local_data = [];

                        //Get local data
                        data = JSON.parse(localStorage.getItem('cart'));
                        val = localStorage.getItem("total_amount");
                        itm = localStorage.getItem("total_items");

                        if (val != null && val != undefined) {
                            temp_amount = val;
                        }

                        if ( itm != null && itm != undefined) {
                            temp_items = itm;
                        }
                        
                        if ( data != null && data != undefined) {
                            local_data = data;
                        }


                        local_data.forEach(element => {
                            amount = parseFloat(temp_amount) + (parseFloat(element.price) * parseInt(element.quantity));
                            items = parseInt(temp_items) + parseInt(element.quantity);
                        });

                        localStorage.setItem("total_amount", amount);
                        localStorage.setItem("total_items", items);

                        qnt = document.getElementById("quantity");
                        amt = document.getElementById("total");
                        qnt.innerHTML = items;
                        amt.innerHTML = amount;

                    }

                    function getDetails() {
                        if(appendFlag){
                            appendFlag = false;
                            data = JSON.parse(localStorage.getItem("cart"));
                            amt = localStorage.getItem("total_amount");
                            itms = localStorage.getItem("total_items");
    
                            if(data != null && data != undefined) {
    
                                tax = (((parseFloat(amt)/100) * 18) + (parseFloat(amt)/10)).toFixed(2);
    
                                total_amt = parseFloat(amt) + parseFloat(tax);
    
                                data.forEach(element => {
                                    var codeBlock = '<div class="custom-media-object-1">\
                                                        <div class="media border-bottom-1 p-t-15">\
                                                            <div class="media-body">\
                                                                <div class="row">\
                                                                    <div class="col-lg-5">\
                                                                        <h5>'+element.name+'</h5>\
                                                                    </div>\
                                                                    <div class="col-lg-2">\
                                                                        <p class="text-muted f-s-14">'+element.quantity+'</p>\
                                                                    </div>\
                                                                    <div class="col-lg-5 text-right">\
                                                                        <p class="f-s-13 text-muted">'+parseInt(element.quantity)*parseFloat(element.price)+'</p>\
                                                                    </div>\
                                                                </div>\
                                                            </div>\
                                                        </div>\
                                                    </div>';
                                    
                                    document.getElementById("checkout_body").innerHTML += codeBlock;    
                                });
    
                                if(itms != null && itms != undefined && amt != null && amt != undefined) {
    
                                    var codeBlock = '<div class="custom-media-object-1">\
                                                        <div class="media border-bottom-1 p-t-15">\
                                                            <div class="media-body">\
                                                                <div class="row">\
                                                                    <div class="col-lg-5">\
                                                                        <h5>All Taxes</h5>\
                                                                    </div>\
                                                                    <div class="col-lg-2">\
                                                                        <p class="text-muted f-s-14"></p>\
                                                                    </div>\
                                                                    <div class="col-lg-5 text-right">\
                                                                        <p class="f-s-13 text-muted">'+tax+'</p>\
                                                                    </div>\
                                                                </div>\
                                                            </div>\
                                                        </div>\
                                                    </div>\
                                                    <div class="media border-bottom-1 p-t-15">\
                                                        <div class="media-body">\
                                                            <div class="row">\
                                                                <div class="col-lg-5">\
                                                                    <h5>Total (with Taxes)</h5>\
                                                                </div>\
                                                                <div class="col-lg-2">\
                                                                    <p class="text-muted f-s-14">'+itms+'</p>\
                                                                </div>\
                                                                <div class="col-lg-5 text-right">\
                                                                    <p class="f-s-13 text-muted">'+total_amt+'</p>\
                                                                </div>\
                                                            </div>\
                                                        </div>\
                                                    </div>' ;
    
                                    document.getElementById("checkout_body").innerHTML += codeBlock;
                                }
                            }
                        }
                    }

                    function confirmOrder() {

                        if(localStorage.key('çart') != null) {
                            post_data = {
                                data : JSON.parse(localStorage.getItem('cart'))
                            }

                            console.log(post_data.data);

                            $.ajax({
                                url: "./bill.php", 
                                type: "post",
                                data: post_data,
                                success: function(result){
                                    setInterval(() => {
                                        localStorage.clear();
                                        localStorage.setItem('isSweetAlert',true);
                                        localStorage.setItem('alertData', 'sweet-wrong,Order,Your request submitted successfull!,success');
                                        location.reload();
                                    }, 3000);
                                }
                            });
                        } else {
                            confirmOrder();
                        }
                    }

                    function clearStorage() {
                        if(confirm("Are you sure?")) {
                            localStorage.clear();
                            localStorage.setItem('isSweetAlert',true);
                            localStorage.setItem('alertData', 'sweet-wrong,Clear Menu,Your request to clear menu was successfull!,error');
                            location.reload();
                        }
                    }

                    
                </script>
            </body>
        </html>

<?php
    }else {
        header('location: ../../auth/login.php');
    }
?>