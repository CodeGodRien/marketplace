<?php
session_start();
require "../config/dbconn.php";

$productID = $_GET["productID"];
$userID = $_SESSION["userID"];
$variationID = $_GET["variationID"];

// Step 1: Validate inputs (ensure $productID, $userID, $variationID are valid)

// Step 2: Retrieve current quantity from cart
$checkQty = "SELECT quantity FROM cart WHERE variationID = ? AND userID = ?";
$stmt = $conn->prepare($checkQty);
$stmt->bind_param("ii", $variationID, $userID);
$stmt->execute();
$result = $stmt->get_result();
$qtyFetched = $result->fetch_assoc();

if ($qtyFetched && $qtyFetched['quantity'] > 0) {
    // Step 3: Determine action based on current quantity
    if ($qtyFetched['quantity'] == 1) {
        // Step 4a: If quantity is 1, delete the item from cart
        $deleteSql = "DELETE FROM cart WHERE userID = ? AND variationID = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("ii", $userID, $variationID);
        $deleteStmt->execute();
    } else {
        // Step 4b: If quantity > 1, decrement the quantity by 1
        $updateSql = "UPDATE cart SET quantity = quantity - 1 WHERE userID = ? AND variationID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $userID, $variationID);
        $updateStmt->execute();
    }
}

// Step 5: Redirect to cart page after action
header("Location: ../pages/cart.php");
exit();
?>
