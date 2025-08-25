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

        // Fetch all orders with items
        
        $sql = "
            SELECT o.id AS order_id, o.order_code, o.order_date, o.payment_mode, 
                o.total_price, o.status,
                c.username AS customer_name, c.email, c.mob_num,
                oi.item_name, oi.quantity, oi.unit, oi.price,
                oi.company_id,
                cr.company_name
            FROM orders o
            JOIN fresh_fare_signup c ON o.customer_id = c.id
            LEFT JOIN order_items oi ON o.id = oi.order_id
            LEFT JOIN company_registration cr ON oi.company_id = cr.company_id
            ORDER BY o.order_date DESC, o.id DESC
        ";
        $result = $login_db->query($sql);

        // Organize data into structured array
        $orders = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $orderId = $row['order_id'];
                if (!isset($orders[$orderId])) {
                    $orders[$orderId] = [
                        'order_id' => $row['order_id'],
                        'order_code' => $row['order_code'],
                        'customer_name' => $row['customer_name'],
                        'email' => $row['email'],
                        'mob_num' => $row['mob_num'],
                        'order_date' => $row['order_date'],
                        'payment_mode' => $row['payment_mode'],
                        'status' => $row['status'],
                        'total_price' => $row['total_price'],
                        'items' => []
                    ];
                }
                if ($row['item_name']) {
                    $orders[$orderId]['items'][] = [
                        'item_name'   => $row['item_name'],
                        'quantity'    => $row['quantity'],
                        'unit'        => $row['unit'],
                        'price'       => $row['price'],
                        'company_id'  => $row['company_id'],
                        'company_name'=> $row['company_name']
                    ];
                }
            }
        }
        $totalDelivered = 0;
        if (!empty($orders)) {
            foreach ($orders as $order) {
                if (strtolower($order['status']) === 'delivered') {
                    $totalDelivered += $order['total_price'];
                }
            }
        }

        
?>

        <div class="container py-5">
            <h4 class="mb-4 text-center">📋 Orders Table</h4>

            <!-- Top Bar: Delivered Total + Search -->
            <div class="d-flex justify-content-end align-items-center mb-3 gap-3 flex-wrap">
                <!-- Delivered Total Box -->
                <div class="delivered-total">
                    <span class="delivered-total-box">
                        Delivered Total Amount: ₹<?php echo number_format($totalDelivered, 2); ?>
                    </span>
                </div>

                <!-- Search Box -->
                
            </div>

            <div class="table-responsive">
                <table id="ordersTable" class="table table-bordered table-hover align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Items</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Payment Mode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)) { ?>
                            <?php foreach ($orders as $order) { ?>
                                <tr>
                                    <td><strong>#<?php echo $order['order_code']; ?></strong></td>
                                    <td><?php echo $order['customer_name']; ?></td>
                                    <td><?php echo $order['email']; ?></td>
                                    <td><?php echo $order['mob_num']; ?></td>

                                    <!-- Items -->
                                    <td>
                                        <?php if (!empty($order['items'])) { ?>
                                            <ul class="items-list mb-0 ps-3">
                                                <?php foreach ($order['items'] as $item) { ?>
                                                    <li>
                                                        <?php echo $item['item_name']; ?> 
                                                        (<?php echo $item['quantity'] . " " . $item['unit']; ?>) 
                                                        - ₹<?php echo number_format($item['price'], 2); ?>
                                                        <br><small class="text-muted">[<?php echo $item['company_name']; ?>]</small>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } else { ?>
                                            <em>No items</em>
                                        <?php } ?>
                                    </td>

                                    <!-- Total Price -->
                                    <td>₹<?php echo number_format($order['total_price'],2); ?></td>

                                    <td><?php echo date("d M Y H:i", strtotime($order['order_date'])); ?></td>
                                    <td><?php echo ucfirst($order['payment_mode']); ?></td>
                                    <td>
                                        <?php if ($order['status'] === 'delivered') { ?>
                                            <span class="status-delivered">Delivered</span>
                                        <?php } elseif ($order['status'] === 'pending') { ?>
                                            <span class="status-pending">Pending</span>
                                        <?php } else { ?>
                                            <span class="status-cancelled"><?php echo ucfirst($order['status']); ?></span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="9" class="text-center">No orders found.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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