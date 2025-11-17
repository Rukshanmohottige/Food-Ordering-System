<?php
include "../includes/auth.php";
session_start();
ensure_logged_in();
if(($_SESSION['user_role'] ?? '')!='admin' && ($_SESSION['user_role'] ?? '')!='staff'){
    header("Location: /food_order_system/admin/login.php");
    exit;
}
include "../config/database.php";
include "../includes/header.php";

if(isset($_GET['update']) && isset($_GET['status']) ){
    $oid = intval($_GET['update']);
    $status = $_GET['status'];
    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE order_id=?");
    $stmt->bind_param('si',$status,$oid);
    $stmt->execute();
    echo "<p>Updated.</p>";
}

$res = $conn->query("SELECT o.*, u.name FROM orders o JOIN users u ON o.user_id=u.user_id ORDER BY o.order_time DESC");
?>
<div class="card"><h2>Manage Orders</h2>
<?php while($o=$res->fetch_assoc()): ?>
  <div class="menu-item">
    <div>
      <strong>Order #<?php echo $o['order_id']; ?></strong><br>
      <small><?php echo htmlspecialchars($o['name']); ?> — <?php echo $o['order_time']; ?></small><br>
      <small>Status: <?php echo $o['status']; ?></small>
    </div>
    <div>
      <a href="?update=<?php echo $o['order_id']; ?>&status=preparing">Preparing</a> |
      <a href="?update=<?php echo $o['order_id']; ?>&status=ready">Ready</a> |
      <a href="?update=<?php echo $o['order_id']; ?>&status=completed">Complete</a>
    </div>
  </div>
<?php endwhile; ?>
</div>
<?php include "../includes/footer.php"; ?>
