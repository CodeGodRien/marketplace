<?php
session_start();
require "../config/dbconn.php";

$userID = $_SESSION['userID'];

$sql = "SELECT * FROM orders WHERE userID = ? AND orderStatus = 'Completed' ORDER BY orderDate DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    foreach ($orders as $row) {
        $orderID = $row['orderID'];
        $status = $row['orderStatus'];
        $totalPrice = $row['totalAmount'];
        $sellerID = $row['sellerID'];
        $orderPlaced = $row['orderDate'];

        $sql = "SELECT CONCAT(first_name, ' ', last_name) AS sellerFullName FROM users WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sellerID);
        $stmt->execute();
        $result = $stmt->get_result();
        $sellerRow = $result->fetch_assoc();
        $sellerName = $sellerRow['sellerFullName'];

        echo '
        <div class="my-orders-display all-my-orders">
            <div class="orders-details">
                <div class="orders-details-row">
                    <div class="left-details-row"><i class="fa-solid fa-store"></i><strong>' . htmlspecialchars($sellerName) . '</strong></div>
                    <div class="right-details-row">' . htmlspecialchars($status) . '</div>
                </div>
            </div>
            <div class="orders-items">';

        $itemSql = "SELECT * FROM order_items WHERE orderID = ?";
        $itemStmt = $conn->prepare($itemSql);
        $itemStmt->bind_param("i", $orderID);
        $itemStmt->execute();
        $itemResult = $itemStmt->get_result();

        if ($itemResult->num_rows > 0) {
            $items = [];
            while ($itemRow = $itemResult->fetch_assoc()) {
                $items[] = $itemRow;
            }

            foreach ($items as $itemRow) {
                $productID = $itemRow['productID'];
                $variationID = $itemRow['variationID'];
                $quantity = $itemRow['quantity'];
                $price = $itemRow['price'];

                $productSql = "SELECT * FROM products WHERE productID = ?";
                $productStmt = $conn->prepare($productSql);
                $productStmt->bind_param("i", $productID);
                $productStmt->execute();
                $productResult = $productStmt->get_result();
                $productRow = $productResult->fetch_assoc();
                $productName = $productRow['productName'];
                $productImg = $productRow['productImg'];

                $variationSql = "SELECT * FROM variations WHERE variationID = ?";
                $variationStmt = $conn->prepare($variationSql);
                $variationStmt->bind_param("i", $variationID);
                $variationStmt->execute();
                $variationResult = $variationStmt->get_result();
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
                            <img src="../product_img/' . htmlspecialchars($productImg) . '">
                        </div>
                        <div class="order-product-details">
                            <span>' . htmlspecialchars($productName) . '</span>
                            <span>Variation: ' . htmlspecialchars($variationName) . '</span>
                            <span>Size: ' . htmlspecialchars($size) . '</span>
                            <span>x' . htmlspecialchars($quantity) . '</span>
                        </div>
                    </div>
                    <div class="right-product-display"><i class="fa-solid fa-peso-sign"></i>' . htmlspecialchars($price) . '</div>
                </div>';
            }
        }

        echo '
            </div>
            <div class="order-item-total">
                <div class="left-order-total">
                    <p>Order Status: ' . htmlspecialchars($status) . '</p>
                    <p>Order Placed: ' . htmlspecialchars($formattedDateTime) . '</p>
                </div>
                <div class="right-order-total">
                    <div class="upper-order-item-total">
                        Order Total: <span class="order-total"><i class="fa-solid fa-peso-sign"></i>' . htmlspecialchars($totalPrice) . '</span>
                    </div>
                    <div class="lower-order-item-total">
                        <a href="" class="rate-product-link">
                            <div class="rate-button"><i class="fa-solid fa-star star-rating-btn-icon"></i>Rate</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<p>No orders found.</p>';
}
?>
