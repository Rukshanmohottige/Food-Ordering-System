<?php
session_start();
session_unset();
session_destroy();
header("Location: /food_order_system/public/index.php");
exit;
?>
