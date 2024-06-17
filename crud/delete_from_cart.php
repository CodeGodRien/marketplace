<?php
session_start();
require "../config/dbconn.php";

// Sanitize input (not necessary for prepared statements but good practice)
$productID = $_GET['productID'];
$userID = $_SESSION['userID'];

// Prepare the DELETE statement
$sql = "DELETE FROM cart WHERE productID = ? AND userID = ?";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the statement
mysqli_stmt_bind_param($stmt, "ii", $productID, $userID);

// Execute the statement
mysqli_stmt_execute($stmt);

// Check if deletion was successful
if (mysqli_stmt_affected_rows($stmt) > 0) {
    $_SESSION['alert'] = "Product removed from cart successfully.";
} else {
    $_SESSION['alert'] = "Failed to remove product from cart.";
}

// Clean up statement
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Redirect to cart page
header("Location: ../pages/cart.php");
exit();
?>
