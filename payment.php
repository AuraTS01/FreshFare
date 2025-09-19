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
   
    
    <div class="container payment-container">
        <h3 class="text-center mb-4">Payment Options</h3>

        <form id="paymentForm">
            <!-- Razorpay -->
            <div class="form-check payment-option">
                <input class="form-check-input" type="radio" name="paymentMethod" id="razorpayOption" value="razorpay">
                <label class="form-check-label" for="razorpayOption">
                    Pay Online (UPI / Card / Netbanking / Wallet)
                </label>
            </div>
            
            <!-- COD -->
            <div class="form-check payment-option mt-2">
                <input class="form-check-input" type="radio" name="paymentMethod" id="codOption" value="cod" >
                <label class="form-check-label" for="codOption">
                    Pay on Delivery
                </label>
            </div>

            <div id="codSection" class="alert alert-success mt-3 d-none">
                You’ve selected <strong>Pay on Delivery</strong>. Please keep the amount ready when your order arrives.
            </div>

            <div id="devNotice" class="alert alert-success mt-3 d-none">
                You’ve selected <strong>Online Payment</strong>. Complete the payment securely with Razorpay.
            </div>

            <button type="submit"  class="btn btn-success w-100 mt-3">Place Order</button>
        </form>
        

    </div>
    <div class="overlay" id="alertBox" style="display:none;">
        <div class="popup">
            <div id="iconBox">⚠️</div>
            <h4>Notification</h4>
            <p id="alertMessage"></p>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>
<?php 
    include("./footer.php");
  }}
}else
  { 
  header("Location:./index"); 
  }
?>

<!-- 
Live Key Id = "rzp_live_RF78uExNtRB1Cq"
Live Secret Key = "cGlUHKXS6Q1g3njRzE3jCkDY" -->