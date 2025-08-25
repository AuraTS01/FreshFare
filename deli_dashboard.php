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




      

        // // Orders delivered
        $sqlDelivered = "SELECT COUNT(*) AS delivered_orders 
                        FROM orders WHERE status='delivered'";
        $deliveredData = $login_db->query($sqlDelivered)->fetch_assoc();
        $deliveredOrders = $deliveredData['delivered_orders'] ?? 0;
        

       // Pending Orders (not yet picked)
        $sqlPending = "SELECT COUNT(*) AS pending_orders 
                       FROM orders WHERE status='pending'";
        $pendingOrders = $login_db->query($sqlPending)->fetch_assoc()['pending_orders'] ?? 0;

        // Picked Up Orders (but not delivered yet)
        $sqlPicked = "SELECT COUNT(*) AS picked_orders 
                      FROM orders WHERE status='Order Picked Up'";
        $pickedOrders = $login_db->query($sqlPicked)->fetch_assoc()['picked_orders'] ?? 0;

       
?>

        <div class="container py-5">
            <h3 class="mb-4 text-center">📊 Delivery Dashboard</h3>

            <div class="row g-4">

                <!-- Companies -->
                
                <!-- Delivered Orders -->
                <div class="col-md-3 text-center">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-success text-white">
                        <h3><?php echo $deliveredOrders; ?></h3>
                        <p>Delivered Orders</p>
                        
                    </div>
                </div>
               <!-- Pending Orders -->
                <div class="col-md-3 text-center">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-warning text-white">
                        <h3><?php echo $pendingOrders; ?></h3>
                        <p>Pending Orders</p>
                    </div>
                </div>

                <!-- Picked Up Orders -->
                <div class="col-md-3 text-center">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-primary text-white">
                        <h3><?php echo $pickedOrders; ?></h3>
                        <p>Picked Up (Undelivered)</p>
                    </div>
                </div>
                <!-- Total Income -->
                
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