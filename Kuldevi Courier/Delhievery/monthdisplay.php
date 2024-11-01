<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consignment Details</title>
    <style>
        body,
        input,
        #selected_month,
        .back-a,
        table {
            text-align: center;
            font-family: calibri;
            font-size: 25px;
        }

        h1 {
            font-size: 50px;
            text-decoration: underline;
            font-family: Space Grotesk;
            margin-bottom: 0;
            margin-top: 0;
        }

        input,
        #selected_month,
        .back-a,
        td,
        table,
        th {
            font-weight: 900;
            border: solid 2px black;
        }

        input,
        #selected_month {
            margin-bottom: 1%;
            color: black;
            text-decoration: none;
            transition: all 0.9s ease;
        }

        #selected_month {
            color: blue;
        }

        .back-a {
            color: black;
            text-decoration: none;
            transition: all 0.9s ease;
        }

        table {
            border-collapse: collapse;
            font-size: 18px;
            margin-bottom: 1%;
        }

        th {
            text-decoration: underline;
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

        input:focus,
        #selected_month:focus {
            border: solid 6px orangered;
            font-size: 34px;
        }

        #selected_month:focus {
            color: orangered;
        }

        .back-a:hover {
            text-decoration: underline;
            color: orangered;
            font-size: 34px;
        }

        .monthdisplay-a,
        .viewbooking-a,
        .getdetails-a {
            text-decoration: none;
            transition: all 0.9s ease;
        }

        .monthdisplay-a,
        .viewbooking-a,
        .getdetails-a {
            color: darkcyan;
        }

        .monthdisplay-a:hover,
        .viewbooking-a:hover,
        .getdetails-a:hover {
            text-decoration: underline;
            color: orangered;
            font-size: 24.5px;
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
        .dropdown-content a,
        .dropdown-content input,
        .dropdown-content button {
            color: darkorange;
            font-size: 18px;
            padding: 5px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            transition: all 0.9s ease;
        }

        /* Change color of links on hover */
        .dropdown-content a:hover,
        .dropdown-content input:hover,
        .dropdown-content button:hover {
            color: orangered;
            text-decoration: underline;
            font-size: 21px;
            cursor: pointer;
        }

        /* Show the dropdown content on hover */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Change color of button on hover */
        .dropdown:hover .dropbtn {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <form method="post">
        <h1>Kuldevi Courier</h1>
        <input type="text" name="search" id="search" placeholder="Enter Text to Search" autocomplete="off">
        <select name="selectedmonth" id="selected_month">
            <option value="">Select Month</option>
            <?php
            include("connection.php");
            $qry = "show tables";
            $result = mysqli_query($conn, $qry);
            while ($row = mysqli_fetch_array($result)) {
                // Convert the table name to uppercase for display
                $table_name = strtoupper($row[0]);
                echo "<option value='" . strtolower($row[0]) . "'>" . $table_name . "</option>";
            }
            ?>
        </select>

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
                <tr>
                    <td colspan='10'>Please Select Month</td>
                </tr>
            </tbody>
        </table>
        <a class="back-a" href="display.php">Back</a>
    </form>

    <script src="jquery.js"></script>
    <script>
        function checkdelete() {
            return confirm("Are you sure you want to delete this data!!");
        }

        $(document).ready(function() {
            $('#search').keyup(function() {
                var month = $('#selected_month').val(); // month input        
                if (month == "") {
                    alert("Please Select Month");
                } else {
                    loadData(); // Load data with search filter
                }
            });
            $('#selected_month').change(function() {
                var month = $('#selected_month').val(); // month input        
                if (month == "") {
                    alert("Please Select Month");
                } else {
                    loadData(); // Load data with search filter
                }
            });

            function loadData() {
                var query = $('#search').val(); // Search input
                var month = $('#selected_month').val(); // month input
                // AJAX request to fetch data based on table and search
                $.ajax({
                    url: 'monthsearch.php',
                    type: 'GET',
                    data: {
                        q: query, // Search query
                        selmon: month,
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