<?php
require "../config/dbconn.php";

$prodID = $_GET["productID"];
$variationID = $_GET["variationID"];

if (isset($prodID) && isset($variationID)) {
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE productID = ? AND variationID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $prodID, $variationID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Update was successful, you can add a success message here if needed.
    } else {
        // No rows were updated, you can add an error message here if needed.
    }

    $stmt->close();
}

header("Location: ../pages/cart.php");
exit();
?>
