<?php
session_start();
require '../config/dbconn.php';
if (!isset($_SESSION['userID'])) {
    header("Location: ../pages/index.php");
} else {
    $userID = $_SESSION['userID'];
    $sql = "SELECT * FROM users WHERE userID = '$userID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $vStatus = $row['verify_status'];
    if ($vStatus == 0) {
        header("Location: ../pages/index.php");
    }
    $orderStatus = $_GET['orderStatus']; 
    $orderID = $_GET['orderID'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>

<body>
    <div class="seller-dashboard-container">
        <?php 
        include_once '../components/seller_sidebar.php'; 
        $sql = "SELECT * FROM orders WHERE sellerID = '$userID'";
        $result = mysqli_query($conn, $sql);
        $totalOrders = mysqli_num_rows($result);
        $sql = "SELECT * FROM orders WHERE sellerID = '$userID' AND orderStatus = 'Pending'";
        $result = mysqli_query($conn, $sql);
        $totalPendingOrders = mysqli_num_rows($result);
        $sql = "SELECT * FROM orders WHERE sellerID = '$userID' AND orderStatus = 'To Pay'";
        $result = mysqli_query($conn, $sql);
        $totalToPayOrders = mysqli_num_rows($result);
        $sql = "SELECT * FROM orders WHERE sellerID = '$userID' AND orderStatus = 'To Receive'";
        $result = mysqli_query($conn, $sql);
        $totalToReceiveOrders = mysqli_num_rows($result);
        $sql = "SELECT * FROM orders WHERE sellerID = '$userID' AND orderStatus = 'Completed'";
        $result = mysqli_query($conn, $sql);
        $totalCompletedOrders = mysqli_num_rows($result);
        ?>
        <div class="inner-dashboard-container" id="orders-tab">
            <div class="my-orders-navbar" id="orders-navbar">
                <div class="my-orders-nav-link" id="allOrdersBtn">
                    <div class="my-orders-nav-item">All
                        <span id="allCount">
                            <?php 
                        if ($totalOrders > 0) {
                            echo "(" . $totalOrders . ")";
                        }
                        ?>
                        </span>
                    </div>
                </div>
                <div class="my-orders-nav-link" id="pendingOrdersBtn">
                    <div class="my-orders-nav-item">Pending
                        <span id="pendingCount">
                            <?php 
                        if ($totalPendingOrders > 0) {
                            echo "(" . $totalPendingOrders . ")";
                        }
                        ?>
                        </span>
                    </div>
                </div>
                <div class="my-orders-nav-link" id="toPayOrdersBtn">
                    <div class="my-orders-nav-item">To Pay
                        <span id="toPayCount">
                            <?php 
                        if ($totalToPayOrders > 0) {
                            echo "(" . $totalToPayOrders . ")";
                        }
                        ?>
                        </span>
                    </div>
                </div>
                <div class="my-orders-nav-link" id="toDeliverOrdersBtn">
                    <div class="my-orders-nav-item">To Deliver
                        <span id="toReceiveCount">
                            <?php 
                        if ($totalToReceiveOrders > 0) {
                            echo "(" . $totalToReceiveOrders . ")";
                        }
                        ?>
                        </span>
                    </div>
                </div>
                <div class="my-orders-nav-link" id="completedOrdersBtn">
                    <div class="my-orders-nav-item">Completed
                        <span id="completedCount">
                            <?php 
                        if ($totalCompletedOrders > 0) {
                            echo "(" . $totalCompletedOrders . ")";
                        }
                        ?>
                        </span>
                    </div>
                </div>
            </div>
            <div id="orders-display">
                <?php
                if ($orderStatus == 'Pending') {
                    include_once "../crud/seller_orders/displayPendingOrder.php?orderID=$orderID";
                }
                ?>
            </div>
        </div>

    </div>
    <script>

    </script>
</body>

</html>

<?php
    if(isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
?>