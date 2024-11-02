<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <style>
        body,
        input,
        table,
        .back-a {
            text-align: center;
            font-family: calibri;
        }

        h1 {
            font-size: 50px;
            font-family: Space Grotesk;
            margin-bottom: 0;
            margin-top: 0;
        }

        h1,
        th {
            text-decoration: underline;
        }

        input {
            font-size: 28px;
            margin-bottom: 1%;
        }

        input,
        td,
        th,
        table,
        .back-a {
            font-weight: bolder;
            border: solid 2px black;
            border-collapse: collapse;
        }

        table {
            font-size: 17px;
            margin-bottom: 15px;
        }

        .back-a {
            font-size: 25px;
            color: black;
            text-decoration: none;
            padding: 1px;
            margin-bottom: 5px;
        }

        td {
            max-width: 168px;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }
        
        th {
            color: red;
        }

        .th-total {
            text-decoration: none;
            color: blue;
        }

        .highlight {
            background-color: yellow;
        }

        input,
        .back-a {
            transition: all 0.9s ease;
        }

        input:focus {
            border: solid 6px orangered;
            font-size: 34px;
        }

        .back-a:hover {
            text-decoration: underline;
            color: orangered;
            font-size: 34px;

        }
    </style>
</head>

<body>
    <form method="post" action="delete.php">
        <h1>Kuldevi Courier</h1>
        <input type="text" name="search" id="search" placeholder="Enter Text to Search" autocomplete="off">
        <table align="center" id="consignmenttable">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Date</th>
                    <th>Courier</th>
                    <th>Consignment No</th>
                    <th>Sender's Name</th>
                    <th>Receiver's Name</th>
                    <th>Destination City</th>
                    <th>Pincode</th>
                    <th>Weight(Kg)</th>
                    <th>At Charge</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include("connection.php");
                if (isset($_GET['monthname'])) {
                    $monthname = $_GET['monthname'];
                    $table_name =  $monthname;
                    $backurl = "monthdisplay.php";
                } else {
                    $month_name = date("F");
                    $table_name =  $month_name;
                    $backurl = "display.php";
                }
                $query = "SELECT * FROM `$table_name` ORDER BY date ASC";
                $data = mysqli_query($conn, $query);

                $total_at_charge = 0;
                $srno = 1;

                if (mysqli_num_rows($data) != 0) {
                    while ($result = mysqli_fetch_assoc($data)) {
                        $total_at_charge += $result['at_charge'];

                        echo "<tr>
                            <td>" . $srno++ . "</td>    
                            <td>" . $result['date'] . "</td>
                            <td>" . $result['courier'] . "</td>
                            <td>" . $result['cn_no'] . "</td>
                            <td>" . $result['sndr'] . "</td>
                            <td>" . $result['rcvr'] . "</td>
                            <td>" . $result['city'] . "</td>
                            <td>" . $result['pincode'] . "</td>
                            <td>" . $result['weight'] . " Kg</td>
                            <td>Rs " . $result['at_charge'] . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No records found</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="th-total" colspan="9">Total:-</th>
                    <th class="th-total" id="total_at_charge"><?php echo "Rs " . $total_at_charge; ?></th>
                </tr>
        </table>
        <a class="back-a" href=<?php echo $backurl; ?>>Back</a>



    </form>

    <script src="jquery.js"></script>
    <script>
        $(document).ready(function() {
            $('#search').keyup(function() {
                var query = $(this).val();
                $.ajax({
                    url: 'vdsearch.php',
                    type: 'GET',
                    data: {
                        q: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#consignmenttable tbody').html(data.html);
                        $('#total_at_charge').text(data.total_at_charge);
                    }
                });
            });
        });
    </script>
</body>

</html>