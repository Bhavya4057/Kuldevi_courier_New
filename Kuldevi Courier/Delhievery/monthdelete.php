<?php
include("connection.php");
$table_name = $_POST['monthname'];
$cnno = $_POST['cn_no']; //get cn_no to delete record
$query =  "DELETE FROM `$table_name` WHERE `cn_no` = '$cnno'";

$data = mysqli_query($conn, $query);

if ($data) {
    echo "<script>window.location.href = 'monthdisplay.php';
    alert('Data deleted successfully');</script>";
} else {
    $errorMessage = mysqli_error($conn);
    echo "<script>
    alert('Data not deleted. Error: " . addslashes($errorMessage) . "');
    window.location.href = 'monthdisplay.php';
    </script>";
}
