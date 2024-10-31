<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consignment Details</title>
    <style>
        body,
        .insert-a,
        .back-a,
        .input,
        table {
            text-align: center;
        }

        h1,
        th {
            text-decoration: underline;
        }

        h1 {
            font-size: 50px;
            font-family: Space Grotesk;
            margin-bottom: 0;
            margin-top: 0;
        }

        .insert-a,
        .back-a,
        .input,
        table,
        td,
        th {
            font-weight: bolder;
            border: solid 2px black;
        }

        .insert-a,
        .back-a,
        .input {
            font-size: 25px;
            padding: 1px;
            margin-bottom: 1%;
        }

        .insert-a {
            color: blue;
        }



        table {
            border-collapse: collapse;
            font-size: 18px;
            font-family: calibri;
            table-layout: fixed;
        }

        th {
            color: red;
            font-size: 16px;
        }

        td {
            max-width: 168px;
            word-wrap: break-word;
            white-space: normal;
            overflow-wrap: break-word;
        }




        .highlight {
            background-color: yellow;
        }


        .monthdisplay-a,
        .viewbooking-a,
        .getdetails-a {
            color: darkcyan;
        }

        .insert-a,
        .back-a,
        .input,
        .monthdisplay-a,
        .viewbooking-a,
        .getdetails-a {
            text-decoration: none;
            transition: all 0.9s ease;
        }

        .insert-a:hover,
        .back-a,
        .monthdisplay-a:hover,
        .viewbooking-a:hover,
        .getdetails-a:hover {
            text-decoration: underline;
            color: orangered;
            font-size: 24.5px;
        }

        .insert-a:hover,
        .input:hover {
            font-size: 34px;
        }

        .input:hover {
            border: solid 6px orangered;
        }

        /* Custom dropdown button */
        .dropbtn {
            color: darkgreen;
            font-size: 15px;
            border: none;
            cursor: pointer;
            font-weight: bolder;
            transition: all 0.9s ease;

        }

        /* Dropdown container */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        /* Dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 75px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: darkorange;
            font-size: 18px;
            padding: 5px;
            text-decoration: none;
            display: block;
            transition: all 0.9s ease;
        }

        /* Change color of links on hover */
        .dropdown-content a:hover {
            color: orangered;
            text-decoration: underline;
            font-size: 21px;

        }

        /* Show the dropdown content on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Change color of button on hover */
        .dropdown:hover .dropbtn {
            text-decoration: underline;
        }

        .back-a {
            color: black;
        }
    </style>
</head>

<body>
    <form method="post">
        <h1>Kuldevi Courier</h1>
        <input type="text" class="input" name="search" id="search" placeholder="Enter Text to Search" autocomplete="off">
        <a class="insert-a" href="insert.php">Add New Consignment</a>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include("connection.php");
                $TrackUrl = "";
                $month_name = date("F");
                $table_name =   $month_name;
                //Check If current month table exists
                $table_check_query = "SHOW TABLES LIKE '$table_name'";
                $table_exists = mysqli_query($conn, $table_check_query);
                if (mysqli_num_rows($table_exists) == 0) { //if not create table
                    $create_table_query = "CREATE TABLE `tirupati_2024`.`$table_name` (`date` VARCHAR(50) NOT NULL , `courier` VARCHAR(50) NOT NULL , `cn_no` VARCHAR(50) NOT NULL , `sndr` VARCHAR(50) NOT NULL , `rcvr` VARCHAR(50) NOT NULL , `city` VARCHAR(50) NOT NULL , `pincode` INT NOT NULL , `weight` FLOAT NOT NULL , `at_charge` INT NOT NULL , `shpr_amt` INT NOT NULL , PRIMARY KEY (`cn_no`)) ENGINE = InnoDB;";
                    mysqli_query($conn, $create_table_query);
                }
                //select from current month table
                $query = "SELECT * FROM `$table_name` ORDER BY date ASC";
                $data = mysqli_query($conn, $query);
                if (!$data) {
                    die("Query failed: " . mysqli_error($conn));
                }
                $total = mysqli_num_rows($data);
                $srno = 1; //add srno    


                if ($total != 0) {
                    while ($result = mysqli_fetch_assoc($data)) {
                        $date = $result['date'];
                        $f_date = date("Y-m-d", strtotime($date));
                        $r_date = date("d-m-Y", strtotime($date));
                        $courier = $result['courier'];


                        $TrackUrl = "http://www.shreetirupaticourier.net/Frm_DocTrack.aspx?docno=" . $result['cn_no'];


                        $updateUrl = "update.php?date=" . $f_date .
                            "&courier=" . $result['courier'] .
                            "&cn_no=" . $result['cn_no'] .
                            "&sndr=" . $result['sndr'] .
                            "&rcvr=" . $result['rcvr'] .
                            "&city=" . $result['city'] .
                            "&pincode=" . $result['pincode'] .
                            "&weight=" . $result['weight'] .
                            "&at_charge=" . $result['at_charge'] .
                            "&shpr_amt=" . $result['shpr_amt'];

                        $deleteUrl = "delete.php?cn_no=" . $result['cn_no'];
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
                                <td>
                                    <div class='dropdown'>
                                        <button class='dropbtn' disabled>Actions</button>
                                        <div class='dropdown-content'>
                                            <a class='update-a' href='" . $updateUrl . "'>Update</a>
                                            <a class='delete-a' href='" . $deleteUrl . "' onclick='return checkdelete()'>Delete</a>
                                            <form method='post' action='reciept.php'>
                                            <input type='hidden'  name='date' value='" . $r_date. "'>
                                            <input type='hidden'  name='courier' value='" . $result['courier'] . "'>
                                            <input type='hidden'  name='cn_no' value='" . $result['cn_no'] . "'>
                                            <input type='hidden'  name='sndr' value='" . $result['sndr'] . "'>
                                            <input type='hidden'  name='rcvr' value='" . $result['rcvr'] . "'>
                                            <input type='hidden'  name='city' value='" . $result['city'] . "'>
                                            <input type='hidden'  name='pincode' value='" . $result['pincode'] . "'>
                                            <input type='hidden'  name='weight' value='" . $result['weight'] . "'>
                                            <input type='hidden'  name='shpr_amt' value='" . $result['shpr_amt'] . "'>
                                            <input type='hidden'  name='TrackUrl' value='" . $TrackUrl . "'>
                                            <input type='submit' class='reciept-a' name='submit' value='reciept'>
                                            
                                            </form>
                                            <a class='track-a' href='" . $TrackUrl . "' target='_blank'>Track</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        <a class="getdetails-a" href="fulldetails.php">See Full Details</a>
                    </td>
                    <td colspan="3">
                        <a class="viewbooking-a" href="viewbooking.php">View Bookings</a>
                    </td>
                    <td colspan="3">
                        <a class="monthdisplay-a" href="monthdisplay.php">Monthly View</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form><br>
    <a href="../index.php" class="back-a">Back</a>
    <script src="jquery.js"></script>
    <script>
        function checkdelete() {
            return confirm("Are you sure you want to delete this data!!");
        }

        $(document).ready(function() {
            $('#search').keyup(function() {
                loadData(); // Load data with search filter
            });

            function loadData() {
                var query = $('#search').val(); // Search input
                // AJAX request to fetch data based on table and search
                $.ajax({
                    url: 'search.php',
                    type: 'GET',
                    data: {
                        q: query, // Search query
                    },
                    success: function(data) {
                        $('#consignmenttable tbody').html(data); // Update table body with the returned data
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error: " + status + error);
                    }
                });
            }
        });
    </script>
</body>

</html>