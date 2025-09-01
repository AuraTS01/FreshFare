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
     <div id="locationAlert" class="alert alert-warning text-center" role="alert">
    🚚 Delivery is available only in <strong>Mettupalayam</strong> and <strong>Karamadai</strong>.
    </div>
    <div class="modal fade" id="pincodeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h5 class="modal-title" id="pincodeModalLabel">Enter Your Pincode</h5>
                </div>
                <div class="modal-body">
                    <p>Location access was denied. Please enter your area pincode to check delivery availability.</p>
                    <input type="text" id="pincodeInput" class="form-control text-center" placeholder="e.g., 641301" maxlength="6">
                    <div id="pincodeError" class="text-danger mt-2" style="display: none;">Invalid Pincode. Delivery is available only in Mettupalayam and Karamadai.</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="verifyPincode()">Check</button>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">        
        
        <div class="col-lg-12">
             <div class="section-title">
                <p>Please allow location access to check delivery availability in your area.</p>
                <button class="btn btn-primary" onclick="resetLocationCheck()">Change Location</button>
            </div>
            
        </div>
    </div>
    <?php 
        if(isset($_GET['msg']) || isset($_GET['err'])){
          $msg = isset($_GET['msg'])? $_GET['msg']:$_GET['err'];
          showAlert($msg);
        }
        
    ?>
    
    <section class="hero">
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
                    <div class="hero__item set-bg" data-setbg="img/hero/chicken_2.jpg">
                        <div class="hero__text">
                            <span>FRESH Meat</span>
                            <h2>Chicken <br />100% Fresh</h2>
                            <h5>Free Pickup and Delivery Available</h5></br>
                            <a href="#targetSection" class="primary-btn">SHOP NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End --> 
    
    

    <!-- Categories Section Begin -->
    <!-- <section class="categories">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>
                    <div class="categories__slider owl-carousel">
                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="img/hero/chicken_1.jpg">
                                <h5><a href="#">Fresh Chicken</a></h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="img/categories/fresh_raw_mutton_leg.jpg">
                                <h5><a href="#">Mutton</a></h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="img/categories/Shrimp.jpg">
                                <h5><a href="#">Prawns</a></h5>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="img/categories/fish.jpg">
                                <h5><a href="#">Fish</a></h5>
                            </div>
                        </div>
                        <!-- <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="img/categories/cat-5.jpg">
                                <h5><a href="#">drink fruits</a></h5>
                            </div>
                        </div> -->
                    <!-- </div>
                </div>
            </div>
        </div>
    </section>  -->
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->

             
       <?php
        // -----------------------------------------------
        // Helpers
        // -----------------------------------------------


        // Function to adjust price based on base price
        function getAdjustedPrice(float $basePrice): float {
            if ($basePrice <= 100) {
                return $basePrice + 10;
            } elseif ($basePrice <= 249) {
                return $basePrice + 25;
            } elseif ($basePrice <= 350) {
                return $basePrice + 30;
            } else { // > 350
                return $basePrice + 40;
            }
        }
        // Split items by commas but ignore commas inside parentheses.
        function splitTopLevelItems(string $s): array {
            $items = [];
            $buf = '';
            $depth = 0;
            $len = strlen($s);
            for ($i = 0; $i < $len; $i++) {
                $ch = $s[$i];
                if ($ch === '(') { $depth++; $buf .= $ch; }
                elseif ($ch === ')') { if ($depth>0) $depth--; $buf .= $ch; }
                elseif ($ch === ',' && $depth===0) { $items[] = trim($buf); $buf=''; }
                else { $buf .= $ch; }
            }
            if(trim($buf) !== '') $items[] = trim($buf);
            return $items;
        }

        // Expand "Base(Var1, Var2)" => ["Base Var1", "Base Var2"].
        // If no parentheses, return the item as-is.
        function expandItem(string $item): array {
            if (preg_match('/^([^(]+)\(([^)]*)\)$/', $item, $m)) {
                $base = trim($m[1]);
                $parts = array_map('trim', explode(',', $m[2]));
                $out = [];
                foreach ($parts as $p) {
                    $out[] = $base . ' ' . $p;
                }
                return $out;
            }
            return [trim($item)];
        }

        // Map a normalized product name to a price column from $row.
        function mapPrice(string $name, array $row): float {
            $n = strtolower($name);
            if (strpos($n, 'chicken with skin') !== false) return (float)$row['chicken_with_skin_price'];
            if (strpos($n, 'chicken without skin') !== false) return (float)$row['chicken_without_skin_price'];
            if (strpos($n, 'mutton') !== false && strpos($n, 'boti') !== false) return (float)$row['mutton_boti_price'];
            if (strpos($n, 'mutton') !== false && strpos($n, 'liver') !== false) return (float)$row['mutton_liver_price'];
            if (strpos($n, 'mutton') !== false) return (float)$row['mutton_price'];
            if (strpos($n, 'fish') !== false) return (float)$row['fish_price'];
            if (strpos($n, 'prawn') !== false) return (float)$row['prawn_price'];
            if (strpos($n, 'kadai') !== false) return (float)$row['kadai_price'];
            if (strpos($n, 'beef') !== false && strpos($n, 'boti') !== false) return (float)$row['beef_boti_price'];
            if (strpos($n, 'beef') !== false && strpos($n, 'liver') !== false) return (float)$row['beef_liver_price'];
            if (strpos($n, 'beef') !== false) return (float)$row['beef_price'];
            if (strpos($n, 'duck') !== false) return (float)$row['duck_price'];
            return 0.0;
        }


        // -----------------------------------------------
        // Query (also select cr.logo which you use below)
        // -----------------------------------------------
        $sql = "SELECT cr.company_id, cr.company_name, cr.email, cr.selling_items,
                    ip.chicken_with_skin_price, ip.chicken_without_skin_price, 
                    ip.prawn_price, ip.mutton_price, ip.fish_price, ip.kadai_price, ip.beef_price, ip.beef_boti_price, ip.beef_liver_price,
                    ip.mutton_boti_price, ip.mutton_liver_price,ip.duck_price
                FROM company_registration cr
                JOIN item_price ip ON cr.company_id = ip.company_id";
        $result = mysqli_query($login_db, $sql);
        ?>

        <section id="targetSection" class="featured spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h2>Choose Your Butcher Shops</h2>
                        </div>
                    </div>
                </div>
                <div class="row featured__filter">
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <?php
                                $companyId   = $row['company_id'];
                                $companyName = htmlspecialchars($row['company_name']);
                                $address     = htmlspecialchars($row['email']);

                                // Check if logo exists
                                if (!empty($row['logo']) && file_exists("./uploads/company_logos/" . $row['logo'])) {
                                    $logo_html = '<img src="./uploads/company_logos/' . htmlspecialchars($row['logo']) . '" alt="' . $companyName . '" class="company-logo">';
                                } else {
                                    // If no logo, show initials
                                    $words = explode(' ', $companyName);
                                    $initials = '';
                                    
                                    if(count($words) >= 2){
                                        $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
                                    } else {
                                        // If single word, take first two letters
                                        $initials = strtoupper(substr($words[0], 0, 2));
                                    }
                                    
                                    $logo_html = '<div class="company-placeholder">' . $initials . '</div>';
                                }


                                // 1) Split top-level items safely
                                $topLevelItems = splitTopLevelItems($row['selling_items']);

                                // 2) Expand variants and build products with prices
                                $products = [];
                                foreach ($topLevelItems as $it) {
                                    foreach (expandItem($it) as $fullName) {
                                        $name  = trim(preg_replace('/\s+/', ' ', str_replace([ '(', ')', ',' ], '', $fullName)));
                                        // Safety: if someone typed only "With Skin" or "Without Skin", prepend "Chicken"
                                        if (preg_match('/^(with skin|without skin)$/i', $name)) {
                                            $name = 'Chicken ' . $name;
                                        }
                                        $price = mapPrice($name, $row);
                                        $products[] = [ 'name' => $name, 'price' => $price ];
                                    }
                                }

                                // 3) Deduplicate by name (case-insensitive)
                                $unique = [];
                                foreach ($products as $p) {
                                    $key = strtolower($p['name']);
                                    if (!isset($unique[$key])) $unique[$key] = $p;
                                }
                                $uniqueItems = array_values($unique);
                            ?>

                            <!-- Company Card -->
                            <div class="col-lg-3 col-md-4 col-sm-6 mix companies">
                                <div class="featured__item">
                                    <div class="featured__item__pic set-bg" >
                                        <div class="company-item">
                                            <?php echo $logo_html; ?>
                                            <div class="company-info">
                                                <h5><?php echo $companyName; ?></h5>
                                                <p><?php echo $address; ?></p>
                                            </div>
                                        </div>
                                        <ul class="featured__item__pic__hover">
                                            <li>
                                                <button class="btn btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#companyModal<?php echo $companyId; ?>">
                                                    View Products
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="featured__item__text">
                                        <h6>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#companyModal<?php echo $companyId; ?>">
                                                <?php echo $companyName; ?>
                                            </a>
                                        </h6>
                                        <p><?php echo $address; ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Company Modal -->
                            <div class="modal fade" id="companyModal<?php echo $companyId; ?>" tabindex="-1">
                                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><?php echo $companyName; ?> - Products - Choose Your Favorite Meat</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Note: You can Change / Modify the Quantity in Cart / View Cart Page</p>
                                            <div class="row g-3">
                                                
                                                <?php 
                                                foreach ($uniqueItems as $product) {
                                                    $productName = htmlspecialchars($product['name']);
                                                    $basePrice   = (float)$product['price'];

                                                    // Check if price is set
                                                    if ($basePrice <= 0) {
                                                        $priceText = '<span class="text-muted">Price not set</span>';
                                                        $disableBtn = 'disabled';
                                                    } else {
                                                        $price = getAdjustedPrice($basePrice);
                                                        $priceText = '₹' . number_format($price, 2) . ' / KG';
                                                        $disableBtn = '';
                                                    }

                                                    // Image mapping
                                                    $image = "img/featured/default.jpg";
                                                    $ln = strtolower($productName);
                                                    if (strpos($ln, "chicken with skin") !== false) $image = "img/featured/chicken_flesh.jpg";
                                                    elseif (strpos($ln, "chicken without skin") !== false) $image = "img/featured/chicken_withoutSkin.jpg";
                                                    elseif (strpos($ln, "mutton boti") !== false) $image = "img/featured/mutton.jpg";
                                                    elseif (strpos($ln, "mutton liver") !== false) $image = "img/featured/mutton.jpg";
                                                    elseif (strpos($ln, "fish") !== false) $image = "img/featured/fish.jpeg";
                                                    elseif (strpos($ln, "prawn") !== false) $image = "img/featured/prawns.jpg";
                                                    elseif (strpos($ln, "kadai") !== false) $image = "img/featured/kadai.jpeg";
                                                    elseif (strpos($ln, "beef boti") !== false) $image = "img/featured/beef_boti.jpg";
                                                    elseif (strpos($ln, "beef liver") !== false) $image = "img/featured/beef_liver.jpg";

                                                    echo '<div class="col-12 col-sm-6 col-lg-4">
                                                            <div class="featured__item h-100">
                                                                <div class="featured__item__pic set-bg" style="background-image:url(' . $image . '); background-size: cover; background-position: center;">
                                                                    <ul class="featured__item__pic__hover">
                                                                        <li>
                                                                            <button class="btn btn-success btn-sm" ' . $disableBtn . '
                                                                                onclick="addToCart(this, \'' . $productName . '\', ' . ($basePrice > 0 ? $price : 0) . ', ' . $row['company_id'] . ')">
                                                                                <i class="fa fa-shopping-cart"></i> Add to Cart
                                                                            </button>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="featured__item__text text-center">
                                                                    <h6 class="mt-2"><a href="#">' . $productName . '</a></h6>
                                                                    <h5>' . $priceText . '</h5>
                                                                </div>
                                                            </div>
                                                        </div>';
                                                }
?>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center w-100">No companies found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
















    

    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <!-- <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <!-- <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Latest Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Top Rated Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Review Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <!-- <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-1.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Cooking tips make cooking simple</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-2.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-3.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Visit the clean farm in the US</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- Blog Section End -->
<?php 
    include("./footer.php");
  }}
}else
  { 
  header("Location:./index"); 
  }
?>