<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Categories Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 900px;
            margin-top: 20px;
        }
        .categ-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .categ-header .sub-title h2 {
            margin: 0;
            color: #007bff;
        }
        .btns {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="buttons mb-3">
            <a href="./insert_categories.php" class="btn btn-outline-primary">Insert Categories</a>
        </div>
        <div class="categ-header">
            <div class="sub-title">
                <h2>All Categories</h2>
            </div>
        </div>
        <div class="table-data">
            <table class="table table-bordered table-hover table-striped text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Category No.</th>
                        <th>Category Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        include('../includes/connect.php');
                        $get_category_query = "SELECT * FROM `categories`";
                        $get_category_result = mysqli_query($con, $get_category_query);
                        $id_number = 1;
                        while ($row_fetch_categories = mysqli_fetch_array($get_category_result)) {
                            $category_id = $row_fetch_categories['category_id'];
                            $category_title = $row_fetch_categories['category_title'];
                            echo "
                            <tr>
                                <td>$id_number</td>
                                <td>$category_title</td>
                                <td>
                                    <a href='index.php?edit_category=$category_id'>
                                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><path d='M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z'/></svg>
                                    </a>
                                </td>
                                <td>
                                    <a href='#' data-bs-toggle='modal' data-bs-target='#deleteModal_$category_id'>
                                        <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 448 512'><path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z'/></svg>
                                    </a>
                                    <!-- Modal -->
                                    <div class='modal fade' id='deleteModal_$category_id' tabindex='-1' aria-labelledby='deleteModal_$category_id.Label' aria-hidden='true'>
                                        <div class='modal-dialog modal-dialog-centered'>
                                            <div class='modal-content'>
                                                <div class='modal-body text-center'>
                                                    <h5 class='modal-title'>Are you sure?</h5>
                                                    <p>Do you really want to delete this category? This process cannot be undone.</p>
                                                    <div class='d-flex justify-content-center'>
                                                        <a href='index.php?delete_category=$category_id' class='btn btn-danger mx-2'>Delete</a>
                                                        <button type='button' class='btn btn-secondary mx-2' data-bs-dismiss='modal'>Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal  -->
                                </td>
                            </tr>
                            ";
                            $id_number++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>
</html>
