<?php
include("connection.php");
$month_name = date("F"); //get current month
$table_name =   $month_name;
$cnno = $_GET['cn_no']; //get cn_no to delete record
$query =  "DELETE FROM `$table_name` WHERE `cn_no` = '$cnno'";

$data = mysqli_query($conn, $query);

if ($data) {
    echo "<script>window.location.href = 'display.php';
    alert('Data deleted successfully');</script>";
} else {
    $errorMessage = mysqli_error($conn);
    echo "<script>
    alert('Data not deleted. Error: " . addslashes($errorMessage) . "');
    window.location.href = 'display.php';
    </script>";
}
