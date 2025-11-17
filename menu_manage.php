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

if($_SERVER['REQUEST_METHOD']=='POST'){
    $name = $_POST['name']; $desc = $_POST['description']; $price = floatval($_POST['price']);
    $stmt = $conn->prepare("INSERT INTO menu_items (name,description,price,is_available) VALUES (?,?,?,1)");
    $stmt->bind_param('ssd',$name,$desc,$price);
    $stmt->execute();
    echo "<p>Item added.</p>";
}
?>
<div class="card">
  <h2>Manage Menu</h2>
  <form method="POST">
    <div class="form-group"><input type="text" name="name" placeholder="Item name" required></div>
    <div class="form-group"><input type="text" name="description" placeholder="Description"></div>
    <div class="form-group"><input type="text" name="price" placeholder="Price" required></div>
    <button type="submit">Add Item</button>
  </form>
  <hr>
  <h3>Existing items</h3>
  <?php
  $r = $conn->query("SELECT * FROM menu_items ORDER BY created_at DESC");
  while($it = $r->fetch_assoc()){
      echo "<div class='menu-item'><div><strong>".htmlspecialchars($it['name'])."</strong><br><small>Rs ".number_format($it['price'],2)."</small></div>";
      echo "<div><form method='post' action=''><input type='hidden' name='toggle_id' value='".$it['item_id']."'><button formaction='?toggle=".$it['item_id']."' class='secondary'>Toggle</button></form></div></div>";
  }
  ?>
</div>
<?php include "../includes/footer.php"; ?>
