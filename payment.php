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
            <div class="form-check payment-option">
                <input class="form-check-input" type="radio" name="paymentMethod" id="cardOption" value="card" checked>
                <label class="form-check-label" for="cardOption">
                Credit/Debit Card
                </label>
            </div>

            <div class="form-check payment-option">
                <input class="form-check-input" type="radio" name="paymentMethod" id="upiOption" value="upi">
                <label class="form-check-label" for="upiOption">
                UPI
                </label>
            </div>

            <div class="form-check payment-option">
                <input class="form-check-input" type="radio" name="paymentMethod" id="codOption" value="cod">
                <label class="form-check-label" for="codOption">
                    Pay on Delivery
                </label>    
            </div>
            </br>
            <div id="codSection" class="alert alert-success mt-3">
                You’ve selected <strong>Pay on Delivery</strong>. Please keep the amount ready when your order arrives.
            </div>
            <!-- Card Form -->
            <div id="devNotice" class="alert alert-warning mt-3 d-none">
                This payment method is under development. Please choose <strong>Pay on Delivery</strong>.
            </div>

            <!-- UPI Form -->
            <div id="upiForm" class="hidden">
                <div class="mb-3">
                    <label for="upiId" class="form-label">UPI ID</label>
                    <input type="text" class="form-control" id="upiId" placeholder="example@upi">
                </div>
            </div>

            <!-- COD Info -->
            <div id="codInfo" class="alert alert-info hidden">
            You have selected <strong>Pay on Delivery</strong>. No need to enter payment info.
            </div>

            <button type="submit" id="checkoutBtn" name="checkoutBtn" class="btn btn-success w-100">Place Order</button>
        </form>
    </div>
<?php 
    include("./footer.php");
  }}
}else
  { 
  header("Location:./index"); 
  }
?>