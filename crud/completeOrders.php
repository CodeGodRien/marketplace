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
            orders.sellerID = '$userID' AND orders.orderStatus = 'Complete'
        GROUP BY 
            orders.orderID;";
            
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<tr id="orders-tr">
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Amount</th>
                        <th># of Items</th>
                        <th>Product</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>';
    foreach ($result as $row) {
        echo '<tr class="orders-tr">';
        echo '<td class="td-orderID">' . $row['orderID'] . '</td>'; 
        echo '<td class="td-buyerName">' . $row['buyerFullName'] . '</td>'; 
        echo '<td class="td-totalAmount">' . $row['totalAmount'] . '</td>'; 
        echo '<td class="td-itemQty">' . $row['totalQuantity'] . '</td>'; 
        echo '<td class="td-productName">' . $row['productNames'] . '</td>'; 
        echo '<td class="td-paymentMethod">' . $row['paymentMethod'] . '</td>'; 
        echo '<td class="td-orderDate">' . $row['formattedOrderDate'] . '</td>'; 
        echo '<td class="td-orderStatus">' . $row['orderStatus'] . '</td>'; 
        echo '<td class="td-nextBtn"><i class="fa-solid fa-chevron-right"></i></td>';
        echo '</tr>';
    }
} else {
    echo '<p>No orders found.</p>';
}
?>