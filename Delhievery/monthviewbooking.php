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
        .back-a,
        #export {
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
            font-size: 25px;
            margin-bottom: 1%;
        }

        input,
        th,
        td,
        .back-a,
        #export,
        table {
            font-weight: bolder;
            border: solid 2px black;
            border-collapse: collapse;
        }

        table {
            font-size: 17px;
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

        .back-a,
        #export {
            font-size: 25px;
            text-decoration: none;
            padding: 1px;
            margin-bottom: 5px;
            transition: all 0.9s ease;
        }

        .back-a {
            color: black;
        }

        #export {
            color: darkgoldenrod;
        }

        .back-a:hover,
        #export:hover {
            text-decoration: underline;
            color: orangered;
            font-size: 34px;
            cursor: pointer;
        }
    </style>
    <script src="jspdf.umd.min.js"></script>
    <script src="jspdf.plugin.autotable.js"></script>
</head>

<body>
    <h1>Kuldevi Courier</h1>
    <button id="export">Export</button>
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
            $monthname = $_GET['monthname'];
            $table_name =  $monthname;
            $backurl = "monthdisplay.php";
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
        </tfoot>
    </table><br>
    <a class="back-a" href="monthdisplay.php">Back</a>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const {
            jsPDF
        } = window.jspdf;

        document.getElementById('export').addEventListener('click', () => {
            // Initialize jsPDF with landscape orientation
            const doc = new jsPDF({
                orientation: 'landscape', // Set to landscape mode
                unit: 'mm',
                format: 'a4'
            });
            const urlParams = new URLSearchParams(window.location.search);
            const monthname = urlParams.get('monthname') || 'receipt'; // Default to 'receipt' if cn_no is not present

            // Configure the autoTable
            doc.autoTable({
                html: '#consignmenttable',
                theme: 'grid',
                headStyles: {
                    fillColor: [60, 141, 188]
                },
                margin: {
                    top: 20
                },
                startY: 20,
                columnStyles: {
                    0: {
                        cellWidth: 'auto'
                    }, // Auto width for Sr.No
                    1: {
                        cellWidth: 'auto'
                    }, // Auto width for Date
                    2: {
                        cellWidth: 'auto'
                    }, // Auto width for Courier
                    3: {
                        cellWidth: 'auto'
                    }, // Auto width for Consignment No
                    4: {
                        cellWidth: 'auto'
                    }, // Auto width for Sender's Name
                    5: {
                        cellWidth: 'auto'
                    }, // Auto width for Receiver's Name
                    6: {
                        cellWidth: 'auto'
                    }, // Auto width for Destination City
                    7: {
                        cellWidth: 'auto'
                    }, // Auto width for Pincode
                    8: {
                        cellWidth: 'auto'
                    }, // Auto width for Weight(Kg)
                    9: {
                        cellWidth: 'auto'
                    }, // Auto width for At Charge
                },
                styles: {
                    fontSize: 12, // Reduced font size to fit the content
                    cellPadding: 1
                },
                tableWidth: 'wrap', // Ensure the table width fits within the page width
            });

            // Save the PDF with a default name
            doc.save(`Booking Of ${monthname}.pdf`);

        });
    });
</script>

</html>