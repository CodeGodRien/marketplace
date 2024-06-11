<?php
require "../config/dbconn.php";

$productID = $_GET['productID'];
$sql = "SELECT DISTINCT variationName FROM variations WHERE productID = '$productID'";
$result = mysqli_query($conn, $sql);

$variations = array();
while ($row = mysqli_fetch_assoc($result)) {
    $variations[] = $row['variationName'];
}

echo json_encode($variations);
?>