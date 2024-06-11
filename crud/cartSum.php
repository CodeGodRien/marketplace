<?php
require "../config/dbconn.php";
$userID = $_SESSION['userID'];
$sql = "SELECT SUM(unitPrice * quantity) as total FROM cart WHERE userID = $userID";
$result = mysqli_query($conn, $sql);

$fetch = mysqli_fetch_assoc($result);

if($fetch['total'] == null){
    echo 0;
}else{
    echo $fetch['total'];
}

?>