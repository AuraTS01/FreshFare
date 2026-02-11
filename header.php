<?php 
include('./database.php'); 



// Initialize variables
$isLoggedIn = false;
$category = null;

// Check if user is logged in
if (isset($_SESSION['user'])) {
    $isLoggedIn = true;

    // Session timeout: 10 minutes (600 seconds)
    if ((time() - $_SESSION['last_login_timestamp']) > 600) {
        // Expired → destroy session and redirect to login
        session_unset();
        session_destroy();
        header("Location: ./login?err=Session expired. Please login again.");
        exit;
    }

    // Refresh last login timestamp
    $_SESSION['last_login_timestamp'] = time();

    // Fetch user category
    $sql = "SELECT * FROM `fresh_fare_signup` WHERE `email`='" . mysqli_real_escape_string($login_db, $_SESSION['email']) . "' LIMIT 1";
    $result = mysqli_query($login_db, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $category = $row['category'];
    }
}
?>

<!DOCTYPE html>
<html lang="English">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Fresh Fare - Order fresh chicken, mutton, beef, fish, prawns and more online in Karamadai & Mettupalayam. Free pickup & delivery available. Exclusive offer: SAVE25 for first 100 members!">
    <meta name="keywords" content="Fresh Meat, Online Meat Delivery, Chicken, Mutton, Beef, Fish, Prawns, Fresh Fare, Karamadai, Mettupalayam, 641104, 641301, Butcher Shop, Organic Meat, Offer SAVE25">
    <meta name="author" content="Fresh Fare">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Open Graph for Social Media -->
    <meta property="og:title" content="Fresh Fare - Fresh Meat Delivery in Karamadai & Mettupalayam">
    <meta property="og:description" content="Shop fresh meat online. Use code SAVE25 - first 100 members only! Free pickup & delivery available in 641104 & 641301.">
    <meta property="og:image" content="https://freshfare.in/img/hero/offer.png">
    <meta property="og:url" content="https://freshfare.in">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Fresh Fare - Fresh Meat Delivery in Karamadai & Mettupalayam">
    <meta name="twitter:description" content="Exclusive Offer: SAVE25 for first 100 members! Order fresh meat now.">
    <meta name="twitter:image" content="https://freshfare.in/img/hero/offer.png">

    <title>Fresh Fare - Fresh Meat Delivery in Karamadai & Mettupalayam</title>
    <link href="img/logo.png" rel="icon">

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
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Structured Data for Local Business -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Butcher",
      "name": "Fresh Fare",
      "image": "https://freshfare.in/img/logo.png",
      "url": "https://freshfare.in",
      "priceRange": "₹₹",
      "address": [
        {
          "@type": "PostalAddress",
          "addressLocality": "Karamadai",
          "postalCode": "641104",
          "addressCountry": "IN"
        },
        {
          "@type": "PostalAddress",
          "addressLocality": "Mettupalayam",
          "postalCode": "641301",
          "addressCountry": "IN"
        }
      ],
      "geo": [
        {
          "@type": "GeoCoordinates",
          "latitude": 11.24058,
          "longitude": 76.96009
        },
        {
          "@type": "GeoCoordinates",
          "latitude": 11.29971,
          "longitude": 76.93485
        }
      ],
      "offers": {
        "@type": "Offer",
        "url": "https://freshfare.in/img/hero/offer.png",
        "priceCurrency": "INR",
        "price": "0",
        "eligibleCustomerType": "https://schema.org/FirstTimeCustomer",
        "description": "SAVE25 - Grab the offer soon! Valid only for first 100 members."
      }
    }
    </script>

    
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
                        <li><a href="./privacypolicy">Privacy Policy</a></li>
                    <?php elseif ($category === 'company'): ?>
                        <li><a href="./com_dashboard">Dashboard</a></li>
                        <li><a href="./view_company_order_list">View Order List</a></li>
                        <li><a href="./view_company_dispatched_list">View Dispatched Order List</a></li>
                        <li><a href="./com_fixPrice">Fix Price for Products</a></li>
                        <li><a href="./privacypolicy">Privacy Policy</a></li>
                    <?php elseif ($category === 'delivery_agent'):  ?>
                        <li><a href="./deli_dashboard">Home</a></li>
                        <li><a href="./view_undeliveredOrders">View Undelivered /Delivered Orders</a></li>
                        <li><a href="./privacypolicy">Privacy Policy</a></li>
                   <?php else: ?>
                        <li><a href="./dashboard">Home</a></li>
                        <li><a href="./shoping-cart">View Cart</a></li>
                        <li><a href="./order_history">Order History</a></li>
                        <li><a href="./privacypolicy">Privacy Policy</a></li>
                        
                    <?php endif; ?>
                
                </ul>
                
            </div>
            <?php if ($category === 'customer'): ?>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="./shoping-cart"><i class="fa fa-shopping-bag"></i> <span class="cart-count">0</span></a></li>
                        </ul>
                        <div class="header__cart__price">Cart Price: <span class="cart-total">₹0.00</span></div>
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
                                <li><a href="./privacypolicy">Privacy Policy</a></li>
                            <?php elseif ($category === 'company'): ?>
                                <li><a href="./com_dashboard">Dashboard</a></li>
                                <li><a href="./view_company_order_list">View Order List</a></li>
                                <li><a href="./view_company_dispatched_list">View Dispatched Order List</a></li>
                                <li><a href="./com_fixPrice">Fix Price for Products</a></li>
                                <li><a href="./privacypolicy">Privacy Policy</a></li>
                            <?php elseif ($category === 'delivery_agent'):  ?>
                                <li><a href="./deli_dashboard">Home</a></li>
                                <li><a href="./view_undeliveredOrders">View Undelivered /Delivered Orders</a></li>
                                <li><a href="./privacypolicy">Privacy Policy</a></li>
                            <?php else: ?>
                                <li><a href="./dashboard">Home</a></li>
                                <li><a href="./shoping-cart">View Cart</a></li>
                                <li><a href="./order_history">Order History</a></li>
                                <li><a href="./privacypolicy">Privacy Policy</a></li>
                                
                            <?php endif; ?>
                            
                        </ul>
                    </nav>
                     
                </div>
                <?php if ($category === 'customer'): ?>
                    <div class="col-lg-3">
                        <div class="header__cart">
                            <ul>
                                <li><a href="./shoping-cart"><i class="fa fa-shopping-bag"></i> <span class="cart-count">0</span></a></li>
                            </ul>
                            <div class="header__cart__price">Cart Price: <span class="cart-total">₹0.00</span></div>
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
       
?>
