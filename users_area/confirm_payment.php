<?php
include("../includes/connect.php");
include("../functions/common_functions.php");
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header('location:user_login.php');
    exit();
}

// Create uploads directory if it doesn't exist
$upload_dir = '../uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Check if order_id is provided
if (isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
} else {
    exit('Order ID not available.');
}

// Retrieve order information from the database
$select_order_query = "SELECT * FROM user_orders WHERE order_id = ?";
$stmt = mysqli_prepare($con, $select_order_query);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$select_order_result = mysqli_stmt_get_result($stmt);
$row_fetch = mysqli_fetch_assoc($select_order_result);

// Ensure order is found
if (!$row_fetch) {
    exit('Order not found.');
}

// Fetch total amount from the `user_orders` table
$total_price = $row_fetch['product_price'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <style>
        .banner .img {
            width: 100%;
            height: 250px;
            background-image: url('user_images/bg1.jpg');
            padding: 0;
            margin: 0;
        }
        .img .box {
            height: 250px;
            background-color: rgba(41, 41, 41, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            padding-top: 70px;
        }
        .box a {
            color: #0066FF;
        }
        .box a:hover {
            text-decoration: none;
            color: rgb(6, 87, 209);
        }
    </style>
</head>
<body>
    <!-- Navigation and Profile Sections -->
    <!-- Navigation content here -->
    <!-- Payment Confirmation Section -->
    <div class="banner mb-5">
        <div class="container-fluid img">
            <div class="container-fluid box">
                <h3>PAYMENT CONFIRMATION</h3>
                <p>Home > <a href="confirm_payment.php"> Payment Confirmation</a></p>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <h2 class="text-center">Confirm Your Payment</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-outline mb-4 text-center w-50 m-auto">
                <input type="text" class="form-control w-50 m-auto" name="invoice_number" value="<?php echo htmlspecialchars($row_fetch['invoice_number']); ?>" readonly>
            </div>
            <div class="form-outline mb-4 text-center w-50 m-auto">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control w-50 m-auto" name="amount" value="<?php echo htmlspecialchars(number_format($total_price, 2, ',', '.')); ?>" readonly>
            </div>
            <div class="form-outline mb-4 text-center w-50 m-auto">
                <select name="payment_mode" class="form-select w-50 m-auto">
                    <option value="">Select Payment Mode</option>
                    <option value="Bank Mandiri">Bank Mandiri</option>
                    <option value="BRI">BRI</option>
                    <option value="BTN">BTN</option>
                </select>
            </div>
            <div class="form-outline mb-4 text-center w-50 m-auto">
                <label for="receipt" class="form-label">Upload Payment Receipt</label>
                <input type="file" class="form-control w-50 m-auto" name="receipt" required>
            </div>
            <div class="form-outline mb-4 text-center w-50 m-auto">
                <input type="submit" class="btn btn-primary mb-3 px-3" name="confirm_payment" value="Confirm">
            </div>
        </form>
    </div>
    <!-- Footer -->
    <!-- Footer content here -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Handle payment confirmation
if (isset($_POST['confirm_payment'])) {
    $invoice_number = $_POST['invoice_number'];
    $amount_due = $total_price; // Use fetched `total_price`
    $payment_mode = $_POST['payment_mode'];
    $receipt = $_FILES['receipt']['name'];
    $receipt_tmp = $_FILES['receipt']['tmp_name'];

    // Move uploaded file
    if (move_uploaded_file($receipt_tmp, $upload_dir . $receipt)) {
        // Insert payment details into user_payments table
        $insert_payment_query = "INSERT INTO user_payments (order_id, invoice_number, amount, payment_method, payment_receipt, payment_date) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($con, $insert_payment_query);
        mysqli_stmt_bind_param($stmt, "issss", $order_id, $invoice_number, $amount_due, $payment_mode, $receipt);
        if (mysqli_stmt_execute($stmt)) {
            // Update order status
            $update_order_query = "UPDATE user_orders SET payment_mode=?, payment_receipt=?, amount_due=?, order_status='Complete' WHERE order_id=?";
            $stmt = mysqli_prepare($con, $update_order_query);
            mysqli_stmt_bind_param($stmt, "sssi", $payment_mode, $receipt, $amount_due, $order_id);
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Payment has been confirmed'); window.location.href='profile.php?my_orders'</script>";
            } else {
                echo "<script>alert('Error updating order status');</script>";
            }
        } else {
            echo "<script>alert('Error inserting payment details');</script>";
        }
    } else {
        echo "<script>alert('Error uploading receipt');</script>";
    }
}
?>
