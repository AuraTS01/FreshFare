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
            // ✅ Fetch all pending orders
            

            function ff_fmt_dt($dt) {
                return date("d M Y H:i", strtotime($dt));
            }
?>
        
        <div class="container mt-4">
            <?php
            if (isset($_GET['msg']) || isset($_GET['err'])) {
                $msg = isset($_GET['msg']) ? $_GET['msg'] : $_GET['err'];
                showAlert($msg);
            }
            ?>
            <h3 class="text-center">🛒 Live Orders</h3><br>
            <audio id="orderAlert" src="sounds/bell.mp3" preload="auto" loop></audio>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody id="ordersBody"></tbody>
                </table>
                <div id="noOrdersMsg" class="text-center text-muted mt-3" style="display:none;">
                    🚫 No Orders as of now
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-2">
                <button id="prevBtn" class="btn btn-sm btn-outline-secondary">Prev</button>
                <span id="pageInfo" class="mx-2"></span>
                <button id="nextBtn" class="btn btn-sm btn-outline-secondary">Next</button>
            </div>
        </div>


        <!-- Hidden audio element -->
        
    


<?php 
    include("./footer.php");
  }}
}else { 
  header("Location:./index"); 
} 
?>
