<?php
include('./header.php');
// session_start();

if (isset($_SESSION['user'])) {
  if ((time() - $_SESSION['last_login_timestamp']) > 600) {
    header("Location:logout.php");
    exit;
  } else {
    $_SESSION['last_login_timestamp'] = time();

    

    $email = $_SESSION['email'];

    // Get customer info
    $customer_sql = "SELECT id, username, mob_num, Address_1, Address_2, town, state, zipCode FROM fresh_fare_signup WHERE email = '$email'";
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
    //echo "<p>Debug: Order ID is " . $order['id'] . "</p>";

    $items_sql = "SELECT * FROM order_items WHERE order_id = $order_id";
    $items_result = mysqli_query($login_db, $items_sql);

    $items = [];
    $total = 0;

    while ($row = mysqli_fetch_assoc($items_result)) {
      $items[] = $row;
      $total += $row['quantity'] * $row['price'];
    }
?>
    <div class="container mt-5">
      <div class="card shadow">
        <div class="card-header bg-success text-white">
          <h4>Order Summary</h4>
        </div>
        <div class="card-body">
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
          <p><strong>Payment Mode:</strong> <?= htmlspecialchars($order['payment_mode']) ?></p>

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
            <h5 class="text-end">Total: ₹<?= number_format($total, 2) ?></h5>
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
