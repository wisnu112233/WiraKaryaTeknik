<?php
include("../includes/connect.php");
include("../functions/common_functions.php");
$id=$_GET['id'];
$query="UPDATE user_orders SET status='Produk Diterima' WHERE order_id='$id'";
$result=mysqli_query($db,$query); 

echo "<script>location='order.php';</script>";
echo "Ba";
?>