<?php
session_start();
require "../config/dbconn.php";
$userID = $_SESSION['userID'];

$sql = "SELECT * FROM orders WHERE userID = ? AND orderStatus = 'To Receive' ORDER BY orderDate DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userID); // Assuming userID is integer
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Fetch all orders into an array
    $orders = [];
    while ($row = mysqli_fetch_assoc($result)) {
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

        // Fetch seller full name using prepared statement
        $sellerName = "";
        $sql = "SELECT CONCAT(first_name, ' ', last_name) AS sellerFullName FROM users WHERE userID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $sellerID); // Assuming userID is integer
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($sellerRow = mysqli_fetch_assoc($result)) {
            $sellerName = $sellerRow['sellerFullName'];
        }

        echo '
        <div class="my-orders-display all-my-orders pending-orders">
            <div class="orders-details">
                <div class="orders-details-row">
                    <div class="left-details-row"><i class="fa-solid fa-store"></i><strong>' . htmlspecialchars($sellerName) . '</strong></div>
                    <div class="right-details-row">' . htmlspecialchars($status) . '</div>
                </div>
            </div>
            <div class="orders-items">';

        // Fetch items for this order using prepared statement
        $itemSql = "SELECT * FROM order_items WHERE orderID = ?";
        $itemStmt = mysqli_prepare($conn, $itemSql);
        mysqli_stmt_bind_param($itemStmt, "i", $orderID); // Assuming orderID is integer
        mysqli_stmt_execute($itemStmt);
        $itemResult = mysqli_stmt_get_result($itemStmt);

        if (mysqli_num_rows($itemResult) > 0) {
            // Fetch all items into an array
            $items = [];
            while ($itemRow = mysqli_fetch_assoc($itemResult)) {
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
                $productStmt = mysqli_prepare($conn, $productSql);
                mysqli_stmt_bind_param($productStmt, "i", $productID); // Assuming productID is integer
                mysqli_stmt_execute($productStmt);
                $productResult = mysqli_stmt_get_result($productStmt);
                $productRow = mysqli_fetch_assoc($productResult);
                $productName = $productRow['productName'];
                $productImg = $productRow['productImg'];

                // Fetch variation details from the variations table
                $variationSql = "SELECT * FROM variations WHERE variationID = ?";
                $variationStmt = mysqli_prepare($conn, $variationSql);
                mysqli_stmt_bind_param($variationStmt, "i", $variationID); // Assuming variationID is integer
                mysqli_stmt_execute($variationStmt);
                $variationResult = mysqli_stmt_get_result($variationStmt);
                $variationRow = mysqli_fetch_assoc($variationResult);
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
                    <p>Order Status: Pending</p>
                    <p>Order Placed: ' . htmlspecialchars($formattedDateTime) . '</p>
                    <p>Estimated Delivery Date:</p>
                </div>
                <div class="right-order-total">
                    <div class="upper-order-item-total">
                        Order Total: <span class="order-total"><i class="fa-solid fa-peso-sign"></i>' . htmlspecialchars($totalPrice) . '</span>
                    </div>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<p>No orders found.</p>';
}
?>
