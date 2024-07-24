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

// Handle delete order request
if (isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']); // Ensure it's an integer

    // Prepare and execute deletion queries
    $delete_order_query = "DELETE FROM user_orders WHERE order_id = ?";
    $stmt = mysqli_prepare($con, $delete_order_query);
    mysqli_stmt_bind_param($stmt, "i", $order_id);
    $success = mysqli_stmt_execute($stmt);
    
    if ($success) {
        // Also delete related records from orders_pending and user_payments if necessary
        $delete_order_details_query = "DELETE FROM orders_pending WHERE order_id = ?";
        $stmt = mysqli_prepare($con, $delete_order_details_query);
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);

        $delete_user_payments_query = "DELETE FROM user_payments WHERE order_id = ?";
        $stmt = mysqli_prepare($con, $delete_user_payments_query);
        mysqli_stmt_bind_param($stmt, "i", $order_id);
        mysqli_stmt_execute($stmt);

        // Redirect to the list orders page after deletion
        header('Location: list_orders.php');
        exit();
    } else {
        echo "<script>alert('Error deleting order. Please try again.'); window.location.href='list_orders.php';</script>";
    }
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
    <title>View Orders Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-data {
            margin-top: 20px;
        }
        .modal-content {
            width: 80%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="categ-header">
            <div class="sub-title">
                <span class="shape"></span>
                <h2>All Orders</h2>
            </div>
        </div>
        <div class="table-data">
            <table class="table table-bordered table-hover table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Order No.</th>
                        <th>Due Amount</th>
                        <th>Total Products</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $get_order_query = "
                        SELECT o.order_id, o.total_products, o.order_date, o.order_status, o.product_price
                        FROM user_orders o
                    ";
                    $get_order_result = mysqli_query($con, $get_order_query);

                    if (!$get_order_result) {
                        die("Database query failed: " . mysqli_error($con));
                    }

                    $row_count = mysqli_num_rows($get_order_result);

                    if ($row_count == 0) {
                        echo "<h2 class='text-center text-light p-2 bg-dark'>No orders yet</h2>";
                    } else {
                        $id_number = 1;
                        while ($row = mysqli_fetch_assoc($get_order_result)) {
                            $order_id = $row['order_id'];
                            $total_products = $row['total_products'];
                            $order_date = $row['order_date'];
                            $order_status = $row['order_status'];
                            $product_price = $row['product_price'];

                            // Calculate amount due
                            $amount_due = $product_price;

                            // Check payment status
                            $get_payment_date_query = "
                                SELECT payment_date
                                FROM user_payments
                                WHERE order_id = ?
                            ";
                            $stmt = mysqli_prepare($con, $get_payment_date_query);
                            mysqli_stmt_bind_param($stmt, 'i', $order_id);
                            mysqli_stmt_execute($stmt);
                            $payment_result = mysqli_stmt_get_result($stmt);

                            // Handle potential null payment_date
                            $payment_date_row = mysqli_fetch_assoc($payment_result);
                            $payment_date = $payment_date_row['payment_date'] ?? '';

                            $payment_status = empty($payment_date) ? 'unpaid' : 'paid';

                            echo "
                            <tr>
                                <td>$order_id</td>
                                <td>$id_number</td>
                                <td>Rp " . number_format($amount_due, 2, ',', '.') . "</td>
                                <td>$total_products</td>
                                <td>$order_date</td>
                                <td>
                                    <form action='update_order.php' method='POST'>
                                        <input type='hidden' name='order_id' value='$order_id'>
                                        <select name='order_status' class='form-select' onchange='this.form.submit()'>
                                            <option value='Belum Dibayar'" . ($order_status == 'Belum Dibayar' ? ' selected' : '') . ">Belum Dibayar</option>
                                            <option value='Sudah Dibayar'" . ($order_status == 'Sudah Dibayar' ? ' selected' : '') . ">Sudah Dibayar</option>
                                            <option value='Produk Dikirim'" . ($order_status == 'Produk Dikirim' ? ' selected' : '') . ">Produk Dikirim</option>
                                            <option value='Produk Diterima'" . ($order_status == 'Produk Diterima' ? ' selected' : '') . ">Produk Diterima</option>
                                            <option value='Menyiapkan Produk'" . ($order_status == 'Menyiapkan Produk' ? ' selected' : '') . ">Menyiapkan Produk</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <form action='update_payment_status.php' method='POST'>
                                        <input type='hidden' name='order_id' value='$order_id'>
                                        <select name='payment_status' class='form-select' onchange='this.form.submit()'>
                                            <option value='paid'" . ($payment_status == 'paid' ? ' selected' : '') . ">Paid</option>
                                            <option value='unpaid'" . ($payment_status == 'unpaid' ? ' selected' : '') . ">Unpaid</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href='#' data-bs-toggle='modal' data-bs-target='#deleteModal_$order_id'>
                                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'>
                                            <path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/>
                                        </svg>
                                    </a>
                                    <!-- Modal -->
                                    <div class='modal fade' id='deleteModal_$order_id' tabindex='-1' aria-labelledby='deleteModal_$order_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-body'>
                                                    <div class='d-flex flex-column gap-3 align-items-center text-center'>
                                                        <span>
                                                            <svg width='50' height='50' viewBox='0 0 60 60' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                                <path fill-rule='evenodd' clip-rule='evenodd' d='M30 0C13.4316 0 0 13.4316 0 30C0 46.5684 13.4316 60 30 60C46.5684 60 60 46.5684 60 30C60 13.4316 46.5684 0 30 0ZM44.2284 43.3137L43.3137 44.2284L30 30.915L16.6863 44.2284L15.7716 43.3137L29.0849 30L15.7716 16.6863L16.6863 15.7716L30 29.0849L43.3137 15.7716L44.2284 16.6863L30.915 30L44.2284 43.3137Z' fill='#DC3545'/>
                                                            </svg>
                                                        </span>
                                                        <h5 class='modal-title' id='deleteModal_$order_id.Label'>Are you sure you want to delete this order?</h5>
                                                        <form method='POST' action=''>
                                                            <input type='hidden' name='order_id' value='$order_id'>
                                                            <button type='submit' class='btn btn-danger'>Yes, Delete</button>
                                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                            $id_number++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
