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
        if ($courier == "Delhievery") {
            $TrackUrl = "https://www.delhivery.com/track/package/" . $result['cn_no'];
        } elseif ($courier == "DTDC") {
            $TrackUrl = "https://www.dtdc.in/tracking.asp";
        } elseif ($courier == "Mahavir") {
            $TrackUrl = "http://www.smespl.in/Frm_DocTrackWeb.aspx?docno=" . $result['cn_no'];
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
                                        <form method='post' action='monthupdate.php'>
                                            <input type='hidden'  name='date' value='" . $f_date . "'>
                                            <input type='hidden'  name='courier' value='" . $result['courier'] . "'>
                                            <input type='hidden'  name='cn_no' value='" . $result['cn_no'] . "'>
                                            <input type='hidden'  name='sndr' value='" . $result['sndr'] . "'>
                                            <input type='hidden'  name='rcvr' value='" . $result['rcvr'] . "'>
                                            <input type='hidden'  name='city' value='" . $result['city'] . "'>
                                            <input type='hidden'  name='pincode' value='" . $result['pincode'] . "'>
                                            <input type='hidden'  name='weight' value='" . $result['weight'] . "'>
                                            <input type='hidden'  name='at_charge' value='" . $result['at_charge'] . "'>
                                            <input type='hidden'  name='shpr_amt' value='" . $result['shpr_amt'] . "'>
                                            <input type='hidden'  name='monthname' value='" . $month_name . "'>
                                            <input type='submit'  value='Update'>
                                        </form>  
                                        <form method='post' action='monthdelete.php' onsubmit='return checkdelete()'>
                                            <input type='hidden'  name='cn_no' value='" . $result['cn_no'] . "'>
                                            <input type='hidden'  name='monthname' value='" . $month_name . "'>
                                            <input type='submit'  value='Delete'>
                                        </form>  
                                        <form method='post' action='reciept.php'>
                                            <input type='hidden'  name='date' value='" . $r_date . "'>
                                            <input type='hidden'  name='courier' value='" . $result['courier'] . "'>
                                            <input type='hidden'  name='cn_no' value='" . $result['cn_no'] . "'>
                                            <input type='hidden'  name='sndr' value='" . $result['sndr'] . "'>
                                            <input type='hidden'  name='rcvr' value='" . $result['rcvr'] . "'>
                                            <input type='hidden'  name='city' value='" . $result['city'] . "'>
                                            <input type='hidden'  name='pincode' value='" . $result['pincode'] . "'>
                                            <input type='hidden'  name='weight' value='" . $result['weight'] . "'>
                                            <input type='hidden'  name='shpr_amt' value='" . $result['shpr_amt'] . "'>
                                            <input type='hidden'  name='TrackUrl' value='" . $TrackUrl . "'>
                                            <input type='hidden' name='page' value='monthdisplay'>
                                            <input type='submit'  value='Reciept'>
                                        </form>
                                        <button onclick=\"window.open('" . $TrackUrl . "', '_blank')\">Track</button>
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
