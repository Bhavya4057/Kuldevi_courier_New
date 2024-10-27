<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reciept</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        h1,
        h2,
        .back-a {
            text-align: center;
        }

        h1,
        h2 {
            text-decoration: underline;
        }

        h1 {
            font-size: 50px;
            font-family: 'Bradley Hand ITC';
            margin-top: 15px;
            margin-bottom: 0;
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
            margin-bottom: 15px;
        }

        td,
        table {
            border-collapse: collapse;
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
    <form method="post">
        <h1>Kuldevi Courier</h1>
        <h2>Generate Reciept</h2>
        <table>
            <tr>
                <td>
                    <label for="date">Date:-</label>
                </td>
                <td>
                    <input type="date" name="c_date" id="date" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="courier">Courier:-</label>
                </td>
                <td>
                <input type="text" name="c_courier" id="courier" readonly value="AkashGanga">
                </td>
            </tr>
            <tr>
                <td>
                    <label for="co_no">Consignment No:-</label>
                </td>
                <td>
                    <input type="text" name="c_co_no" id="co_no" placeholder="Enter Consignment Number" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="s_name">Sender's Name:-</label>
                </td>
                <td>
                    <input type="text" name="c_s_name" id="s_name" placeholder="Enter Sender's Name" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="r_name">Reciever's Name:-</label>
                </td>
                <td>
                    <input type="text" name="c_r_name" id="r_name" placeholder="Enter Reciever's Name" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="destination">Destination City:-</label>
                </td>
                <td>
                    <input type="text" name="c_destination" id="destination" placeholder="Enter Destination City" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="pincode">Pincode:-</label>
                </td>
                <td>
                    <input type="text" name="c_pincode" id="pincode" pattern="\d*" title="Enter Valid Pincode" placeholder="Enter pincode" maxlength="6" minlength="6" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="weight">Weight(Kg):-</label>
                </td>
                <td>
                    <input type="text" name="c_weight" id="weight" pattern="^\d+(\.\d{1,2})?$" title="Enter Valid Weight" placeholder="Enter Weight in Kg" required>
                </td>
            </tr>

            <tr>
                <td>
                    <label for="shpr_amt">Shipper Amount:-</label>
                </td>
                <td>
                    <input type="text" name="c_shpr_amt" id="shpr_amt" placeholder="Enter Shipper Amount" pattern="\d*" title="Enter Valid Shipper Amount" required>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <button type="submit" name="submit">Generate</button>&nbsp;&nbsp;&nbsp;&nbsp;<button type="reset">Reset</button>
                </td>
            </tr>
        </table>
        <a class="back-a" href="../index.php">Back</a>

        <?php
      
        if (isset($_POST['submit'])) {
            $date = $_POST['c_date'];
            $courier = $_POST['c_courier'];
            $co_no = $_POST['c_co_no'];
            $s_name = strtoupper($_POST['c_s_name']);
            $r_name = strtoupper($_POST['c_r_name']);
            $destination = strtoupper($_POST['c_destination']);
            $pincode = $_POST['c_pincode'];
            $weight = $_POST['c_weight'];
            $shpr_amt = $_POST['c_shpr_amt'];
            $f_date = date("d-m-Y", strtotime($date));
            $TrackUrl="https://akashganga.info/Tracking.aspx?AWB=" . $co_no;

            $RecieptUrl = "reciept.php?date=" . $f_date .
                            "&courier=" . $courier .
                            "&cn_no=" . $co_no .
                            "&sndr=" . $s_name .
                            "&rcvr=" . $r_name .
                            "&city=" . $destination .
                            "&pincode=" . $pincode .
                            "&weight=" . $weight .
                            "&trackurl=" . $TrackUrl .
                            "&shpr_amt=" . $shpr_amt;

            echo"<script>
            window.location.href = '".$RecieptUrl."';
            </script>";
        }
        ?>


    </form>
</body>

</html>