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




        $sqlCompanies = "SELECT COUNT(*) AS total_companies FROM company_registration";
        $totalCompanies = $login_db->query($sqlCompanies)->fetch_assoc()['total_companies'];

        // // Orders delivered
        $sqlDelivered = "SELECT COUNT(*) AS delivered_orders, SUM(total_price) AS delivered_income 
                        FROM orders WHERE status='delivered'";
        $deliveredData = $login_db->query($sqlDelivered)->fetch_assoc();
        $deliveredOrders = $deliveredData['delivered_orders'] ?? 0;
        $deliveredIncome = $deliveredData['delivered_income'] ?? 0;

        // // Orders undelivered
        $sqlPending = "SELECT COUNT(*) AS pending_orders 
                       FROM orders WHERE status='pending'";
        $pendingOrders = $login_db->query($sqlPending)->fetch_assoc()['pending_orders'] ?? 0;

        // Picked Up Only
        $sqlPickedUp = "SELECT COUNT(*) AS pickedup_orders, SUM(total_price) AS pickedup_income 
                FROM orders WHERE status='Order Picked Up'";
        $pickedUpData = $login_db->query($sqlPickedUp)->fetch_assoc();
        $pickedUpOrders = $pickedUpData['pickedup_orders'] ?? 0;
        $pickedUpIncome = $pickedUpData['pickedup_income'] ?? 0;

        // // Total income (all orders)
        $sqlTotalIncome = "SELECT SUM(total_price) AS total_income FROM orders WHERE status='delivered'";
        $totalIncome = $login_db->query($sqlTotalIncome)->fetch_assoc()['total_income'] ?? 0;
?>

        <div class="container py-5">
            <h3 class="mb-4 text-center">📊 Company Dashboard</h3>

            <div class="row g-4">

                <!-- Companies -->
                <div class="col-md-3">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-primary text-white">
                        <h3><?php echo $totalCompanies; ?></h3>
                        <p>Total Companies</p>
                    </div>
                </div>

                <!-- Total Income -->
                <div class="col-md-3">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-info text-white">
                        <h3>₹<?php echo number_format($totalIncome,2); ?></h3>
                        <p>Total Income</p>
                    </div>
                </div>
                
                <!-- Delivered Orders -->
                <div class="col-md-3">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-success text-white">
                        <h3><?php echo $deliveredOrders; ?></h3>
                        <p>Delivered Orders</p>
                        <small>Income: ₹<?php echo number_format($deliveredIncome,2); ?></small>
                    </div>
                </div>
                </br></br></br>
               
                <!-- Pending Orders -->
                <div class="col-md-2">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-danger text-white">
                        <h3><?php echo $pendingOrders; ?></h3>
                        <p>Pending Orders</p>
                    </div>
                </div>

                <!-- Picked Up Orders -->
                <div class="col-md-3">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-warning text-white">
                        <h3><?php echo $pickedUpOrders; ?></h3>
                        <p>Picked Up Orders</p>
                        <small>Worth: ₹<?php echo number_format($pickedUpIncome,2); ?></small>
                    </div>
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