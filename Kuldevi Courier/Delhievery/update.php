<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Form</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        h1 {
            font-size: 50px;
            font-family: 'Bradley Hand ITC';
            margin-top: 15px;
            margin-bottom: 0;
        }

        h1,
        h2 {
            text-decoration: underline;
        }

        h1,
        h2,
        .back-a {
            text-align: center;
        }

        h2 {
            font-family: 'Space Grotesk', sans-serif;
            margin-top: 0;
            margin-bottom: 1%;
        }

        input,
        button,
        select,
        option,
        h2,
        .back-a,
        td {
            font-size: 25px;
        }

        .back-a {
            font-weight: bolder;
            border: solid 2px black;
            color: black;
            text-decoration: none;
            padding: 1px;
            margin-bottom: 5px;
            margin-left: 45%;
        }

        table {
            border-collapse: collapse;
            border: solid 5px black;
            margin-bottom: 15px;
        }

        td {
            border: solid 5px black;
        }

        input,
        select,
        button,
        .back-a {
            text-decoration: none;
            transition: all 0.9s ease;
        }

        input:hover,
        select:hover {
            border: solid 6px orangered;
            font-size: 34px;
        }

        .back-a {
            color: black;
        }

        button:hover,
        .back-a:hover {
            text-decoration: underline;
            color: orangered;
            font-size: 34px;
        }

        button {
            color: darkgoldenrod;
        }
    </style>
</head>

