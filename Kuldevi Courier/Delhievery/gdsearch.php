<?php
include("connection.php");
$month_name = date("F");
$table_name =   $month_name;

$query = isset($_GET['q']) ? $_GET['q'] : '';

$sql = "SELECT * FROM `$table_name` WHERE date LIKE '%$query%' OR courier LIKE '$query%' OR cn_no LIKE '$query%' OR sndr LIKE '$query%' OR rcvr LIKE '$query%' OR city LIKE '$query%' OR pincode LIKE '$query%' ORDER BY date ASC";
$data = mysqli_query($conn, $sql);
$total_at_charge = 0;
$total_shpr_amt = 0;
$srno = 1;

$html = '';

// Function to highlight search query in the results
function highlight($text, $query)
{
    if (!$query) {
        return $text;
    }
    return preg_replace("/(" . preg_quote($query) . ")/i", "<span class='highlight'>$1</span>", $text);
}

if (mysqli_num_rows($data) != 0) {
    while ($result = mysqli_fetch_assoc($data)) {
        $total_at_charge += $result['at_charge'];
        $total_shpr_amt += $result['shpr_amt'];

        $html .= "<tr>
            <td>" . $srno++ . "</td>    
            <td>" . highlight($result['date'], $query) . "</td>
            <td>" . highlight($result['courier'], $query) . "</td>
            <td>" . highlight($result['cn_no'], $query) . "</td>
            <td>" . highlight($result['sndr'], $query) . "</td>
            <td>" . highlight($result['rcvr'], $query) . "</td>
            <td>" . highlight($result['city'], $query) . "</td>
            <td>" . highlight($result['pincode'], $query) . "</td>
            <td>" . highlight($result['weight'], $query) . " Kg</td>
            <td>Rs " . $result['at_charge'] . "</td>
            <td>Rs " . $result['shpr_amt'] . "</td>
        </tr>";
    }
} else {
    $html .= "<tr><td colspan='11'>No results found</td></tr>";
}

echo json_encode([
    'html' => $html,
    'total_at_charge' => "Rs " . $total_at_charge,
    'total_shpr_amt' => "Rs " . $total_shpr_amt,
]);
