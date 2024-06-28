<?php
$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "byterage_data";

// Create connection
$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
