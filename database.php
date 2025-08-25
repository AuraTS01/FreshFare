<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();
date_default_timezone_set('Asia/Kolkata');

$_SESSION['user']= "live";

$login_db =  new mysqli("localhost","root","","FreshFare");

$default = "undefined";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Add this near top of file

function showAlert($msg){
    echo ' <div class="overlay" id="alertBox">
                <div class="popup">
                <div id="iconBox"></div>
                <h4>Notification</h4>
                <p id="alertMessage"></p>
                <button onclick="closePopup()">OK</button>
                </div>
            </div>';
}


// include('./database.php');

if (isset($_POST['signup_submit'])) {
    echo "Form submitted<br>";

    $name = mysqli_real_escape_string($login_db, $_POST['name']);
    $email = mysqli_real_escape_string($login_db, $_POST['email']);
    $mobile = mysqli_real_escape_string($login_db, $_POST['mob_num']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $category = "customer";
    $access = 1;

    if ($password !== $confirm_password) {
        echo "Passwords do not match";
        exit();
    }

    $hashedPassword = md5($password);

    $check_sql = "SELECT * FROM fresh_fare_signup WHERE email = '$email'";
    $check_result = mysqli_query($login_db, $check_sql);

    if (mysqli_num_rows($check_result) != 0) {
        
        header("Location:./createAccount?err=Email Already Exist");
        exit();
    }

    $sql = "INSERT INTO fresh_fare_signup (`username`, `email`, `mob_num`, `password`, `category`, `access`, `role`, `country` , `Address_1`, `Address_2` ,`town`,`state` ,`zipCode` )
            VALUES ('$name', '$email', '$mobile', '$hashedPassword', '$category', '$access', '$default', '$default', '$default', '$default', '$default', '$default', '1')";

    if (mysqli_query($login_db, $sql)) {
        
        header("Location:./index?msg=Account Registered Successfully, Kindly Login");
    } else {
        
        header("Location:./createAccount?err= Error: ". mysqli_error($login_db));
    }
}



if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $hashedPassword = md5($pass);

    if($email!=""){
        $check_sql = "SELECT * FROM `fresh_fare_signup` WHERE `email` = '$email'";
        $check_result=mysqli_query($login_db,$check_sql);
        if(mysqli_num_rows($check_result)==0){
            header("Location:index?err=Email does not exist with Database");
        }
        else{
            $sql = "SELECT * FROM `fresh_fare_signup` WHERE `email` = '$email' AND `password`= '$hashedPassword'";
            $result = mysqli_query($login_db,$sql);
            $row = mysqli_fetch_array($result);
            if($row!=0){
                if(($_SESSION['user']) && ($row['access']==1)){
                    if($row['category'] === 'sup_admin' ){
                        $_SESSION['username'] = $row['username'];
                         //echo $_SESSION['name'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['mob_num'] = $row['mob_num'];
                        $_SESSION['password'] = $row['password'];
                        //echo $_SESSION['email'];
                        $_SESSION['last_login_timestamp'] = time();
                        $_SESSION['Address_1'] = $row['Address_1'];
                        $_SESSION['Address_2'] = $row['Address_2'];
                        $_SESSION['town'] = $row['town'];
                        $_SESSION['state'] = $row['state'];
                        $_SESSION['zipCode'] = $row['zipCode'];
                        //echo $_SESSION['last_login_timestamp'];
                        
                        header("Location:./adm_dashboard");
                    }else if ($row['category'] === 'company' ){
                        $_SESSION['username'] = $row['username'];
                         //echo $_SESSION['name'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['mob_num'] = $row['mob_num'];
                        $_SESSION['password'] = $row['password'];
                        //echo $_SESSION['email'];
                        $_SESSION['last_login_timestamp'] = time();
                        $_SESSION['Address_1'] = $row['Address_1'];
                        $_SESSION['Address_2'] = $row['Address_2'];
                        $_SESSION['town'] = $row['town'];
                        $_SESSION['state'] = $row['state'];
                        $_SESSION['zipCode'] = $row['zipCode'];
                        //echo $_SESSION['last_login_timestamp'];
                        
                        header("Location:./adm_dashboard");

                    }else if ($row['category'] === 'customer' ){
                        $_SESSION['username'] = $row['username'];
                         //echo $_SESSION['name'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['mob_num'] = $row['mob_num'];
                        $_SESSION['password'] = $row['password'];
                        //echo $_SESSION['email'];
                        $_SESSION['last_login_timestamp'] = time();
                        $_SESSION['Address_1'] = $row['Address_1'];
                        $_SESSION['Address_2'] = $row['Address_2'];
                        $_SESSION['town'] = $row['town'];
                        $_SESSION['state'] = $row['state'];
                        $_SESSION['zipCode'] = $row['zipCode'];
                        //echo $_SESSION['last_login_timestamp'];
                        
                        header("Location:./dashboard");

                    }else if ($row['category'] === 'delivery_agent' ){
                        $_SESSION['username'] = $row['username'];
                         //echo $_SESSION['name'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['mob_num'] = $row['mob_num'];
                        $_SESSION['password'] = $row['password'];
                        //echo $_SESSION['email'];
                        $_SESSION['last_login_timestamp'] = time();
                        $_SESSION['Address_1'] = $row['Address_1'];
                        $_SESSION['Address_2'] = $row['Address_2'];
                        $_SESSION['town'] = $row['town'];
                        $_SESSION['state'] = $row['state'];
                        $_SESSION['zipCode'] = $row['zipCode'];
                        //echo $_SESSION['last_login_timestamp'];
                        
                        header("Location:./deli_dashboard");

                    }else{
                        header("Location:index?err=No Category.Please Contact Admin +91 9042281069");
                    } 
                    
                                      
                }else{
                        header("Location:index?err=Access Denied");
                } 
            }else{
                header("Location:index?err=Email or Password is incorrect");
            }
        }//end else
    }
}//ENd login billingAddressSave



