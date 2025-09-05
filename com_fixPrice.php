<?php
include('./header.php');

if (isset($_SESSION['user'])) {
    if ((time() - $_SESSION['last_login_timestamp']) > 600) {  
        header("Location:logout.php");  
    } else {  
        $_SESSION['last_login_timestamp'] = time();  

        // Get logged-in user
        $sql = "SELECT * FROM `fresh_fare_signup` WHERE `email`='" . $_SESSION["email"] . "'";
        $result = mysqli_query($login_db, $sql);
        $no = mysqli_fetch_assoc($result);

        if ($no!=0) {
            // 🔹 Instead of dropdown, fetch company directly from signup row
            $companyId = $no['id'];   // or 'company_id' if you have that column

            // Fetch company details
            $companySql = "SELECT * FROM company_registration WHERE signup_id = $companyId";
            $companyResult = mysqli_query($login_db, $companySql);
            $selectedCompany = mysqli_fetch_assoc($companyResult);

            // Fetch item prices
            $comp_id = $selectedCompany ? $selectedCompany['company_id'] : 0;
            $priceSql = "SELECT * FROM item_price WHERE company_id = $comp_id";
            $priceResult = mysqli_query($login_db, $priceSql);
            $itemPrices = mysqli_fetch_assoc($priceResult) ?? [];

            // --- Helper functions ---
            function splitTopLevelItems(string $s): array {
                $items = [];
                $buf = '';
                $depth = 0;
                $len = strlen($s);
                for ($i = 0; $i < $len; $i++) {
                    $ch = $s[$i];
                    if ($ch === '(') { $depth++; $buf .= $ch; }
                    elseif ($ch === ')') { if ($depth > 0) $depth--; $buf .= $ch; }
                    elseif ($ch === ',' && $depth === 0) { $items[] = trim($buf); $buf = ''; }
                    else { $buf .= $ch; }
                }
                if (trim($buf) !== '') $items[] = trim($buf);
                return $items;
            }

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

            // Build final selling items array
            $sellingItems = [];
            if ($selectedCompany && !empty($selectedCompany['selling_items'])) {
                foreach (splitTopLevelItems($selectedCompany['selling_items']) as $raw) {
                    foreach (expandItem($raw) as $expanded) {
                        $sellingItems[] = $expanded;
                    }
                }
            }
?>
        <div class="container mt-4">
            <h4 class="text-center">Item Price Update </h4><br>

            <?php 
                if(isset($_GET['msg']) || isset($_GET['err'])){
                    $msg = isset($_GET['msg'])? $_GET['msg']:$_GET['err'];
                    showAlert($msg);
                }
                
            ?>
            
            <?php if ($selectedCompany): ?>
                <!-- Price Update Form -->
                <form method="post" action="com_fixPrice">
                    <input type="hidden" name="company_id" value="<?= $selectedCompany['company_id']; ?>">
                    <div class="row">
                        <?php foreach ($sellingItems as $item): 
                            $field = strtolower(str_replace(" ", "_", trim($item))) . "_price";
                            $value = isset($itemPrices[$field]) ? $itemPrices[$field] : 0;
                        ?>
                            <div class="col-md-4 mb-4">
                                <div class="item-card">
                                    <h5><?= htmlspecialchars($item); ?></h5>
                                    <input type="number" step="0.01" name="<?= $field; ?>" 
                                        value="<?= $value; ?>" 
                                        class="form-control" required>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Prices</button><br><br><br><br>
                </form>
            <?php endif; ?>
            
        </div>
<?php 
        }
        include("./footer.php");
    }
} else { 
  header("Location:./index"); 
} 
?>
