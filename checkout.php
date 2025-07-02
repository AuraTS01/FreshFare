<?php
include('./header.php');
// header('Content-Type: application/json');
if (isset($_SESSION['user'])) 
{

  // echo "pass";
  if((time() - $_SESSION['last_login_timestamp']) > 600) // 900 = 15 * 60  
  {  
    header("Location:logout.php");  
  }  
  else  
  {  
    $_SESSION['last_login_timestamp'] = time();  
    $sql = "SELECT * FROM `fresh_fare_signup` WHERE `email`='" . $_SESSION["email"] . "'";
    $result = mysqli_query($login_db,$sql);
    $no = mysqli_fetch_array($result);
    if($no!=0) 
    {

        
       

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
                            <li><a href="#">Chicken</a></li>
                            <li><a href="#">Mutton</a></li>
                            <li><a href="#">Fish</a></li>
                            <li><a href="#">Prawns</a></li>
                            <!-- <li><a href="#">Ocean Foods</a></li>
                            <li><a href="#">Butter & Eggs</a></li>
                            <li><a href="#">Fastfood</a></li>
                            <li><a href="#">Fresh Onion</a></li>
                            <li><a href="#">Papayaya & Crisps</a></li>
                            <li><a href="#">Oatmeal</a></li>
                            <li><a href="#">Fresh Bananas</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="#">
                                <!-- <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div> -->
                                <input type="text" id="searchInput" placeholder="What do yo u need?">
                                <!-- <ul id="productList"></ul> -->
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
                            <a href="./index.html">Home</a>
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
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                    </h6>
                </div>
            </div>

            
                <div class="checkout__form">
                    <h4>Billing Details</h4>
                    <form action="./checkout" method="POST" >
                        <div class="row">
                            <div class="col-lg-8 col-md-6">
                                
                                    
                                <div class="checkout__input">
                                    <p>Full Name<span>*</span></p>
                                    <input type="text" name="fullname" id="fullname" value="<?php echo $_SESSION['username']; ?>" required>
                                </div>
                                
                                    
                                <div class="checkout__input">
                                    <p>Country<span>*</span></p>
                                    <input type="text" name="country" id="country" value="India" required>
                                </div>
                                <div class="checkout__input">
                                    <p>Address<span>*</span></p>
                                    <input type="text" name="Address_1" id="Address_1" placeholder="Street Address" class="checkout__input__add" value="<?php echo $_SESSION['Address_1']; ?>" required>
                                    <input type="text" name="Address_2" id="Address_2" placeholder="Apartment, suite, unite ect (optinal)" value="<?php echo $_SESSION['Address_2']; ?>">
                                </div>
                                <div class="checkout__input">
                                    <p>Town/City<span>*</span></p>
                                    <input type="text" name="town" id="town" value="<?php echo $_SESSION['town']; ?>" required> 
                                </div>
                                <div class="checkout__input">
                                    <p>State<span>*</span></p>
                                    <input type="text" name="state" id="state" value="<?php echo $_SESSION['state']; ?>" required>
                                </div>
                                <div class="checkout__input">
                                    <p>Postcode / ZIP<span>*</span></p>
                                    <input type="text" name="zipCode" id="zipCode" value="<?php echo $_SESSION['zipCode']; ?>" required>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="checkout__input">
                                            <p>Phone<span>*</span></p>
                                            <input type="number" name="contactNumber" id="contactNumber" value="<?php echo $_SESSION['mob_num']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="checkout__input">
                                            <p>Email<span>*</span></p>
                                            <input type="text" name="email" id="email" value="<?php echo $_SESSION['email']; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="checkout__input__checkbox">
                                    <label for="acc">
                                        Create an account?
                                        <input type="checkbox" id="acc">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <p>Create an account by entering the information below. If you are a returning customer
                                    please login at the top of the page</p>
                                <div class="checkout__input">
                                    <p>Account Password<span>*</span></p>
                                    <input type="text">
                                </div> -->
                                <!-- <div class="checkout__input__checkbox">
                                    <label for="diff-acc">
                                        Ship to a different address?
                                        <input type="checkbox" id="diff-acc">
                                        <span class="checkmark"></span>
                                    </label>
                                </div> -->
                                <div class="checkout__input">
                                    <p>Order notes<span>*</span></p>
                                    <input type="text"
                                        placeholder="Notes about your order, e.g. special notes for delivery.">
                                        
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
                                    <div class="checkout__order__subtotal">Subtotal <span id="subtotalAmount">₹0.00</span></div>
                                    <div class="checkout__order__total">Total <span id="totalAmount">₹0.00</span></div>

                                    <!-- <div class="checkout__input__checkbox">
                                        <label for="acc-or">
                                            Create an account?
                                            <input type="checkbox" id="acc-or">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt
                                        ut labore et dolore magna aliqua.</p>
                                    <div class="checkout__input__checkbox">
                                        <label for="payment">
                                            Check Payment
                                            <input type="checkbox" id="payment">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="checkout__input__checkbox">
                                        <label for="paypal">
                                            Paypal
                                            <input type="checkbox" id="paypal">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div> -->
                                    <a href="./payment" class="primary-btn">PROCEED TO PAYMENT</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="existing-address" style="display: none;" class="mb-4 p-3 bg-light border rounded"></div>
                </div>
           
        </div>
    </section>
    <!-- Checkout Section End -->


      
      
<?php 
    include("./footer.php");
  }}
}else
  { 
  header("Location:./index"); 
  }
?>