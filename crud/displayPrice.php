<?php
require "../config/dbconn.php";

$productID = $_GET['productID'];
$variationName = $_GET['variation'];
$size = $_GET['size'];

$sql = "SELECT variationPrice FROM variations WHERE productID = '$productID' AND variationName = '$variationName' AND 
variationSize = '$size'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$price = $row['variationPrice'];

echo json_encode($price);
?>