<?php
include "../includes/auth.php";
ensure_logged_in();
include "../config/database.php";
include "../includes/header.php";
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM orders WHERE user_id=? ORDER BY order_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i',$user_id);
$stmt->execute();
$res = $stmt->get_result();
?>
<div class="card"><h2>My Orders</h2>
  <?php while($o = $res->fetch_assoc()): ?>
    <div class="menu-item">
      <div>
        <strong>Order #<?php echo $o['order_id']; ?></strong><br>
        <small><?php echo $o['order_time']; ?></small><br>
        <small>Status: <?php echo $o['status']; ?></small>
      </div>
      <div><a href="/food_order_system/public/order.php?id=<?php echo $o['order_id']; ?>">View</a></div>
    </div>
  <?php endwhile; ?>
</div>
<?php include "../includes/footer.php"; ?>