if(isset($_POST['billingAddressSave'])){
    $fullname = $_POST['fullname'];
    $country = $_POST['country'];
    $Address_1 = $_POST['Address_1'];
    $Address_2 = $_POST['Address_2'];
    $town = $_POST['town'];
    $state = $_POST['state'];
    $zipCode = $_POST['zipCode'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
  

   
    if($Address_2!=""){
        $check_sql = "UPDATE fresh_fare_signup SET `country` = '$country', `Address_1` = '$Address_1', `Address_2` = '$Address_2',`town` = '$town',`state` = '$state' ,`zipCode` = '$zipCode' WHERE `email` = '$email' AND `mob_num`='$contactNumber'";
        
        if(mysqli_query($login_db,$check_sql)){
            header("Location:checkout?msg=Billing Address Updated");
        }
        
        
    }else if ($Address_2 == ""){

        $check_sql = "UPDATE fresh_fare_signup SET `country` = '$country', `Address_1` = '$Address_1', `Address_2` = '',`town` = '$town',`state` = '$state',`zipCode` = '$zipCode' WHERE `email` = '$email' AND `mob_num`='$contactNumber'";
       
        if(mysqli_query($login_db,$check_sql)){
            header("Location:checkout?msg=Billing Address Updated");
        }
    }
}

// === SAVE ORDER: from frontend JavaScript fetch request ===
// === SAVE ORDER: from frontend JavaScript fetch request ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'save_order') {
    header("Content-Type: application/json");

    // ✅ Check if user is logged in
    if (!isset($_SESSION['email'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    // ✅ Decode incoming JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $payment_mode = $data['payment_mode'] ?? 'unknown';
    $cart = $data['cart'] ?? [];

    if (empty($cart)) {
        echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
        exit;
    }

    // ✅ Calculate total price
    $total = 0;
    foreach ($cart as $item) {
        $price = isset($item['price']) ? (float)$item['price'] : 0;
        $quantity = isset($item['quantity']) ? (float)$item['quantity'] : 0;
        $total += $price * $quantity;
    }

    // ✅ Get customer ID
    $email = $_SESSION['email'];
    $stmt = $login_db->prepare("SELECT id FROM fresh_fare_signup WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Customer not found']);
        exit;
    }

    $customer_id = $res->fetch_assoc()['id'];
    $stmt->close();

    // ✅ Insert order
    $order_code = "ORD" . rand(100000, 999999);
    $order_date = date("Y-m-d H:i:s");

    $stmt = $login_db->prepare("
        INSERT INTO orders (customer_id, order_code, order_date, payment_mode, total_price)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssd", $customer_id, $order_code, $order_date, $payment_mode, $total);

    try {
        $stmt->execute();
        $order_db_id = $stmt->insert_id; // actual PK ID
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Order insert failed: ' . $e->getMessage()]);
        exit;
    }

    // ✅ Insert each cart item into order_items with company_id
    foreach ($cart as $item) {
        $item_name  = $item['name'] ?? 'Unknown';
        $quantity   = isset($item['quantity']) ? (float)$item['quantity'] : 0;
        $price      = isset($item['price']) ? (float)$item['price'] : 0;
        $company_id = isset($item['company_id']) ? (int)$item['company_id'] : 0;
        $unit       = 'Kg'; // default unit

        if ($company_id === 0) {
            echo json_encode(['status' => 'error', 'message' => 'Missing company_id for item', 'item' => $item]);
            exit;
        }

        $stmt = $login_db->prepare("
            INSERT INTO order_items (order_id, item_name, quantity, unit, price, company_id)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("isdsdi", $order_db_id, $item_name, $quantity, $unit, $price, $company_id);

        try {
            $stmt->execute();
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Item insert failed: ' . $e->getMessage(),
                'failed_item' => $item
            ]);
            exit;
        }
    }

    // ✅ Success
    echo json_encode(['status' => 'success', 'order_id' => $order_code]);
    exit;
}



if (isset($_POST['enroll_company'])) {

    $company_name    = mysqli_real_escape_string($login_db, $_POST['company_name']);
    $company_address = mysqli_real_escape_string($login_db, $_POST['company_address']);
    $email           = mysqli_real_escape_string($login_db, $_POST['email']);
    $mobile          = mysqli_real_escape_string($login_db, $_POST['mob_num']);
    $password        = md5(mysqli_real_escape_string($login_db, $_POST['password']));
    $category        = "company";

    // Default placeholders (replace with actual defaults if needed)
   

    // 1️⃣ Insert into `fresh_fare_signup` first
    $insert_signup = "INSERT INTO fresh_fare_signup 
        (username, email, mob_num, password, category, `role`, `access`, `country`, `Address_1`, `Address_2`, `town`, `state`, `zipCode`)
        VALUES 
        ('$company_name', '$email', '$mobile', '$password', '$category', '$default', 1, '$default', '$default', '$default', '$default', '$default', 1)";

    $signup_result = mysqli_query($login_db, $insert_signup);

    if ($signup_result) {
        // Get the inserted signup ID
        $signupId = mysqli_insert_id($login_db);

        // Process selling items
        $selling_items = [];
        if (!empty($_POST['selling'])) {
            foreach ($_POST['selling'] as $item) {
                if ($item === 'Chicken') {
                    if (!empty($_POST['chicken_options'])) {
                        $chicken_options = implode(', ', array_unique($_POST['chicken_options']));
                        $selling_items[] = "Chicken ($chicken_options)";
                    } else {
                        $selling_items[] = "Chicken";
                    }
                } else {
                    $selling_items[] = $item;
                }
            }
        }
        $selling = implode(', ', $selling_items);

        // 2️⃣ Insert into `company_registration` using the signup_id
        $insert_company = "INSERT INTO company_registration 
            (signup_id, company_name, company_address, email, mobile, selling_items)
            VALUES 
            ('$signupId', '$company_name', '$company_address', '$email', '$mobile', '$selling')";
        
        $company_result = mysqli_query($login_db, $insert_company);
        $companyId = mysqli_insert_id($login_db); // Get last inserted company_id

        // 3️⃣ Insert default item_price row for this company
        $itemPricesql = "INSERT INTO item_price (company_id) VALUES ($companyId)";
        $item_priceQuery = mysqli_query($login_db, $itemPricesql);

        // ✅ Check everything
        if ($company_result && $item_priceQuery) {
            header("Location:enroll_company?msg=Company Named " . $company_name . " Registered Successfully.");
            exit;
        } else {
            header("Location:enroll_company?err=Company Registration Failed: " . mysqli_error($login_db));
            exit;
        }

    } else {
        header("Location:enroll_company?err=Signup Failed: " . mysqli_error($login_db));
        exit;
    }
}

if (isset($_POST['order_id']) && isset($_POST['company_id'])) {
    $order_id = intval($_POST['order_id']);
    $company_id = intval($_POST['company_id']);

    // Update all items for this company in this order to 'picked'
    $update = $login_db->prepare("UPDATE order_items SET pickup_status = 'picked' WHERE order_id = ? AND company_id = ?");
    $update->bind_param("ii", $order_id, $company_id);
    $update->execute();

    // Check if all items in the order are picked
    $check = $login_db->prepare("SELECT COUNT(*) as pending FROM order_items WHERE order_id = ? AND pickup_status = 'pending'");
    $check->bind_param("i", $order_id);
    $check->execute();
    $result = $check->get_result()->fetch_assoc();

    if ($result['pending'] == 0) {
        // All items picked → update order status
        $login_db->query("UPDATE orders SET status = 'Order Picked Up' WHERE id = $order_id");
    } else {
        // Some items still pending → partial status
        $login_db->query("UPDATE orders SET status = 'Partially Picked' WHERE id = $order_id");
    }

    // Redirect back to the page with a success message
    header("Location: ./view_undeliveredOrders?msg=Company items marked as picked");
    
} 

if (isset($_POST['deliver_order_id'])) {
    $deliverOrderId = (int) $_POST['deliver_order_id'];
    $upd = $login_db->query("UPDATE orders SET status='delivered' WHERE id={$deliverOrderId}");
    if ($upd) {
        header("Location: view_undeliveredOrders?msg=Order marked as delivered");
        exit;
    } else {
        header("Location: view_undeliveredOrders?err=Failed to update order");
        exit;
    }
}

?>

