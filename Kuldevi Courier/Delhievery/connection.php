<?php
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "delhievery_2024";
$conn = mysqli_connect($servername, $username, $password, $dbname);
error_reporting(0);
if (!$conn) {
    die("Connection Failed!!!!  " . mysqli_connect_error());
}
