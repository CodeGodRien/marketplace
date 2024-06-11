<?php
require "../config/dbconn.php";

$productID = $_GET['productID'];
if (isset($_GET['variationName'])) {
    $variationName = $_GET['variationName'];
    $sql = "SELECT variationSize FROM variations WHERE variationName = '$variationName' AND productID = '$productID' ORDER BY variationPrice";
    $result = mysqli_query($conn, $sql);
} else {
    $sql = "SELECT DISTINCT variationSize FROM variations WHERE productID = '$productID' ORDER BY variationPrice";
    $result = mysqli_query($conn, $sql);
}

$sizes = array();
while ($row = mysqli_fetch_assoc($result)) {
    $sizes[] = $row['variationSize'];
}

echo json_encode($sizes);
?>