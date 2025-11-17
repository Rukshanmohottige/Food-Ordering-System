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

// show pending orders summary
$res = $conn->query("SELECT COUNT(*) AS cnt FROM orders WHERE status='pending'");
$pending = $res->fetch_assoc()['cnt'];
?>
<div class="card"><h2>Admin Dashboard</h2>
<p>Pending orders: <?php echo $pending; ?></p>
<p><a href="menu_manage.php">Manage Menu</a> | <a href="orders_manage.php">Manage Orders</a></p>
</div>
<?php include "../includes/footer.php"; ?>
