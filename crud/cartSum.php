<?php
require "../config/dbconn.php";
session_start();
$userID = $_SESSION['userID'];

$sql = "SELECT SUM(unitPrice * quantity) as total FROM cart WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$fetch = $result->fetch_assoc();

if ($fetch['total'] == null) {
    echo 0;
} else {
    echo $fetch['total'];
}

$stmt->close();
$conn->close();
?>
