<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tirupati_2024";
$conn = mysqli_connect($servername, $username, $password, $dbname);
error_reporting(0);
if (!$conn) {
    die("Connection Failed!!!!  " . mysqli_connect_error());
}
