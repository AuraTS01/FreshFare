<?php
include('./header.php');

if (isset($_SESSION['user'])) {
    if ((time() - $_SESSION['last_login_timestamp']) > 600) {  
        header("Location:logout.php");  
    } else {  
        $_SESSION['last_login_timestamp'] = time();  

        // ✅ Get logged-in user
        $sql = "SELECT * FROM `fresh_fare_signup` WHERE `email`='" . $_SESSION["email"] . "'";
        $result = mysqli_query($login_db, $sql);
        $no = mysqli_fetch_assoc($result);

        if ($no) {
            $userId = $no['id']; 

            // ✅ Fetch orders for this user
            $orderSql = "
                SELECT id, order_code, order_date, payment_mode, total_price, status 
                FROM `orders` 
                WHERE `customer_id` = $userId 
                ORDER BY id DESC
            ";
            $orderResult = mysqli_query($login_db, $orderSql);

            $orders = [];
            while ($row = mysqli_fetch_assoc($orderResult)) {
                $orders[$row['id']] = $row;
                $orders[$row['id']]['items'] = [];
            }

            if (!empty($orders)) {
                $orderIds = implode(",", array_keys($orders));

                // ✅ Fetch items for all these orders
                $itemSql = "
                    SELECT id, order_id, item_name, quantity, unit, price 
                    FROM `order_items` 
                    WHERE `order_id` IN ($orderIds)
                ";
                $itemResult = mysqli_query($login_db, $itemSql);
                while ($r = mysqli_fetch_assoc($itemResult)) {
                    $orders[$r['order_id']]['items'][] = $r;
                }
            }

            $statusLabels = [
                'pending'     => 'pending',
                'acknowledged' => 'Acknowledged',
                'picked'   => 'Picked Up',
                'dispatched'  => 'Dispatched',
                'delivered'   => 'Delivered'
            ];

            $statusColors = [
                'pending'     => 'badge bg-warning text-dark',
                'acknowledged' => 'badge bg-warning text-dark',
                'picked'   => 'badge bg-info text-dark',
                'dispatched'  => 'badge bg-info text-dark',
                'delivered'   => 'badge bg-success'
            ];
?>

            <div class="container mt-4">
                <h3 class="text-center">Order History</h3>
                <hr>

                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                        <?php 
                            $status = strtolower($order['status']);
                            $statusText = $statusLabels[$status] ?? ucfirst($status);
                            $statusClass = $statusColors[$status] ?? "badge bg-secondary";
                        ?>
                        <div class="order-card">
                            <div class="order-header">Order #<?= htmlspecialchars($order['order_code']); ?></div>
                            <div class="order-meta">
                                <strong>Date:</strong> <?= htmlspecialchars($order['order_date']); ?><br>
                                <strong>Status:</strong> <span class="<?= $statusClass ?>"><?= $statusText ?></span><br>
                                <strong>Payment Mode:</strong> <?= htmlspecialchars($order['payment_mode']); ?><br>
                                <strong>Total Paid:</strong> ₹<?= number_format((float)$order['total_price'], 2); ?>
                            </div>
                            <div class="order-items">
                                <strong>Items:</strong>
                                <ul>
                                    <?php foreach ($order['items'] as $it): ?>
                                        <li>
                                            <?= htmlspecialchars($it['item_name']); ?> × <?= (float)$it['quantity']; ?> <?= htmlspecialchars($it['unit']); ?>
                                            (₹<?= number_format((float)$it['price'], 2); ?> each)
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No orders found.</p>
                <?php endif; ?>
            </div>

            
<?php 
        }
        include("./footer.php");
    }
} else { 
  header("Location:./index"); 
} 
?>
