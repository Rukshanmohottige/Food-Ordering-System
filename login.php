<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include "../config/database.php";

    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $hash = hash('sha256', $pass);

    $stmt = $conn->prepare("
        SELECT user_id, name, user_role 
        FROM users 
        WHERE email=? AND password=? AND user_role IN ('admin','staff')
        LIMIT 1
    ");

    $stmt->bind_param("ss", $email, $hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $u = $result->fetch_assoc();

        $_SESSION['user_id']   = $u['user_id'];
        $_SESSION['user_name'] = $u['name'];
        $_SESSION['user_role'] = $u['user_role'];

        header("Location: /food_order_system/admin/dashboard.php");
        exit;
    } else {
        $err = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/food_order_system/assets/css/style.css">
</head>
<body>

<div class="container">
  <div class="card">
    <h2>Admin Login</h2>

    <?php if (!empty($err)) echo "<p style='color:red'>$err</p>"; ?>

    <form method="POST">
      <input type="email" name="email" placeholder="Enter Email" required>
      <input type="password" name="password" placeholder="Enter Password" required>
      <button type="submit">Login</button>
    </form>

  </div>
</div>

</body>
</html>
