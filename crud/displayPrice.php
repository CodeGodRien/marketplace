<?php
require "../config/dbconn.php";

$productID = $_GET['productID'];
$variationName = $_GET['variation'];
$size = $_GET['size'];

// Prepare the SELECT statement with placeholders
$sql = "SELECT variationPrice FROM variations WHERE productID = ? AND variationName = ? AND variationSize = ?";
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the statement
mysqli_stmt_bind_param($stmt, "iss", $productID, $variationName, $size);

// Execute the statement
mysqli_stmt_execute($stmt);

// Bind result variables
mysqli_stmt_bind_result($stmt, $price);

// Fetch the result
mysqli_stmt_fetch($stmt);

// Close the statement
mysqli_stmt_close($stmt);

// Output the result as JSON
echo json_encode($price);

// Close the connection
mysqli_close($conn);
?>
