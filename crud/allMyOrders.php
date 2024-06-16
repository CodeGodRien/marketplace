<?php
require "../config/dbconn.php";
$userID = $_GET['userID'];

$sql = "SELECT * FROM orders WHERE userID = '$userID' ORDER BY orderDate DESC";
        $result = mysqli_query($conn, $sql);
        
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
        
                // Fetch seller full name
                $sql = "SELECT CONCAT(first_name, ' ', last_name) AS sellerFullName FROM users WHERE userID = '$sellerID'";
                $result = mysqli_query($conn, $sql);
                $sellerRow = mysqli_fetch_assoc($result);
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
                $itemSql = "SELECT * FROM order_items WHERE orderID = '$orderID'";
                $itemResult = mysqli_query($conn, $itemSql);
        
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
                        $productSql = "SELECT * FROM products WHERE productID = '$productID'";
                        $productResult = mysqli_query($conn, $productSql);
                        $productRow = mysqli_fetch_assoc($productResult);
                        $productName = $productRow['productName'];
                        $productImg = $productRow['productImg'];
        
                        // Fetch variation details from the variations table
                        $variationSql = "SELECT * FROM variations WHERE variationID = '$variationID'";
                        $variationResult = mysqli_query($conn, $variationSql);
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