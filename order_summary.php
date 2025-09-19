<?php
include('./header.php');

if (isset($_SESSION['user'])) {
    if ((time() - $_SESSION['last_login_timestamp']) > 600) {
        header("Location:logout.php");
        exit;
    } else {
        $_SESSION['last_login_timestamp'] = time();

        $email = $_SESSION['email'];

        // Get customer info
        $customer_sql = "SELECT id, username, mob_num, Address_1, Address_2, town, state, zipCode 
                         FROM fresh_fare_signup WHERE email = '$email'";
        $customer_result = mysqli_query($login_db, $customer_sql);
        $customer = mysqli_fetch_assoc($customer_result);

        if (!$customer) {
            echo "Customer not found.";
            exit;
        }

        $customer_id = $customer['id'];

        // Get latest order
        $order_sql = "SELECT * FROM orders WHERE customer_id = $customer_id ORDER BY id DESC LIMIT 1";
        $order_result = mysqli_query($login_db, $order_sql);
        $order = mysqli_fetch_assoc($order_result);

        if (!$order) {
            echo "No recent orders found.";
            exit;
        }

        $order_id = $order['id'];

        // Get order items
        $items_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
        $items_result = mysqli_query($login_db, $items_sql);

        $items = [];
        $subtotal = 0;

        while ($row = mysqli_fetch_assoc($items_result)) {
            $items[] = $row;
            $subtotal += $row['quantity'] * $row['price'];
        }

        // Calculate discount if coupon applied
        $discount = 0;
        if (!empty($order['coupon_code'])) {
            $discount = 0.25 * $subtotal; // Assuming 25% discount
        }

        $subtotal_after_discount = $subtotal - $discount;
        $gst = $subtotal_after_discount * 0.00;
        $final_total = $order['total_price'];

        // Decide badge color based on status
        $statusClass = "bg-secondary";
        switch (strtolower($order['status'])) {
            case "pending":
            case "acknowledged":
                $statusClass = "bg-warning text-dark";
                break;
            case "picked":
            case "dispatched":
                $statusClass = "bg-info text-dark";
                break;
            case "delivered":
                $statusClass = "bg-success";
                break;
            case "cancelled":
                $statusClass = "bg-danger";
                break;
        }

        // Determine payment mode display
        $paymentDisplay = "Unknown";
        if (stripos($order['payment_mode'], 'cod') !== false) {
            $paymentDisplay = "Cash on Delivery";
        } elseif (stripos($order['payment_mode'], 'razorpay') !== false || stripos($order['payment_mode'], 'rzrpay') !== false) {
            $paymentDisplay = "Online Payment";
        }
?>
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Order Summary</h4>
        </div>
        <div class="card-body">
            <p>Note: This is a summary of your most recent order. For detailed order history, please visit the <a href="./order_history">Order History</a> page.</p>
            <?php if ($paymentDisplay === "Cash on Delivery"): ?>
                <div class="alert alert-info">
                    <strong>Pay on Delivery Amount:</strong> ₹<?= number_format($final_total, 2) ?>
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    <strong>Amount Paid Online:</strong> ₹<?= number_format($final_total, 2) ?>
                </div>
            <?php endif; ?>
            <h5>Customer Info</h5>
            <p><strong>Name:</strong> <?= htmlspecialchars($customer['username']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($customer['mob_num']) ?></p>
            <p><strong>Address:</strong>
                <?= htmlspecialchars($customer['Address_1']) ?>,
                <?= htmlspecialchars($customer['Address_2']) ?>,
                <?= htmlspecialchars($customer['town']) ?>,
                <?= htmlspecialchars($customer['state']) ?> -
                <?= htmlspecialchars($customer['zipCode']) ?>
            </p>
            
            <h5 class="mt-4">Order Details</h5>
            <p><strong>Order ID:</strong> <?= htmlspecialchars($order['order_code']) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
            <p><strong>Payment Mode:</strong> <?= $paymentDisplay ?>
            <p><strong>Payment ID:</strong> <?= htmlspecialchars($order['payment_mode']) ?></p>
            
            <p><strong>Status:</strong> 
                <span class="badge <?= $statusClass ?>">
                    <?= htmlspecialchars(ucwords($order['status'])) ?>
                </span>
            </p>

            <h5 class="mt-4">Items</h5>
            <?php if (count($items) > 0): ?>
            <ul class="list-group mb-3">
                <?php foreach ($items as $item): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <?= htmlspecialchars($item['item_name']) ?> × <?= $item['quantity'] ?> <?= $item['unit'] ?>
                        <span>₹<?= number_format($item['quantity'] * $item['price'], 2) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Subtotal:</strong>
                    <span>₹<?= number_format($subtotal, 2) ?></span>
                </li>
                <?php if ($discount > 0): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>Discount (<?= htmlspecialchars($order['coupon_code']) ?>):</strong>
                    <span>-₹<?= number_format($discount, 2) ?></span>
                </li>
                <?php endif; ?>
                <li class="list-group-item d-flex justify-content-between">
                    <strong>GST (0%):</strong>
                    <span>₹<?= number_format($gst, 2) ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between bg-light">
                    <strong>Final Total:</strong>
                    <span>₹<?= number_format($final_total, 2) ?></span>
                </li>
            </ul>
            <?php else: ?>
                <p>No items found for this order.</p>
            <?php endif; ?>

            

        </div>
    </div>
</div>

<?php
        include('./footer.php');
    }
} else {
    header("Location:./index");
    exit;
}
?>
