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

    <div class="container">
        <div class="order-card">
        <h3 class="text-center order-header">🎉 Order Placed Successfully!</h3>
        <p class="text-center order-id">Order ID: <strong id="orderId"></strong></p>
        <hr>

        <h5>Customer Details</h5>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Name:</strong> <span id="customerName"></span></li>
            <li class="list-group-item"><strong>Contact Number:</strong> <span id="customerPhone"></span></li>
            <li class="list-group-item"><strong>Address:</strong> <span id="customerAddress"></span></li>
        </ul>

        <h5>Items Ordered</h5>
        <ul class="list-group mb-4" id="orderedItemsList">
            <!-- Dynamically filled -->
        </ul>

        <div class="text-end">
            <p><strong>Subtotal:</strong> ₹<span id="subtotal">0.00</span></p>
            <p><strong>Total:</strong> ₹<span id="total">0.00</span></p>
        </div>
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