<body>
    <form method="post" action="update.php">
        <h1>Kuldevi Courier</h1>
        <h2>Update Consignment</h2>
        <table>
            <tr>
                <td>
                    <label for="date">Date:-</label>
                </td>
                <td>
                    <input type="date" name="c_date" id="date" value="<?php echo $_POST['date']; ?>" required>
                    <input type="hidden" name="cnno" value="<?php echo $_POST['cn_no']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="courier">Courier:-</label>
                </td>
                <td>
                    <select name="c_courier" id="Courier" required>
                        <option value="" disabled>Select</option>
                        <option value="Delhievery" <?php if ($_POST['courier'] == "Delhievery") echo 'selected'; ?>>Delhievery</option>
                        <option value="DTDC" <?php if ($_POST['courier'] == "DTDC") echo 'selected'; ?>>DTDC</option>
                        <option value="Mahavir" <?php if ($_POST['courier'] == "Mahavir") echo 'selected'; ?>>Mahavir</option>
                        <option value="EcomExpress" <?php if ($_POST['courier'] == "EcomExpress") echo 'selected'; ?>>EcomExpress</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="co_no">Consignment No:-</label>
                </td>
                <td>
                    <input type="text" name="c_co_no" id="co_no" value="<?php echo $_POST['cn_no']; ?>" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="s_name">Sender's Name:-</label>
                </td>
                <td>
                    <input type="text" name="c_s_name" id="s_name" placeholder="Enter Sender's Name" required value="<?php echo $_POST['sndr']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="r_name">Reciever's Name:-</label>
                </td>
                <td>
                    <input type="text" name="c_r_name" id="r_name" placeholder="Enter Reciever's Name" required value="<?php echo $_POST['rcvr']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="destination">Destination City:-</label>
                </td>
                <td>
                    <input type="text" name="c_destination" id="destination" placeholder="Enter Destination City" required value="<?php echo $_POST['city']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="pincode">Pincode:-</label>
                </td>
                <td>
                    <input type="text" name="c_pincode" id="pincode" pattern="\d*" title="Enter Valid Pincode" placeholder="Enter pincode" maxlength="6" minlength="6" required value="<?php echo $_POST['pincode']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="weight">Weight(Kg):-</label>
                </td>
                <td>
                    <input type="text" name="c_weight" id="weight" placeholder="Enter Weight in Kg" pattern="^\d+(\.\d{1,2})?$" title="Enter Valid Weight" required value="<?php echo $_POST['weight']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="at_charge">AT Charge:-</label>
                </td>
                <td>
                    <input type="text" name="c_at_charge" id="at_charge" placeholder="Enter AT Charge" pattern="\d*" title="Enter Valid At Charge" required value="<?php echo $_POST['at_charge']; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="shpr_amt">Shipper Amount:-</label>
                </td>
                <td>
                    <input type="text" name="c_shpr_amt" id="shpr_amt" placeholder="Enter Shipper Amount" pattern="\d*" title="Enter Valid Shipper Amount" required value="<?php echo $_POST['shpr_amt']; ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button type="submit" name="submit">Submit</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="reset">Reset</button>
                </td>
            </tr>
        </table>
        <a class="back-a" href="display.php">Back</a>


        <?php
        include("connection.php");
        $month_name = date("F");
        $table_name =  $month_name;

        if (isset($_POST['submit'])) {
            $date = $_POST['c_date'];
            $courier = $_POST['c_courier'];
            $co_no = $_POST['c_co_no'];
            $s_name = strtoupper($_POST['c_s_name']);
            $r_name = strtoupper($_POST['c_r_name']);
            $destination = strtoupper($_POST['c_destination']);
            $pincode = $_POST['c_pincode'];
            $weight = $_POST['c_weight'];
            $at_charge = $_POST['c_at_charge'];
            $shpr_amt = $_POST['c_shpr_amt'];
            $cnno = $_POST['cnno'];
            $f_date = date("d-m-Y", strtotime($date));

            // Only check if the entered consignment number is different from the original
            if ($co_no != $cnno) {
                // Check if the new consignment number already exists in the table
                $checkquery = "SELECT * FROM `$table_name` WHERE `cn_no`='$co_no'";
                $cnnoexits = mysqli_query($conn, $checkquery);

                // If the consignment number already exists, show an alert
                if (mysqli_num_rows($cnnoexits) > 0) {
                    echo "<script>
            alert('Consignment number already exists. कंसाइनमेंट नंबर पहले से मौजूद है');
            window.location.href = 'display.php';
            </script>";
                } else {
                    // Proceed with the update if no duplicate consignment number exists
                    $query = "UPDATE `$table_name` SET `date` = '$f_date', `courier` = '$courier', `cn_no` = '$co_no', 
                      `sndr` = '$s_name', `rcvr` = '$r_name', `city` = '$destination', `pincode` = '$pincode', 
                      `weight` = '$weight', `at_charge` = '$at_charge', `shpr_amt` = '$shpr_amt' WHERE `cn_no` = '$cnno'";
                    $data = mysqli_query($conn, $query);

                    if ($data) {
                        echo "<script>
                alert('Data Updated Successfully');
                window.location.href = 'display.php';
                </script>";
                    } else {
                        $errorMessage = mysqli_error($conn);
                        echo "<script>
                alert('Data Not Updated. Error: " . addslashes($errorMessage) . "');
                window.location.href = 'display.php';
                </script>";
                    }
                }
            } else {
                // If consignment number is the same, proceed with the update directly
                $query = "UPDATE `$table_name` SET `date` = '$f_date', `courier` = '$courier', `sndr` = '$s_name', 
                  `rcvr` = '$r_name', `city` = '$destination', `pincode` = '$pincode', `weight` = '$weight', 
                  `at_charge` = '$at_charge', `shpr_amt` = '$shpr_amt' WHERE `cn_no` = '$cnno'";
                $data = mysqli_query($conn, $query);

                if ($data) {
                    echo "<script>
            alert('Data Updated Successfully');
            window.location.href = 'display.php';
            </script>";
                } else {
                    $errorMessage = mysqli_error($conn);
                    echo "<script>
            alert('Data Not Updated. Error: " . addslashes($errorMessage) . "');
            window.location.href = 'display.php';
            </script>";
                }
            }
        }
        ?>


    </form>
</body>

</html>