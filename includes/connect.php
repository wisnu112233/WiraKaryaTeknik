<?php
// Database connection settings
$host = '127.0.0.1:3307'; // or your database host
$username = 'root'; // your database username
$password = ''; // your database password
$database = 'ecommerce_1'; // your database name

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>