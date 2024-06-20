<?php
session_start();
require "../config/dbconn.php";
$userID = $_GET['userID'];

// Validate and sanitize input (already sanitized as per your current approach)
$userID = htmlspecialchars($_GET['userID']);

// Prepare the SQL query using placeholders
$sql = "SELECT 
            orders.*, 
            CONCAT(users.first_name, ' ', users.last_name) AS buyerFullName, 
            GROUP_CONCAT(DISTINCT products.productName SEPARATOR ', ') AS productNames,
            SUM(order_items.quantity) AS totalQuantity,
            DATE_FORMAT(orders.orderDate, '%M %e, %Y %h:%i %p') AS formattedOrderDate
        FROM 
            orders 
        INNER JOIN 
            users ON orders.userID = users.userID 
        INNER JOIN 
            order_items ON orders.orderID = order_items.orderID
        INNER JOIN 
            products ON order_items.productID = products.productID
        WHERE 
            orders.sellerID = ? AND orders.orderStatus = 'Pending'
        GROUP BY 
            orders.orderID";

// Initialize prepared statement
$stmt = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($stmt, $sql)) {
    // Bind parameters to statement
    mysqli_stmt_bind_param($stmt, "s", $userID);

    // Execute statement
    mysqli_stmt_execute($stmt);

    // Get result set
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="orders-table" id="orders-table">';
        echo '<thead>
                <tr id="orders-tr">
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Amount</th>
                    <th># of Items</th>
                    <th>Product</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>';
        echo '<tbody>';
        while ($row = mysqli_fetch_assoc($result)) {
            $orderID = $row['orderID'];
            echo '<tr class="orders-tr">';
            echo '<td class="td-orderID">' . $orderID . '</td>'; 
            echo '<td class="td-buyerName">' . $row['buyerFullName'] . '</td>'; 
            echo '<td class="td-totalAmount">' . $row['totalAmount'] . '</td>'; 
            echo '<td class="td-itemQty">' . $row['totalQuantity'] . '</td>'; 
            echo '<td class="td-productName">' . $row['productNames'] . '</td>'; 
            echo '<td class="td-paymentMethod">' . $row['paymentMethod'] . '</td>'; 
            echo '<td class="td-orderDate">' . $row['formattedOrderDate'] . '</td>'; 
            echo '<td class="td-orderStatus">' . $row['orderStatus'] . '</td>'; 
            echo '<td class="td-nextBtn"><i class="fa-solid fa-chevron-right" data-order-id="' . $orderID . '" data-order-status="' . $row['orderStatus'] . '"></i></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No orders found.</p>';
    }
} else {
    echo '<p>SQL statement preparation failed.</p>';
}

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
