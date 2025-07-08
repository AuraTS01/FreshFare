<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();

$_SESSION['user']= "live";

$login_db =  new mysqli("localhost","root","root","FreshFare");

$default = "undefined";





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

    $sql = "INSERT INTO fresh_fare_signup (username, email, mob_num, password, category, access, role)
            VALUES ('$name', '$email', '$mobile', '$hashedPassword', '$category', '$access', '$default')";

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
            header("Location:checkout?Billing Address Updated");
        }
        
        
    }else if ($Address_2 == ""){

        $check_sql = "UPDATE fresh_fare_signup SET `country` = '$country', `Address_1` = '$Address_1', `Address_2` = '',`town` = '$town',`state` = '$state',`zipCode` = '$zipCode' WHERE `email` = '$email' AND `mob_num`='$contactNumber'";
       
        if(mysqli_query($login_db,$check_sql)){
            header("Location:checkout?Billing Address Updated");
        }
    }
}





?>

