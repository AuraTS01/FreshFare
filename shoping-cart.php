
<?php
include('./header.php');

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
                            <li><a href="./dashboard#targetSection">Chicken</a></li>
                            <li><a href="./dashboard#targetSection">Mutton</a></li>
                            <li><a href="./dashboard#targetSection">Fish</a></li>
                            <li><a href="./dashboard#targetSection">Prawns</a></li>
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
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table class="shoping__cart__table">
                            <thead>
                                <tr>
                                    <th class="shoping__product">Products</th>
                                    <th>Price</th>
                                    <th>Quantity Increase By</th> <!-- new column for dropdown -->
                                    <th>Quantity</th>
                                    
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            
                            <tbody id="cartTableBody">
                            <!-- Cart items will be injected here via JS -->
                            </tbody>
                        </table>
                        <!-- <div class="col-lg-12">
                            <strong>Total: ₹<span id="cartTotal">0.00</span></strong>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="./dashboard#targetSection" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <!-- <a href="#" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Upadate Cart</a> -->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <!-- <h5>Discount Codes</h5>
                            <form action="#">
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <!-- <li>Subtotal <span>$454.98</span></li> -->
                            <li>Total 
                                <span id="cartTotal"> Rs 0.00

                                </span>
                            </li>
                        </ul>
                        <a href="./checkout" class="primary-btn">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->

<?php 
    include("./footer.php");
  }}
}else
  { 
  header("Location:./index"); 
  }
?>
