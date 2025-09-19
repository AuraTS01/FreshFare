<?php
include('./header.php');

if (isset($_SESSION['user'])) {
    if ((time() - $_SESSION['last_login_timestamp']) > 600) {  
        header("Location:logout.php");  
    } else {  
        $_SESSION['last_login_timestamp'] = time();  
        $sql = "SELECT * FROM `fresh_fare_signup` WHERE `email`='" . $_SESSION["email"] . "'";
        $result = mysqli_query($login_db,$sql);
        $no = mysqli_fetch_array($result);

        if ($no!=0) {
            $companySql = "SELECT company_id FROM company_registration WHERE email='" . $no['email'] . "'";
            $companyRes = mysqli_query($login_db, $companySql);
            $company = mysqli_fetch_assoc($companyRes);
            $companyId_1 = $company ? $company['company_id'] : 0;
            
?>

            <div class="container mt-4">
                <h3 class="text-center">📦 Dispatched Orders</h3>
                <!-- ✅ Hidden input to pass company_id to JS -->
                <input type="hidden" id="companyId" value="<?php echo $companyId_1; ?>">
                <div class="table-responsive">
                    <table id="dispatchedTable" class="table table-striped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Order Code</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Total Price</th>
                                <th>Order Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="dispatchedBody"></tbody>
                    </table>
                </div>
            </div></br>
<?php 
    include("./footer.php");
  }}
}else { 
  header("Location:./index"); 
} 
?>