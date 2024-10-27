<?php
include("connection.php");

$query = $_GET['q'];
$month_name = $_GET['selmon'];
$TrackUrl = "";

// SQL query to fetch data
$sql = "SELECT * FROM `$month_name` WHERE 
            `date` LIKE '%$query%' OR 
            `courier` LIKE '%$query%' OR 
            `cn_no` LIKE '%$query%' OR 
            `sndr` LIKE '%$query%' OR 
            `rcvr` LIKE '%$query%' OR 
            `city` LIKE '%$query%' OR 
            `pincode` LIKE '%$query%' order by date";

$data = mysqli_query($conn, $sql);
$total = mysqli_num_rows($data);
$srno = 1;

// Function to highlight the search term
function highlight($text, $query)
{
    if (!$query) {
        return $text;
    }
    return preg_replace("/($query)/i", "<span class='highlight'>$1</span>", $text);
}

// Display results
if ($total > 0) {
    while ($result = mysqli_fetch_assoc($data)) {
        $date = $result['date'];
        $f_date = date("Y-m-d", strtotime($date));
        $r_date = date("d-m-Y", strtotime($date));
        $courier = $result['courier'];

        // Generate URLs
        $updateUrl = "monthupdate.php?date=" . $f_date .
            "&courier=" . $result['courier'] .
            "&cn_no=" . $result['cn_no'] .
            "&sndr=" . $result['sndr'] .
            "&rcvr=" . $result['rcvr'] .
            "&city=" . $result['city'] .
            "&pincode=" . $result['pincode'] .
            "&weight=" . $result['weight'] .
            "&at_charge=" . $result['at_charge'] .
            "&shpr_amt=" . $result['shpr_amt'] .
            "&monthname=" . $month_name;

        $deleteUrl = "monthdelete.php?cn_no=" . $result['cn_no'] .
            "&monthname=" . $month_name;

        $RecieptUrl = "reciept.php?date=" . $r_date .
            "&courier=" . $result['courier'] .
            "&cn_no=" . $result['cn_no'] .
            "&sndr=" . $result['sndr'] .
            "&rcvr=" . $result['rcvr'] .
            "&city=" . $result['city'] .
            "&pincode=" . $result['pincode'] .
            "&weight=" . $result['weight'] .
            "&trackurl=" . $TrackUrl .
            "&shpr_amt=" . $result['shpr_amt'];


        $TrackUrl = "";
        if ($courier == "Delhievery") {
            $TrackUrl = "https://www.delhivery.com/track/package/" . urlencode($result['cn_no']);
        } elseif ($courier == "DTDC") {
            $TrackUrl = "https://www.dtdc.in/tracking.asp";
        } elseif ($courier == "Mahavir") {
            $TrackUrl = "http://www.smespl.in/Frm_DocTrackWeb.aspx?docno=" . urlencode($result['cn_no']);
        } elseif ($courier == "Tirupati") {
            $TrackUrl = "http://www.shreetirupaticourier.net/Frm_DocTrack.aspx?docno=" . urlencode($result['cn_no']);
        } elseif ($courier == "EcomExpress") {
            $TrackUrl = "https://ecomexpress.in/tracking/?awb_field=" . $result['cn_no'];
        }

        $getdetailsurl = "monthfulldetails.php?monthname=" . $month_name;
        $viewbookingurl = "monthviewbooking.php?monthname=" . $month_name;
        $shortdetailsurl = "monthshortdetails.php?monthname=" . $month_name;

        // Highlight the search term in each column
        echo "<tr>
                <td>" . $srno++ . "</td>
                <td>" . highlight($result['date'], $query) . "</td>
                <td>" . highlight($result['courier'], $query) . "</td>
                <td>" . highlight($result['cn_no'], $query) . "</td>
                <td>" . highlight($result['sndr'], $query) . "</td>
                <td>" . highlight($result['rcvr'], $query) . "</td>
                <td>" . highlight($result['city'], $query) . "</td>
                <td>" . highlight($result['pincode'], $query) . "</td>
                <td>" . $result['weight'] . " Kg</td>
                <td>
                                    <div class='dropdown'>
                                        <button class='dropbtn' disabled>Actions</button>
                                        <div class='dropdown-content'>
                                            <a class='update-a' href='" . $updateUrl . "'>Update</a>
                                            <a class='delete-a' href='" . $deleteUrl . "' onclick='return checkdelete()'>Delete</a>
                                            <a class='reciept-a' href='" . $RecieptUrl . "'>Reciept</a>
                                            <a class='track-a' href='" . $TrackUrl . "' target='_blank'>Track</a>
                                        </div>
                                    </div>
                                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='10'>No results found</td></tr>";
}
echo "<tr>
<td colspan='3'>
    <a <a class='getdetails-a' href='" . $getdetailsurl . "'>See Full Details</a>
</td>
<td colspan='4'>
    <a class='viewbooking-a' href='" . $viewbookingurl . "'>View Bookings</a>
</td>
<td colspan='3'>
    <a class='monthdisplay-a' href='" . $shortdetailsurl . "'>See Details</a>
</td>
</tr>";
