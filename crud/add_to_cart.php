<?php
session_start();
require "../config/dbconn.php";

$productID = $_GET['productID'];
$userID = $_SESSION['userID'];
$page = $_GET['pageID'];
$variationName = $_GET['variation'];
$size = $_GET['size'];


$sql = "SELECT * FROM products WHERE productID = '$productID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$productName = $row['productName'];
$productSellerID = $row['productSellerID'];

$sql = "SELECT * FROM variations WHERE variationName = '$variationName' AND variationSize = '$size' AND productID = '$productID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$price = $row['variationPrice'];
$variationID = $row['variationID'];

$sql = "SELECT * FROM cart WHERE productID = '$productID' AND variationID = '$variationID' AND userID = '$userID'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE productID = '$productID' AND variationID = '$variationID' AND userID = '$userID'";
    if (mysqli_query($conn, $sql)) {
        //write alert here
    } else {
        //write alert here
        
    }
    
} else {
    $sql = "INSERT INTO cart (userID, productID, sellerID, quantity, unitPrice, timeAdded, variationID) VALUES ('$userID', '$productID', '$productSellerID', 1,
    '$price', CURRENT_TIMESTAMP, '$variationID')";
    
    if (mysqli_query($conn, $sql)) {
        
    } else {
        
    }
}
if ($page != "detailed") {
    header("Location: ../pages/customer_dashboard.php");
} else {
    header("Location: ../pages/product_details.php?productID=$productID");
}
exit();

?>