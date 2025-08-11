<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();

$_SESSION['user']= "live";

$login_db =  new mysqli("localhost","root","","FreshFare");

$default = "undefined";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Add this near top of file



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
        echo "Email already exists";
        exit();
    }

    $sql = "INSERT INTO fresh_fare_signup (`username`, `email`, `mob_num`, `password`, `category`, `access`, `role`, `country` , `Address_1`, `Address_2` ,`town`,`state` ,`zipCode` )
            VALUES ('$name', '$email', '$mobile', '$hashedPassword', '$category', '$access', '$default', '$default', '$default', '$default', '$default', '$default', '1')";

    if (mysqli_query($login_db, $sql)) {
        echo "Account created successfully!";
    } else {
        echo "MySQL Insert Error: " . mysqli_error($login_db);
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
                    
                        header("Location:dashboard");
                                      
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'save_order') {
    header("Content-Type: application/json");

    if (!isset($_SESSION['email'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    // Decode JSON input
    $data = json_decode(file_get_contents("php://input"), true);
    $payment_mode = $data['payment_mode'] ?? 'unknown';
    $cart = $data['cart'] ?? [];

    // Debug: log raw cart
    error_log("Received cart data: " . print_r($cart, true));

    if (empty($cart)) {
        echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
        exit;
    }

    // Calculate total price
    $total = 0;
    foreach ($cart as $item) {
        $price = isset($item['price']) ? (float)$item['price'] : 0;
        $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
        $total += $price * $quantity;
    }

    // Get customer ID from session
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

    // Insert order
    $order_id = "ORD" . rand(100000, 999999);
    $order_date = date("Y-m-d H:i:s");
    $stmt = $login_db->prepare("INSERT INTO orders (customer_id, order_id, order_date, payment_mode, total_price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $customer_id, $order_id, $order_date, $payment_mode, $total);
    $stmt->execute();
    $order_db_id = $stmt->insert_id;
    $stmt->close();

    // Insert each item
    foreach ($cart as $item) {
        $item_name = $item['name'] ?? 'Unknown';
        $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;
        $price = isset($item['price']) ? (float)$item['price'] : 0;
        $unit = 'Kg'; // default unit

        $stmt = $login_db->prepare("INSERT INTO order_items (order_id, customer_id, item_name, quantity, unit, price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdss", $order_db_id, $customer_id, $item_name, $quantity, $unit, $price);

        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Item insert failed: ' . $e->getMessage(),
                'failed_item' => $item
            ]);
            exit;
        }

        $stmt->close();
    }

    // All done
    echo json_encode(['status' => 'success', 'order_id' => $order_id]);
    exit;
}


if (isset($_POST['enroll_company'])) {
    $company_name    = mysqli_real_escape_string($login_db, $_POST['company_name']);
    $company_address = mysqli_real_escape_string($login_db, $_POST['company_address']);
    $email           = mysqli_real_escape_string($login_db, $_POST['email']);
    $mobile          = mysqli_real_escape_string($login_db, $_POST['mob_num']);
    $password        = mysqli_real_escape_string($login_db, $_POST['password']);
    $category        = "company";

    // Process selling items
    $selling         = isset($_POST['selling']) ? implode(', ', $_POST['selling']) : '';
    $chicken_options = isset($_POST['chicken_options']) ? implode(', ', $_POST['chicken_options']) : '';

    if (strpos($selling, 'Chicken') !== false && $chicken_options !== '') {
        $selling .= ' (' . $chicken_options . ')';
    }

    // ✅ 1. Insert into `company_registration` table
    $insert_company = "INSERT INTO company_registration 
        (company_name, company_address, email, mobile, selling_items)
        VALUES 
        ('$company_name', '$company_address', '$email', '$mobile', '$selling')";
    
    $company_result = mysqli_query($login_db, $insert_company);

    // ✅ 2. Insert into `signup` table with role as `company`
    $insert_signup = "INSERT INTO fresh_fare_signup 
        (username, email, mob_num, password, category, `role`, `access`, `country`, `Address_1`, `Address_2`, `town`, `state`, `zipCode`)
        VALUES 
        ('$company_name', '$email', '$mobile', '$password', '$category',  '$default', 1, '$default', '$default', '$default', '$default', '$default', '1')";
    
    $signup_result = mysqli_query($login_db, $insert_signup);

    if ($company_result && $signup_result) {
        echo "<script>alert('Company registered successfully!'); window.location.href = 'enroll_company';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($login_db) . "'); window.location.href = 'enroll_company';</script>";
    }
}

?>

