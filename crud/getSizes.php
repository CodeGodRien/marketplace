<?php
require "../config/dbconn.php";

$productID = $_GET['productID'];

if (isset($_GET['variationName'])) {
    $variationName = $_GET['variationName'];
    $sql = "SELECT variationSize FROM variations WHERE variationName = ? AND productID = ? ORDER BY variationPrice";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $variationName, $productID);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT DISTINCT variationSize FROM variations WHERE productID = ? ORDER BY variationPrice";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
}

$sizes = array();
while ($row = mysqli_fetch_assoc($result)) {
    $sizes[] = $row['variationSize'];
}

echo json_encode($sizes);
?>
