<?php
session_start();
require "../config/dbconn.php";

$userID = $_SESSION['userID'];
$sellerID = $_POST['sellerID'];
$totalAmount = $_POST['totalAmount'];
$productIDs = $_POST['productID'];
$quantities = $_POST['quantity'];
$prices = $_POST['price'];
$paymentMethod = $_POST['payment-method'];

$sql = "INSERT INTO orders (userID, sellerID, totalAmount, paymentMethod) VALUES ('$userID', '$sellerID', '$totalAmount', '$paymentMethod')";
mysqli_query($conn, $sql);
$orderID = mysqli_insert_id($conn);

$sql = "INSERT INTO order_items (orderID, productID, quantity, price) VALUES ";
$values = [];

for ($i = 0; $i < count($productIDs); $i++) {
    $values[] = "('$orderID', '" . $productIDs[$i] . "', '" . $quantities[$i] . "', '" . $prices[$i] . "')";
}

$sql .= implode(", ", $values);
mysqli_query($conn, $sql);

$sql_clear_cart = "DELETE FROM cart WHERE userID = '$userID' AND sellerID = '$sellerID'";
mysqli_query($conn, $sql_clear_cart);

header("Location: ../pages/cart.php");

?>