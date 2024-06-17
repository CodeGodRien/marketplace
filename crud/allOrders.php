<?php
require "../config/dbconn.php";
$userID = $_GET['userID'];

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
            orders.sellerID = ?
        GROUP BY 
            orders.orderID
        ORDER BY
            orders.orderDate DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
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
    while ($row = $result->fetch_assoc()) {
        $orderID = $row['orderID'];
        $orderStatus = $row['orderStatus'];
        echo '<tr class="orders-tr">';
        echo '<td class="td-orderID">' . htmlspecialchars($row['orderID']) . '</td>'; 
        echo '<td class="td-buyerName">' . htmlspecialchars($row['buyerFullName']) . '</td>'; 
        echo '<td class="td-totalAmount">' . htmlspecialchars($row['totalAmount']) . '</td>'; 
        echo '<td class="td-itemQty">' . htmlspecialchars($row['totalQuantity']) . '</td>'; 
        echo '<td class="td-productName">' . htmlspecialchars($row['productNames']) . '</td>'; 
        echo '<td class="td-paymentMethod">' . htmlspecialchars($row['paymentMethod']) . '</td>'; 
        echo '<td class="td-orderDate">' . htmlspecialchars($row['formattedOrderDate']) . '</td>'; 
        echo '<td class="td-orderStatus">' . htmlspecialchars($row['orderStatus']) . '</td>'; 
        echo '<td class="td-nextBtn"><i class="fa-solid fa-chevron-right" data-order-id="' . htmlspecialchars($orderID) . '" data-order-status="' . htmlspecialchars($orderStatus) . '"></i></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No orders found.</p>';
}

$stmt->close();
$conn->close();
?>
