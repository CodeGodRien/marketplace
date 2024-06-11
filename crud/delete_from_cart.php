<?php
session_start();
require "../config/dbconn.php";

$productID = $_GET['productID'];
$userID = $_SESSION['userID'];

$sql = "DELETE FROM cart WHERE productID = '$productID' AND userID = '$userID'";
$result = mysqli_query($conn, $sql);

header("Location: ../pages/cart.php");
exit();



?>