<?php
require "../config/dbconn.php";
$userID = $_GET['userID'];

$sql = "SELECT * FROM orders WHERE userID = ? ORDER BY orderDate DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch all orders into an array
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    // Iterate over the orders array with foreach
    foreach ($orders as $row) {
        // Order details
        $orderID = $row['orderID'];
        $status = $row['orderStatus'];
        $totalPrice = $row['totalAmount'];
        $sellerID = $row['sellerID'];
        $orderPlaced = $row['orderDate'];

        // Fetch seller full name
        $sqlSeller = "SELECT CONCAT(first_name, ' ', last_name) AS sellerFullName FROM users WHERE userID = ?";
        $stmtSeller = $conn->prepare($sqlSeller);
        $stmtSeller->bind_param("i", $sellerID);
        $stmtSeller->execute();
        $resultSeller = $stmtSeller->get_result();
        $sellerRow = $resultSeller->fetch_assoc();
        $sellerName = $sellerRow['sellerFullName'];

        echo '
        <div class="my-orders-display all-my-orders pending-orders">
            <div class="orders-details">
                <div class="orders-details-row">
                    <div class="left-details-row"><i class="fa-solid fa-store"></i><strong>' . $sellerName . '</strong></div>
                    <div class="right-details-row">' . $status . '</div>
                </div>
            </div>
            <div class="orders-items">';

        // Fetch items for this order
        $itemSql = "SELECT * FROM order_items WHERE orderID = ?";
        $stmtItem = $conn->prepare($itemSql);
        $stmtItem->bind_param("i", $orderID);
        $stmtItem->execute();
        $itemResult = $stmtItem->get_result();

        if ($itemResult->num_rows > 0) {
            // Fetch all items into an array
            $items = [];
            while ($itemRow = $itemResult->fetch_assoc()) {
                $items[] = $itemRow;
            }

            // Iterate over the items array with foreach
            foreach ($items as $itemRow) {
                $productID = $itemRow['productID'];
                $variationID = $itemRow['variationID'];
                $quantity = $itemRow['quantity'];
                $price = $itemRow['price'];

                // Fetch product details from the products table
                $productSql = "SELECT * FROM products WHERE productID = ?";
                $stmtProduct = $conn->prepare($productSql);
                $stmtProduct->bind_param("i", $productID);
                $stmtProduct->execute();
                $productResult = $stmtProduct->get_result();
                $productRow = $productResult->fetch_assoc();
                $productName = $productRow['productName'];
                $productImg = $productRow['productImg'];

                // Fetch variation details from the variations table
                $variationSql = "SELECT * FROM variations WHERE variationID = ?";
                $stmtVariation = $conn->prepare($variationSql);
                $stmtVariation->bind_param("i", $variationID);
                $stmtVariation->execute();
                $variationResult = $stmtVariation->get_result();
                $variationRow = $variationResult->fetch_assoc();
                $variationName = $variationRow['variationName'];
                $size = $variationRow['variationSize'];

                $dateTime = new DateTime($orderPlaced);
                $formattedDate = $dateTime->format('F j, Y');
                $formattedTime = $dateTime->format('h:i A');
                $formattedDateTime = $formattedDate . ' at ' . $formattedTime;

                echo '
                <div class="orders-product-display">
                    <div class="left-product-display">
                        <div class="order-product-img-container">
                            <img src="../product_img/' . $productImg . '">
                        </div>
                        <div class="order-product-details">
                            <span>' . $productName . '</span>
                            <span>Variation: ' . $variationName . '</span>
                            <span>Size: ' . $size . '</span>
                            <span>x' . $quantity . '</span>
                        </div>
                    </div>
                    <div class="right-product-display"><i class="fa-solid fa-peso-sign"></i>' . $price . '</div>
                </div>';
            }
        }

        echo '
            </div>
            <div class="order-item-total">
                <div class="left-order-total">
                    <p>Order Status: To Pay</p>
                    <p>Order Placed: ' . $formattedDateTime . '</p>
                </div>
                <div class="right-order-total">
                    <div class="upper-order-item-total">
                        Order Total: <span class="order-total"><i class="fa-solid fa-peso-sign"></i>' . $totalPrice . '</span>
                    </div>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<p>No orders found.</p>';
}
?>
