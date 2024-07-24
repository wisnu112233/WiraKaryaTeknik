<?php
// Start the session only if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('../includes/connect.php');
include('../functions/common_functions.php');

// Ensure the session is valid and username is set
if (!isset($_SESSION['username'])) {
    die('User not logged in');
}

$username = $_SESSION['username'];
$get_user_query = "SELECT user_id FROM user_table WHERE username='$username'";
$get_user_result = mysqli_query($con, $get_user_query);

if (!$get_user_result) {
    die('Query failed: ' . mysqli_error($con));
}

$row_user_data = mysqli_fetch_array($get_user_result);
$user_id = $row_user_data['user_id'];

// Getting total items and total price of all items
$get_ip_address = getIPAddress();
$total_price = 0;
$total_products = 0;
$invoice_number = mt_rand();
$status = "pending";

// Fetch cart details
$cart_query = "SELECT * FROM `card_details` WHERE ip_address = '$get_ip_address'";
$cart_result = mysqli_query($con, $cart_query);
$count_products = mysqli_num_rows($cart_result);

if ($count_products > 0) {
    while ($row_price = mysqli_fetch_array($cart_result)) {
        $product_id = $row_price['product_id'];
        $product_quantity = $row_price['quantity'];
        
        $select_product = "SELECT * FROM `products` WHERE product_id = $product_id";
        $select_product_result = mysqli_query($con, $select_product);
        
        if ($select_product_result) {
            while ($row_product_price = mysqli_fetch_array($select_product_result)) {
                $product_price = $row_product_price['product_price'];
                $product_total = $product_price * $product_quantity;
                $total_price += $product_total;
                $total_products += $product_quantity;
            }
        }
        
        // Insert into orders_pending
        $insert_pending_order_query = "INSERT INTO `orders_pending` (user_id, invoice_number, product_id, quantity, order_status) VALUES ('$user_id', '$invoice_number', '$product_id', '$product_quantity', '$status')";
        mysqli_query($con, $insert_pending_order_query);
    }

    // Insert into user_orders
    $insert_order_query = "INSERT INTO `user_orders` (user_id, product_price, invoice_number, total_products, order_date, order_status) VALUES ('$user_id', '$total_price', '$invoice_number', '$total_products', NOW(), '$status')";
    $insert_order_result = mysqli_query($con, $insert_order_query);

    if ($insert_order_result) {
        // Clear the cart
        $empty_cart = "DELETE FROM `card_details` WHERE ip_address = '$get_ip_address'";
        mysqli_query($con, $empty_cart);

        echo "<script>window.alert('Orders are submitted successfully');</script>";
        echo "<script>window.open('profile.php', '_self');</script>";
    } else {
        die('Failed to insert order: ' . mysqli_error($con));
    }
} else {
    echo "<script>window.alert('Your cart is empty');</script>";
    echo "<script>window.open('profile.php', '_self');</script>";
}
?>
