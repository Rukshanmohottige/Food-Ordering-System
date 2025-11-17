<?php
session_start();
include "../config/database.php";
$email = trim($_POST['email'] ?? '');
$pass = $_POST['password'] ?? '';
if(!$email || !$pass) die("Missing");
$hash = hash('sha256',$pass);
$stmt = $conn->prepare("SELECT user_id,name,user_role FROM users WHERE email=? AND password=? LIMIT 1");
$stmt->bind_param('ss',$email,$hash);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows==1){
    $u = $res->fetch_assoc();
    $_SESSION['user_id']   = $u['user_id'];
    $_SESSION['user_name'] = $u['name'];
    $_SESSION['user_role'] = $u['user_role'];

    header("Location: /food_order_system/public/index.php");
}else{
    header("Location: /food_order_system/public/login.php?error=1");
}
?>
