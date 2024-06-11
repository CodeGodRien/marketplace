<?php 
require "../config/dbconn.php";
$prodID = $_GET["productID"];
$variationID = $_GET["variationID"];

$sql = "UPDATE cart SET quantity = quantity+1 WHERE productID = $prodID AND variationID = $variationID";
$result = mysqli_query($conn,$sql);
header("Location:../pages/cart.php");
exit();
?>