<?php
// Start output buffering
ob_start();

include('../includes/connect.php');

// Check if the session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure only admins can access this page
if (!isset($_SESSION['admin_username'])) {
    header('Location: admin_login.php');
    exit(); // Ensure no further code is executed
}

// Handle update order status request
if (isset($_POST['order_id']) && isset($_POST['order_status'])) {
    $order_id = intval($_POST['order_id']); // Ensure it's an integer
    $order_status = mysqli_real_escape_string($con, $_POST['order_status']); // Escape for safety

    // Prepare and execute update query
    $update_order_status_query = "UPDATE user_orders SET order_status = ? WHERE order_id = ?";
    $stmt = mysqli_prepare($con, $update_order_status_query);
    mysqli_stmt_bind_param($stmt, "si", $order_status, $order_id);
    $success = mysqli_stmt_execute($stmt);
    
    if ($success) {
        // Redirect to the admin page after updating
        header('Location: http://localhost/wkt/admin/index.php');
        exit(); // Ensure no further code is executed
    } else {
        echo "<script>alert('Error updating order status. Please try again.'); window.location.href='http://localhost/wkt/admin/index.php';</script>";
    }
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($con);

// End output buffering and flush
ob_end_flush();
?>
