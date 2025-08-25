
<?php
    include('./database.php');
?>

<!DOCTYPE html>
<html lang="zxx">

    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Ogani Template">
        <meta name="keywords" content="Ogani, unica, creative, html">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Fresh Fare</title>

        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

        <!-- Css Styles -->
        <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
        <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
        <link rel="stylesheet" href="css/nice-select.css" type="text/css">
        <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
        <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
        <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

        <script>
            localStorage.clear();
            sessionStorage.clear();
        </script>
    </head>

    <body>
        <!-- Page Preloder -->
        <div id="preloder">
            <div class="loader"></div>
        </div>

        <!-- Humberger Begin -->
        <div class="humberger__menu__overlay"></div>
        <div class="humberger__menu__wrapper">
            <div class="header__logo d-flex align-items-center">
                <a href="./index.php" class="logo-brand d-flex align-items-center text-decoration-none">
                    <img src="img/logo.png" alt="Logo" class="logo-img">
                    <span class="logo-text">
                    <span class="logo-green">F</span><span class="logo-black">resh </span>
                    <span class="logo-green">F</span><span class="logo-black">are</span>
                    </span>
                </a>
            </div>
            <div class="humberger__menu__cart">
                <!-- <ul>
                    <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li>
                    <li><a href="#"><i class="fa fa-shopping-bag"></i> <span>3</span></a></li>
                </ul>
                <div class="header__cart__price">item: <span>$150.00</span></div> -->
            </div>
            <div class="humberger__menu__widget">
                <!-- <div class="header__top__right__language">
                    <img src="img/language.png" alt="">
                    <div>English</div>
                    <span class="arrow_carrot-down"></span>
                    <ul>
                        <li><a href="#">Spanis</a></li>
                        <li><a href="#">English</a></li>
                    </ul>
                </div> -->
                <div class="header__top__right__auth">
                    <!-- <a href="./login"><i class="fa fa-user"></i> Login</a> -->
                </div>
            </div>
            <!-- <nav class="humberger__menu__nav mobile-menu">
                <ul>
                    <li ><a href="./index">Home</a></li>
                    <li><a href="./shoping-cart">View Cart</a></li>
                    <li><a href="./shop-grid.html">Shop</a></li>
                    <li><a href="#">Pages</a>
                        <ul class="header__menu__dropdown">
                            <li><a href="./shop-details.html">Shop Details</a></li>
                            <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                            <li><a href="./checkout.html">Check Out</a></li> 
                            <li><a href="./blog-details.html">Blog Details</a></li>
                        </ul>
                    </li>
                    <li><a href="./blog.html">Blog</a></li>
                    <li><a href="./contact.html">Contact</a></li>
                </ul>
            </nav> -->
            <div id="mobile-menu-wrap"></div>
            <!-- <div class="header__top__right__social">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-pinterest-p"></i></a>
            </div> -->
            <div class="humberger__menu__contact">
                <ul>
                    <li><i class="fa fa-envelope"></i> info@FreshFare.aurats.com</li>
                    <li>Free Shipping for all Order</li>
                </ul>
            </div>
        </div>
        <!-- Humberger End -->

        <!-- Header Section Begin -->
        <header class="header">
            <div class="header__top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="header__top__left">
                                <ul>
                                    <li><i class="fa fa-envelope"></i>  info@freshfare.aurats.com</li>
                                    <li>Free Shipping for all Order </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="header__top__right">
                                <!-- <div class="header__top__right__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-linkedin"></i></a>
                                    <a href="#"><i class="fa fa-pinterest-p"></i></a>
                                </div>
                                <div class="header__top__right__language">
                                    <img src="img/language.png" alt="">
                                    <div>English</div>
                                    <span class="arrow_carrot-down"></span>
                                    <ul>
                                        <li><a href="#">Spanis</a></li>
                                        <li><a href="#">English</a></li>
                                    </ul>
                                </div> -->
                                <div class="header__top__right__auth">
                                    <!-- <a href="./login"><i class="fa fa-user"></i> Login</a> -->
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
                                <span class="logo-text">
                                <span class="logo-green">F</span><span class="logo-black">resh </span>
                                <span class="logo-green">F</span><span class="logo-black">are</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- <nav class="header__menu">
                            <ul>
                                <li ><a href="./index">Home</a></li>
                                <li><a href="./shoping-cart">View Cart</a></li>
                                <li><a href="./shop-grid.html">Shop</a></li>
                                <li><a href="#">Pages</a>
                                    <ul class="header__menu__dropdown">
                                        <li><a href="./shop-details.html">Shop Details</a></li>
                                        <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                                        <li><a href="./checkout.html">Check Out</a></li>
                                        <li><a href="./blog-details.html">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li><a href="./blog.html">Blog</a></li>
                                <li><a href="./contact.html">Contact</a></li>
                            </ul>
                        </nav> -->
                    </div>
                    <div class="col-lg-3">
                        <div class="header__cart">
                            <ul>
                                <!-- <li><a href="#"><i class="fa fa-heart"></i> <span>1</span></a></li> -->
                                <li>
                                    <!-- <a href="./shoping-cart">
                                        <i class="fa fa-shopping-bag"></i> 
                                        <span id="cart-count">0</span>
                                    </a> -->
                                </li>
                            </ul>
                            <!-- <div class="header__cart__price">item:
                                <span id="cartTotal">₹0.00</span>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="humberger__open">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
        </header>
        <?php 
            if(isset($_GET['msg']) || isset($_GET['err'])){
                $msg = isset($_GET['msg'])? $_GET['msg']:$_GET['err'];
                showAlert($msg);
            }
        ?>

        <div class="login-container p-4 rounded">
            <h3 class="text-center mb-4">Login</h3>
            <div id="loginAlert" class="alert alert-danger d-none"></div>

            <form Method="POST" action="./index" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="form-label">Username or Email</label>
                <input type="text" class="form-control" name="email" id="email" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required />
            </div>
            <button type="submit" name="login" id="login" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="mt-3 text-center">
                Don't have an account? <a href="./createAccount">Create New Account</a>
            </div>

        </div>
    

<?php 

include('./footer.php');

?>