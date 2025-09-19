<?php

include('./header_1.php');

// If not logged in → save redirect + send to login
if (!isset($_SESSION['user'])) {
    $_SESSION['postLoginRedirect'] = './shopping-cart';
    header("Location: ./login");
    exit;
}
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
                                <th>Quantity Increase By</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cartTableBody">
                            <!-- Cart items will be injected here via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="./dashboard#targetSection" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                </div>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Total (Incl GST) <span class="cart-total"> Rs 0.00</span></li>
                    </ul>
                    <p>Note: Total Cart Value will be displayed in the checkout page.</p>
                    <p>Note: GST (Goods and Services Tax) of 5% is included in the total price.</p>
                    <?php if (!isset($_SESSION['user'])): ?>
                        <?php $_SESSION['postLoginRedirect'] = './checkout'; ?>
                        <a href="./login" class="primary-btn">PROCEED TO CHECKOUT</a>
                    <?php else: ?>
                        <a href="./checkout" class="primary-btn">PROCEED TO CHECKOUT</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shoping Cart Section End -->

<?php include("./footer.php"); ?>
