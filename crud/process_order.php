<?php
session_start();
require "../config/dbconn.php";

// Retrieve data from POST
$userID = $_SESSION['userID'];
$sellerID = $_POST['sellerID'];
$totalAmount = $_POST['totalAmount'];
$productIDs = $_POST['productID'];
$quantities = $_POST['quantity'];
$prices = $_POST['price'];
$paymentMethod = $_POST['payment-method'];
$variationIDs = $_POST['variationID'];

// Insert into orders table using prepared statement
$sql_orders = "INSERT INTO orders (userID, sellerID, totalAmount, paymentMethod) VALUES (?, ?, ?, ?)";
$stmt_orders = mysqli_prepare($conn, $sql_orders);
mysqli_stmt_bind_param($stmt_orders, "iiis", $userID, $sellerID, $totalAmount, $paymentMethod);
mysqli_stmt_execute($stmt_orders);
$orderID = mysqli_insert_id($conn);

// Insert into order_items table using prepared statement
$sql_order_items = "INSERT INTO order_items (orderID, productID, quantity, price, variationID) VALUES (?, ?, ?, ?, ?)";
$stmt_order_items = mysqli_prepare($conn, $sql_order_items);

// Bind parameters and execute in a loop
for ($i = 0; $i < count($productIDs); $i++) {
    mysqli_stmt_bind_param($stmt_order_items, "iiidi", $orderID, $productIDs[$i], $quantities[$i], $prices[$i], $variationIDs[$i]);
    mysqli_stmt_execute($stmt_order_items);
}

// Delete cart items for the user and seller
$sql_clear_cart = "DELETE FROM cart WHERE userID = ? AND sellerID = ?";
$stmt_clear_cart = mysqli_prepare($conn, $sql_clear_cart);
mysqli_stmt_bind_param($stmt_clear_cart, "ii", $userID, $sellerID);
mysqli_stmt_execute($stmt_clear_cart);

// Close statements and connection
mysqli_stmt_close($stmt_orders);
mysqli_stmt_close($stmt_order_items);
mysqli_stmt_close($stmt_clear_cart);
mysqli_close($conn);

// Redirect to cart page after processing
header("Location: ../pages/cart.php");
exit();
?>
