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
    // Redirect to login page
    header('Location: admin_login.php');
    exit(); // Ensure no further code is executed
}

// Handle delete payment request
if (isset($_GET['delete_payment'])) {
    $delete_id = intval($_GET['delete_payment']); // Ensure it's an integer

    // Use prepared statements to avoid SQL injection
    $delete_payment_query = "DELETE FROM `user_payments` WHERE payment_id = ?";
    $stmt = mysqli_prepare($con, $delete_payment_query);
    mysqli_stmt_bind_param($stmt, "i", $delete_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the admin page after deletion
        header('Location: http://localhost/wkt/admin/index.php');
        exit(); // Ensure no further code is executed after redirection
    } else {
        echo "<script>alert('Error deleting payment'); window.location.href='http://localhost/wkt/admin/index.php';</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// End output buffering and flush
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Payments Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="categ-header">
            <div class="sub-title">
                <span class="shape"></span>
                <h2>All Payments</h2>
            </div>
        </div>
        <div class="table-data">
            <table class="table table-bordered table-hover table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Payment No.</th>
                        <th>Order ID</th>
                        <th>Invoice Number</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Payment Date</th>
                        <th>Receipt</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $get_payment_query = "SELECT * FROM `user_payments`";
                    $get_payment_result = mysqli_query($con, $get_payment_query);
                    $row_count = mysqli_num_rows($get_payment_result);

                    if ($row_count == 0) {
                        echo "<h2 class='text-center text-light p-2 bg-dark'>No payments yet</h2>";
                    } else {
                        $id_number = 1;
                        while ($row = mysqli_fetch_assoc($get_payment_result)) {
                            $payment_id = $row['payment_id'];
                            $order_id = $row['order_id'];
                            $invoice_number = $row['invoice_number'];
                            $amount = $row['amount'];
                            $payment_method = $row['payment_method'];
                            $payment_date = $row['payment_date'];
                            $payment_receipt = isset($row['payment_receipt']) ? $row['payment_receipt'] : 'No receipt';
                            echo "
                            <tr>
                                <td>$id_number</td>
                                <td>$order_id</td>
                                <td>$invoice_number</td>
                                <td>$amount</td>
                                <td>$payment_method</td>
                                <td>$payment_date</td>
                                <td>";
                                    if ($payment_receipt !== 'No receipt') {
                                        echo "<a href='../uploads/$payment_receipt' target='_blank'>View Receipt</a>";
                                    } else {
                                        echo "No receipt";
                                    }
                                echo "</td>
                                <td>
                                    <a href='view_payments.php?delete_payment=$payment_id' class='btn btn-danger' onclick=\"return confirm('Are you sure you want to delete this payment?');\">Delete</a>
                                </td>
                            </tr>
                            ";
                            $id_number++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($con);
?>
