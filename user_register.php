<?php
include "../config/database.php";
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass = $_POST['password'] ?? '';

if(!$name || !$email || !$pass){
    die("Missing fields");
}
$hash = hash('sha256', $pass);
$stmt = $conn->prepare("INSERT INTO users (name,email,password,user_role) VALUES (?,?,?,'student')");
$stmt->bind_param('sss',$name,$email,$hash);
if($stmt->execute()){
    header("Location: /food_order_system/public/login.php?registered=1");
}else{
    die("Error: " . $conn->error);
}
?>
