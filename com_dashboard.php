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
        $signupId = $no['id'];
        showAlert($no['id']);
        // Fetch company for this user
        $sqlCompany = "SELECT company_id, company_name 
                       FROM company_registration 
                       WHERE signup_id = '$signupId'";
        $companyResult = $login_db->query($sqlCompany);
        $companyData = $companyResult->fetch_assoc();

        
        $companyId = $companyData['company_id'];
        $companyName = $companyData['company_name'];

        // Orders Received
        $sqlReceived = "SELECT COUNT(*) AS received_orders, SUM(total_price) AS received_income 
                        FROM orders 
                        WHERE status='pending' AND company_id='$companyId'";
        $receivedData = $login_db->query($sqlReceived)->fetch_assoc();
        $receivedOrders = $receivedData['received_orders'] ?? 0;
        $receivedIncome = $receivedData['received_income'] ?? 0;

        // Orders Packed
        $sqlPacked = "SELECT COUNT(*) AS packed_orders, SUM(total_price) AS packed_income 
                      FROM orders 
                      WHERE status In ('disptached') AND company_id='$companyId'";
        $packedData = $login_db->query($sqlPacked)->fetch_assoc();
        $packedOrders = $packedData['packed_orders'] ?? 0;
        $packedIncome = $packedData['packed_income'] ?? 0;

        // Out for Delivery
       
        // Total Income for this company
        // $sqlTotalIncome = "SELECT SUM(total_price) AS total_income 
        //                     FROM orders ";
                            
        // $totalIncome = $login_db->query($sqlTotalIncome)->fetch_assoc()['total_income'] ?? 0;
?>

        <div class="container py-5">
            <h3 class="mb-4 text-center">📦  <?php echo $companyName; ?> Orders Dashboard </h3>

            <div class="row g-4">

                <!-- Orders Received -->
                <div class="col-md-4">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-primary text-white">
                        <h3><?php echo $receivedOrders; ?></h3>
                        <p>Pending Orders Received</p>
                        <!-- <small>Worth: ₹<?php //echo number_format($receivedIncome,2); ?></small> -->
                    </div>
                </div>

                <!-- Orders Packed -->
                <div class="col-md-4">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-warning text-dark">
                        <h3><?php echo $packedOrders; ?></h3>
                        <p>Orders Packed and Out for Delivery</p>
                        <!-- <small>Worth: ₹<?php //echo number_format($packedIncome,2); ?></small> -->
                    </div>
                </div>
                
                <!-- Out for Delivery -->
                

                <!-- Total Income -->
                <!-- <div class="col-md-12 mt-4">
                    <div class="card shadow-lg rounded-4 text-center p-3 bg-success text-white">
                        <h3>₹<?php //echo number_format($totalIncome,2); ?></h3>
                        <p>Total Order Value</p>
                    </div>
                </div> -->
                
            </div>
        </div>

<?php 
        

    }
    include("./footer.php");
  }}
else
{ 
  header("Location:./index"); 
}
?>
