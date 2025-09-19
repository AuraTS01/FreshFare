<?php
include('./header.php');
$couponCode = "FIRST100";
$maxUses = 100; // first 100 users
// Check login status
$isLoggedIn = isset($_SESSION['user']);

// If user is not logged in, redirect to login
if (!$isLoggedIn) {
    $_SESSION['postLoginRedirect'] = './checkout';
    header("Location: ./login");
    exit;
}

// Handle redirect flag (used by fetch in checkout button JS)
if (isset($_GET['redirect'])) {
    $_SESSION['postLoginRedirect'] = $_GET['redirect'];
    exit; // stop output, prevents rendering page
}

// Fetch latest billing details from DB
$email = $_SESSION['email'];
$sql = "SELECT * FROM fresh_fare_signup WHERE email='$email'";
$result = mysqli_query($login_db, $sql);
$user = mysqli_fetch_assoc($result);

?>

<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>All Items</span>
                    </div>
                    <ul>
                        <li><a href="#targetSection">Chicken</a></li>
                        <li><a href="#targetSection">Fish</a></li>
                        <li><a href="#targetSection">Prawns</a></li>
                        <li><a href="#targetSection">Mutton</a></li>
                        <li><a href="#targetSection">Mutton - Boti</a></li>
                        <li><a href="#targetSection">Mutton - Liver</a></li>
                        <li><a href="#targetSection">Beef</a></li>
                        <li><a href="#targetSection">Beef - Liver</a></li>
                        <li><a href="#targetSection">Beef - Boti</a></li>
                        <li><a href="#targetSection">Quail</a></li>
                        <li><a href="#targetSection">Duck</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form action="#">
                            <input type="text" id="searchInput" placeholder="What do you need?">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>+91 8754364997</h5>
                            <span>support 24/7 time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Checkout</h2>
                    <div class="breadcrumb__option">
                        <a href="./index">Home</a>
                        <span>Checkout</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <?php 
        if(isset($_GET['msg']) || isset($_GET['err'])){
            $msg = isset($_GET['msg']) ? $_GET['msg'] : $_GET['err'];
            // echo '<div class="alert alert-info">'.$msg.'</div>';
        }
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h6>
                    <span class="icon_tag_alt"></span> Have a coupon? 
                    <a href="#" id="showCouponBox">Click here</a> to enter your code
                </h6>

                
            </div>
        </div>

        <p>Note: If your saved billing address is not visible, kindly logout and login back. You will be provided with your saved addresses.</p>

        <div class="checkout__form">
            <h4>Billing Details</h4>
            <form action="./checkout" method="POST">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <div class="checkout__input">
                            <p>Full Name<span>*</span></p>
                            <input type="text" name="fullname" id="fullname" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                        </div>
                        <div class="checkout__input">
                            <p>Country<span>*</span></p>
                            <input type="text" name="country" id="country" value="India" required readonly>
                        </div>
                        <div class="checkout__input">
                            <p>Address<span>*</span></p>
                            <input type="text" name="Address_1" id="Address_1" placeholder="Street Address" class="checkout__input__add" value="<?php echo htmlspecialchars($user['Address_1']); ?>" required>
                            <input type="text" name="Address_2" id="Address_2" placeholder="Apartment, suite, unit etc (optional)" value="<?php echo htmlspecialchars($user['Address_2']); ?>">
                        </div>
                        <div class="checkout__input">
                            <p>Town/City<span>*</span></p>
                            <input type="text" name="town" id="town" value="<?php echo htmlspecialchars($user['town']); ?>" required>
                        </div>
                        <div class="checkout__input">
                            <p>State<span>*</span></p>
                            <input type="text" name="state" id="state" value="<?php echo htmlspecialchars($user['state']); ?>" required>
                        </div>
                        <div class="checkout__input">
                            <p>Postcode / ZIP<span>*</span></p>
                            <input type="text" name="zipCode" id="zipCode" value="<?php echo htmlspecialchars($user['zipCode']); ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Phone<span>*</span></p>
                                    <input type="number" name="contactNumber" id="contactNumber" value="<?php echo htmlspecialchars($user['mob_num']); ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <button type="submit" name="billingAddressSave" class="primary-btn">Save Billing Details</button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4>Your Order</h4>
                            <div class="checkout__order__products">Products <span>Total</span></div>
                            <ul id="orderItems"></ul>
                            <div class="checkout__order__subtotal">Subtotal <span class="cart-subtotal">₹0.00</span></div>
                            <div class="checkout__order__gst">GST (0%) <span class="cart-gst">₹0.00</span></div>

                            <!-- Coupon Code Section -->
                            <div class="checkout__order__coupon" style="margin-top:15px;">
                               
                                <div id="couponBox" style="display:none; margin-top:10px;">
                                    <input type="text" id="couponInput" placeholder="Enter coupon code" class="form-control" style="width:200px; display:inline-block;">
                                    <button id="applyCoupon" class="btn btn-outline-success" type="button">Apply</button>
                                    <div id="couponMessage" style="margin-top:5px;color:green;"></div>
                                </div>
                            </div>

                            <div class="checkout__order__total">Total <span class="cart-total">₹0.00</span></div>
                            <a href="./payment" class="primary-btn">PROCEED TO PAYMENT</a>
                        </div>
                    </div>
                    <div id="zipAlert" class="mb-3"></div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->

<?php include("./footer.php"); ?>
