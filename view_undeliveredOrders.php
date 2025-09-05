<?php
include('./header.php');

if (isset($_SESSION['user'])) 
{

  if((time() - $_SESSION['last_login_timestamp']) > 600) // 10 min session expiry 
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
            SELECT 
                o.id                AS order_id,
                o.order_code,
                o.order_date,
                o.payment_mode,
                o.total_price,
                o.status,
                c.username          AS customer_name,
                c.mob_num,
                oi.id               AS order_item_id,
                oi.item_name,
                oi.quantity,
                oi.unit,
                oi.price,
                oi.company_id,
                oi.pickup_status,
                cr.company_name
            FROM orders o
            JOIN fresh_fare_signup c  ON c.id = o.customer_id
            JOIN order_items oi       ON oi.order_id = o.id
            JOIN company_registration cr ON cr.company_id = oi.company_id
            WHERE 1=1
            ORDER BY 
                STR_TO_DATE(o.order_date, '%Y-%m-%d %H:%i:%s') DESC, 
                o.id DESC, 
                cr.company_name ASC;
        ";

        $res = $login_db->query($sql);

        // Build “one row per order” structure + group by company
        $orders = [];
        if ($res && $res->num_rows) {
            while ($r = $res->fetch_assoc()) {
                $oid = (int)$r['order_id'];
                $cid = (int)$r['company_id'];

                if (!isset($orders[$oid])) {
                    $orders[$oid] = [
                        'order_id'      => $oid,
                        'order_code'    => $r['order_code'],
                        'order_date'    => $r['order_date'],
                        'payment_mode'  => $r['payment_mode'],
                        'total_price'   => (float)$r['total_price'],
                        'status'        => $r['status'],
                        'customer_name' => $r['customer_name'],
                        'mob_num'       => $r['mob_num'],
                        'companies'     => [],
                        'items_total'   => 0,
                        'items_picked'  => 0,
                    ];
                }

                if (!isset($orders[$oid]['companies'][$cid])) {
                    $orders[$oid]['companies'][$cid] = [
                        'company_id'     => $cid,
                        'company_name'   => $r['company_name'],
                        'items'          => [],
                        'total_items'    => 0,
                        'picked_items'   => 0,
                        'all_picked'     => false,
                    ];
                }

                // add item under this company
                $orders[$oid]['companies'][$cid]['items'][] = [
                    'order_item_id' => (int)$r['order_item_id'],
                    'item_name'     => $r['item_name'],
                    'quantity'      => (float)$r['quantity'],
                    'unit'          => $r['unit'],
                    'price'         => (float)$r['price'],
                    'pickup_status' => $r['pickup_status'],
                ];

                // counters
                $orders[$oid]['companies'][$cid]['total_items']++;
                $orders[$oid]['items_total']++;
                if ($r['pickup_status'] === 'picked') {
                    $orders[$oid]['companies'][$cid]['picked_items']++;
                    $orders[$oid]['items_picked']++;
                }
            }
        }

        // finalize per-company flags
        foreach ($orders as $oid => &$od) {
            foreach ($od['companies'] as $cid => &$co) {
                $co['all_picked'] = ($co['picked_items'] >= $co['total_items']);
                // If entire order is picked/delivered → force company to picked
                if ($od['status'] === 'delivered' || $od['items_picked'] === $od['items_total']) {
                    $co['all_picked'] = true;
                }
            }
        }
        unset($od, $co);

        // Small helper to format date
        function ff_fmt_dt($dt) {
            return date("d M Y H:i", strtotime($dt));
        }
?>

<div class="container py-4">
    <?php 
        if(isset($_GET['msg']) || isset($_GET['err'])){
            $msg = isset($_GET['msg'])? $_GET['msg']:$_GET['err'];
            showAlert($msg);
        }
    ?>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="mb-2">🚚 Undelivered Orders</h4>
        <div class="small text-muted">Mark pickups company-wise. When all companies are picked → status becomes <strong>Order Picked Up</strong>.</div>
    </div>

    <div class="table-responsive">
        <table id="undeliveredordersTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Companies & Items</th>
                    <th style="min-width:140px;">Progress</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th style="min-width:220px;">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($orders): ?>
                <?php foreach ($orders as $order): 
                    $totalItems    = max(1, (int)$order['items_total']);
                    $pickedItems   = (int)$order['items_picked'];

                    // Fix progress → force 100% if picked up or delivered
                    if ($order['status'] === 'delivered' || $pickedItems === $totalItems) {
                        $pct = 100;
                    } else {
                        $pct = (int) round(($pickedItems / $totalItems) * 100);
                    }

                    $companies     = $order['companies'];
                    $pendingCos    = array_filter($companies, fn($co) => !$co['all_picked']);

                    // derive a soft status pill
                    if ($order['status'] === 'delivered') {
                        $statusPill = '<span class="status-pill status-delivered">Delivered</span>';
                    } elseif ($pickedItems > 0 && $pickedItems < $totalItems) {
                        $statusPill = '<span class="status-pill status-partial">Partially Picked</span>';
                    } elseif ($pickedItems === $totalItems) {
                        $statusPill = '<span class="status-pill status-pickedup">Order Picked Up</span>';
                    } else {
                        $statusPill = '<span class="status-pill status-undelivered">Undelivered</span>';
                    }
                ?>
                <tr>
                    <td>
                        <div class="fw-semibold">#<?= htmlspecialchars($order['order_code']) ?></div>
                        <div class="mt-1"><?= $statusPill ?></div>
                    </td>

                    <td>
                        <div class="fw-semibold"><?= htmlspecialchars($order['customer_name']) ?></div>
                        <div class="text-muted small"><?= htmlspecialchars($order['mob_num']) ?></div>
                        <div class="text-muted small"><?= htmlspecialchars(ucfirst($order['payment_mode'])) ?></div>
                    </td>

                    <td>
                        <ul class="company-list">
                            <?php foreach ($companies as $co): ?>
                                <li>
                                    <span class="chip">
                                        <span class="dot <?= $co['all_picked'] ? 'dot-picked' : 'dot-pending' ?>"></span>
                                        <span class="fw-semibold"><?= htmlspecialchars($co['company_name']) ?></span>
                                        <span class="text-muted">• <?= $co['picked_items'] ?>/<?= $co['total_items'] ?></span>
                                    </span>
                                    <!-- items under the company -->
                                    <ul class="item-list text-muted small">
                                        <?php foreach ($co['items'] as $it): ?>
                                            <li>
                                                <?= htmlspecialchars($it['item_name']) ?>
                                                (<?= rtrim(rtrim(number_format($it['quantity'],2), '0'), '.') . ' ' . htmlspecialchars($it['unit']) ?>)
                                                – ₹<?= number_format($it['price'], 2) ?>
                                                <?= $it['pickup_status'] === 'picked' ? '<span class="text-success">✔</span>' : '' ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>

                    <td style="min-width:160px;">
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted"><?= $pickedItems ?>/<?= $totalItems ?></span>
                            <span class="small"><?= $pct ?>%</span>
                        </div>
                        <div class="progress mt-1">
                            <div class="progress-bar" role="progressbar" style="width: <?= $pct ?>%;" aria-valuenow="<?= $pct ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>

                    <td>₹<?= number_format($order['total_price'], 2) ?></td>
                    <td><?= ff_fmt_dt($order['order_date']) ?></td>

                    <td>
                        <?php if ($order['status'] === 'delivered'): ?>
                            <!-- Already delivered -->
                            <span class="badge all-picked-badge">✔ All items picked & Delivered</span>

                        <?php elseif (!empty($pendingCos)): ?>
                            <!-- Still has pending companies -->
                            <form action="view_undeliveredOrders" method="POST" class="mark-form">
                                <input type="hidden" name="order_id" value="<?= (int)$order['order_id'] ?>">

                                <label class="form-label small mb-1">Select company to mark picked</label>
                                <select class="form-select form-select-sm" name="company_id" required>
                                    <option value="" selected disabled>Select company…</option>
                                    <?php foreach ($pendingCos as $co): ?>
                                        <option value="<?= (int)$co['company_id'] ?>">
                                            <?= htmlspecialchars($co['company_name']) ?> (<?= $co['total_items'] - $co['picked_items'] ?> pending)
                                        </option>
                                    <?php endforeach; ?>
                                </select>

                                <button type="submit" class="btn btn-outline-success btn-sm btn-mark mt-2">
                                    Mark Picked
                                </button>
                            </form>
                            <div class="text-muted small mt-1">
                                Picking updates only the selected company’s items.
                            </div>

                        <?php else: ?>
                            <!-- All picked, but not delivered yet -->
                            <span class="badge all-picked-badge">✔ All items picked (Order Picked Up)</span>
                            <form action="view_undeliveredOrders" method="POST" class="mt-2">
                                <input type="hidden" name="deliver_order_id" value="<?= (int)$order['order_id'] ?>">
                                <button type="submit" class="btn btn-outline-success btn-sm">Mark as Delivered</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center text-muted">No undelivered orders.</td></tr>
            <?php endif; ?>
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
