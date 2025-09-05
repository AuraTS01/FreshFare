<?php 
include('./database.php'); 


if (isset($_SESSION['user'])) {

    if((time() - $_SESSION['last_login_timestamp']) > 600) {
        header("Location:./logout.php");  
    } else {
        $_SESSION['last_login_timestamp'] = time();  
        $sql = "SELECT * FROM `fresh_fare_signup` WHERE `email`='" . $_SESSION["email"] . "'";
        $result = mysqli_query($login_db, $sql);
        $no = mysqli_fetch_array($result);
        if($no != 0) {
            $category = $no['category'];
?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fresh Fare">
    <meta name="keywords" content="Fresh, Fare, organic">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fresh Fare</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- CSS Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>

<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>
<div class="content-wrapper">
    <!-- Humberger Menu Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="header__logo d-flex align-items-center">
            <a href="./index.php" class="logo-brand d-flex align-items-center text-decoration-none">
                <img src="img/logo.png" alt="Logo" class="logo-img">
                <span class="logo-text"><span class="logo-green">F</span><span class="logo-black">resh </span><span class="logo-green">F</span><span class="logo-black">are</span></span>
            </a>
        </div>

        <div class="humberger__menu__widget">
            <div class="header__top__right__auth">
                <a href="./logout"><i class="fa fa-user"></i> Logout</a>
        
                <ul>
                     <?php if ($category === 'sup_admin'): ?>
                        <li><a href="./adm_dashboard">Dashboard</a></li>
                        <li><a href="./view_companies">View Registered Companies</a></li>
                        <li><a href="./enroll_company">Enroll New Company</a></li>
                        <li><a href="./order_list">View Orders List</a></li>
                    <?php elseif ($category === 'company'): ?>
                        <li><a href="./com_dashboard">Dashboard</a></li>
                        <li><a href="./view_company_order_list">View Order List</a></li>
                        <li><a href="./view_company_dispatched_list">View Dispatched Order List</a></li>
                        <li><a href="./com_fixPrice">Fix Price for Products</a></li>
                    <?php elseif ($category === 'delivery_agent'):  ?>
                        <li><a href="./deli_dashboard">Home</a></li>
                        <li><a href="./view_undeliveredOrders">View Undelivered /Delivered Orders</a></li>
                   <?php else: ?>
                        <li><a href="./dashboard">Home</a></li>
                        <li><a href="./shoping-cart">View Cart</a></li>
                        <li><a href="./order_history">Order History</a></li>
                        
                    <?php endif; ?>
                
                </ul>
                
            </div>
            <?php if ($category === 'customer'): ?>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="./shoping-cart"><i class="fa fa-shopping-bag"></i> <span id="cart-count">0</span></a></li>
                        </ul>
                        <div class="header__cart__price">item: <span id="">₹0.00</span></div>
                    </div>
                </div>
            <?php endif; ?>    

        </div>
         
        <div class="humberger__menu__contact">
            <ul>
                <li><i class="fa fa-envelope"></i> info@freshfare.in</li>
                <li>Free Shipping for all Order</li>
            </ul>
        </div>
    </div>
    <!-- Humberger Menu End -->

    <!-- Header Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <li><i class="fa fa-envelope"></i> info@freshfare.in</li>
                                <li>Free Shipping for all Order </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__auth">
                                <a href="./logout"><i class="fa fa-user"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo d-flex align-items-center">
                        <a href="./index.php" class="logo-brand d-flex align-items-center text-decoration-none">
                            <img src="img/logo.png" alt="Logo" class="logo-img">
                            <span class="logo-text"><span class="logo-green">F</span><span class="logo-black">resh </span><span class="logo-green">F</span><span class="logo-black">are</span></span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <?php if ($category === 'sup_admin'): ?>
                                <li><a href="./adm_dashboard">Dashboard</a></li>
                                <li><a href="./view_companies">View Registered Companies</a></li>
                                <li><a href="./enroll_company">Enroll New Company</a></li>
                                <li><a href="./order_list">View Orders List</a></li>
                            <?php elseif ($category === 'company'): ?>
                                <li><a href="./com_dashboard">Dashboard</a></li>
                                <li><a href="./view_company_order_list">View Order List</a></li>
                                <li><a href="./view_company_dispatched_list">View Dispatched Order List</a></li>
                                <li><a href="./com_fixPrice">Fix Price for Products</a></li>
                            <?php elseif ($category === 'delivery_agent'):  ?>
                                <li><a href="./deli_dashboard">Home</a></li>
                                <li><a href="./view_undeliveredOrders">View Undelivered /Delivered Orders</a></li>
                            <?php else: ?>
                                <li><a href="./dashboard">Home</a></li>
                                <li><a href="./shoping-cart">View Cart</a></li>
                                <li><a href="./order_history">Order History</a></li>
                                
                            <?php endif; ?>
                            
                        </ul>
                    </nav>
                     
                </div>
                <?php if ($category === 'customer'): ?>
                    <div class="col-lg-3">
                        <div class="header__cart">
                            <ul>
                                <li><a href="./shoping-cart"><i class="fa fa-shopping-bag"></i> <span id="cart-count">0</span></a></li>
                            </ul>
                            <div class="header__cart__price">item: <span id="">₹0.00</span></div>
                        </div>
                    </div>
                <?php endif; ?>    
            </div>
           
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
         
    </header>
     <div class="overlay" id="alertBox">
        <div class="popup">
            <div class="popup-header">
            <div id="iconBox" ></div>
            <h3>Notification</h3>
            </div>
            <p id="alertMessage">Your item has been added successfully!</p>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>
<!-- Header End -->

<?php 
        }
    }
} else {
    header("Location:./index"); 
}
?>
