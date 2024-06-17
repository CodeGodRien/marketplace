<?php
session_start();
require "../config/dbconn.php";

$productID = $_GET['productID'];
$userID = $_SESSION['userID'];
$page = $_GET['pageID'];
$variationName = $_GET['variation'];
$size = $_GET['size'];

// Prepare and execute the first SQL statement
$sql = "SELECT * FROM products WHERE productID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $productID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$productName = $row['productName'];
$productSellerID = $row['productSellerID'];

// Prepare and execute the second SQL statement
$sql = "SELECT * FROM variations WHERE variationName = ? AND variationSize = ? AND productID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'sss', $variationName, $size, $productID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$price = $row['variationPrice'];
$variationID = $row['variationID'];

// Prepare and execute the third SQL statement
$sql = "SELECT * FROM cart WHERE productID = ? AND variationID = ? AND userID = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'sss', $productID, $variationID, $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Prepare and execute the update statement
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE productID = ? AND variationID = ? AND userID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $productID, $variationID, $userID);
    if (mysqli_stmt_execute($stmt)) {
        // Success alert
    } else {
        // Error alert
    }
} else {
    // Prepare and execute the insert statement
    $sql = "INSERT INTO cart (userID, productID, sellerID, quantity, unitPrice, timeAdded, variationID) VALUES (?, ?, ?, 1, ?, CURRENT_TIMESTAMP, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'sssss', $userID, $productID, $productSellerID, $price, $variationID);
    if (mysqli_stmt_execute($stmt)) {
        // Success alert
    } else {
        // Error alert
    }
}

if ($page != "detailed") {
    header("Location: ../pages/customer_dashboard.php");
} else {
    header("Location: ../pages/product_details.php?productID=$productID");
}
exit();
?>
