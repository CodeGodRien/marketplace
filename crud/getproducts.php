<?php
require '../config/dbconn.php';

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $sql = "SELECT * FROM products WHERE category = '$category'";
    $result = mysqli_query($conn, $sql);
    $products = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    echo json_encode($products);
} else {
    echo json_encode(array());
}
?>
