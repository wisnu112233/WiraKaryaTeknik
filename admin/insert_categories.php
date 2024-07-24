<?php
include('../includes/connect.php');

if (isset($_POST['insert_categ_title'])) {
    $category_title = $_POST['categ_title'];
    $select_query = "SELECT * FROM `categories` WHERE category_title = '$category_title'";
    $select_result = mysqli_query($con, $select_query);
    $numOfResults = mysqli_num_rows($select_result);
    if ($numOfResults > 0) {
        echo "<script>alert('Category is already in Database');</script>";
    } else {
        $insert_query = "INSERT INTO `categories` (category_title) VALUES ('$category_title')";
        $insert_result = mysqli_query($con, $insert_query);
        if ($insert_result) {
            echo "<script>alert('Category has been inserted successfully');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Categories Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 500px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .categ-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .categ-header .sub-title h2 {
            margin: 0;
            color: #007bff;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .form-label {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="categ-header">
            <div class="sub-title">
                <h2>Insert Categories</h2>
            </div>
        </div>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="categ_title" class="form-label">Category Title</label>
                <input type="text" class="form-control" id="categ_title" name="categ_title" placeholder="Insert Category Title" required>
            </div>
            <button type="submit" class="btn btn-primary" name="insert_categ_title">Insert Category</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
