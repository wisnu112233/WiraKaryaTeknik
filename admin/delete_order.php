<?php
include('../includes/connect.php');

// Check if the session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure only admins can access this page
if (!isset($_SESSION['admin_username'])) {
    header('location:admin_login.php');
    exit();
}

// Handle delete order request
if (isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']); // Ensure it's an integer

    // Prepare and execute deletion queries
    $queries = [
        "DELETE FROM `user_orders` WHERE order_id = ?",
        "DELETE FROM `orders_pending` WHERE order_id = ?",
        "DELETE FROM `user_payments` WHERE order_id = ?"
    ];

    foreach ($queries as $query) {
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Redirect with success message
    echo "<script>alert('Order deleted'); window.location.href='http://localhost/wkt/admin/index.php';</script>";
} else {
    echo "<script>alert('No order ID provided'); window.location.href='http://localhost/wkt/admin/index.php';</script>";
}

// Close the database connection
mysqli_close($con);
?>
