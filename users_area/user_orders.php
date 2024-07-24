<?php
// Start the session only if it hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../includes/connect.php';
include_once '../functions/common_functions.php';

// Ensure the session is valid and username is set
if (!isset($_SESSION['username'])) {
    die('User not logged in');
}

$username = $_SESSION['username'];
$get_user_query = "SELECT user_id FROM user_table WHERE username=?";
$stmt = mysqli_prepare($con, $get_user_query);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $user_id);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$user_id) {
    die('User not found');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h3 class="text-center text-success mb-5">All My Orders</h3>
        <table class="table table-bordered table-hover table-striped table-group-divider text-center">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Total Price</th>
                    <th>Total Products</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Confirm</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $get_order_details_query = "
                    SELECT o.order_id, o.total_products, o.order_date, o.order_status, o.product_price
                    FROM user_orders o
                    WHERE o.user_id=?
                    GROUP BY o.order_id";
                    
                $stmt = mysqli_prepare($con, $get_order_details_query);
                mysqli_stmt_bind_param($stmt, 'i', $user_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if (!$result) {
                    die('Query failed: ' . mysqli_error($con));
                }

                while ($row = mysqli_fetch_assoc($result)) {
                    $order_id = $row['order_id'];
                    $total_products = $row['total_products'];
                    $order_date = $row['order_date'];
                    $order_status = $row['order_status'];
                    $total_amount_due = $row['product_price']; // Total price stored in `user_orders`

                    // Check payment status
                    $get_payment_date_query = "
                        SELECT payment_date
                        FROM user_payments
                        WHERE order_id=?";
                    
                    $stmt = mysqli_prepare($con, $get_payment_date_query);
                    mysqli_stmt_bind_param($stmt, 'i', $order_id);
                    mysqli_stmt_execute($stmt);
                    $payment_result = mysqli_stmt_get_result($stmt);

                    // Handle potential null payment_date
                    $payment_date_row = mysqli_fetch_assoc($payment_result);
                    $payment_date = $payment_date_row['payment_date'] ?? null;

                    $order_complete = empty($payment_date) ? 'Incomplete' : 'Complete';

                    echo "<tr>
                        <td>$order_id</td>
                        <td>Rp " . number_format($total_amount_due, 2, ',', '.') . "</td>
                        <td>$total_products</td>
                        <td>$order_date</td>
                        <td>$order_status</td>
                        <td>" . (empty($payment_date) ? "<a href='confirm_payment.php?order_id=$order_id' class='text-decoration-underline'>Confirm</a>" : 'Confirmed') . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
