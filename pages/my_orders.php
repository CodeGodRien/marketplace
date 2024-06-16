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

    *::-webkit-scrollbar {
        display: none;
    }
    </style>
</head>

<body>
    <?php
        include_once '../components/navbar.php';
        $sql = "SELECT * FROM orders WHERE userID = '$userID'";
        $result = mysqli_query($conn, $sql);
        $totalOrders = mysqli_num_rows($result);
        $sql = "SELECT * FROM orders WHERE userID = '$userID' AND orderStatus = 'Pending'";
        $result = mysqli_query($conn, $sql);
        $totalPendingOrders = mysqli_num_rows($result);
        $sql = "SELECT * FROM orders WHERE userID = '$userID' AND orderStatus = 'To Pay'";
        $result = mysqli_query($conn, $sql);
        $totalToPayOrders = mysqli_num_rows($result);
        $sql = "SELECT * FROM orders WHERE userID = '$userID' AND orderStatus = 'To Receive'";
        $result = mysqli_query($conn, $sql);
        $totalToReceiveOrders = mysqli_num_rows($result);
        $sql = "SELECT * FROM orders WHERE userID = '$userID' AND orderStatus = 'Completed'";
        $result = mysqli_query($conn, $sql);
        $totalCompletedOrders = mysqli_num_rows($result);
        
    ?>
    <div class="content" id="my-orders-page">
        <div class="my-orders-navbar" id="my-orders-navbar">
            <div class="my-orders-nav-link" id="allMyOrdersBtn">
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
            <div class="my-orders-nav-link" id="myPendingOrdersBtn">
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
            <div class="my-orders-nav-link" id="myToPayOrdersBtn">
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
            <div class="my-orders-nav-link" id="myToReceiveOrdersBtn">
                <div class="my-orders-nav-item">To Receive
                    <span id="toReceiveCount">
                        <?php 
                        if ($totalToReceiveOrders > 0) {
                            echo "(" . $totalToReceiveOrders . ")";
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="my-orders-nav-link" id="myCompletedOrdersBtn">
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

        <?php
        $_GET['userID'] = $userID;
        include_once '../crud/allMyOrders.php';
    ?>

        <div class="my-orders-display hidden" id="pending-my-orders">
            <div class="orders-details">
                <div class="orders-details-row">
                    <div class="left-details-row"><i class="fa-solid fa-store"></i><strong>Potato Corner</strong></div>
                    <div class="right-details-row">Pending</div>
                </div>
            </div>
            <div class="orders-items">
                <div class="orders-product-display">
                    <div class="left-product-display">
                        <div class="order-product-img-container">
                            <img src="../product_img/6664940cc6ce2.jpeg">
                        </div>
                        <div class="order-product-details">
                            <span>French Fries</span>
                            <span>Variation: Sour Cream</span>
                            <span>Size: Tera</span>
                            <span>x1</span>
                        </div>
                    </div>
                    <div class="right-product-display"><i class="fa-solid fa-peso-sign"></i>69</div>
                </div>
            </div>
            <div class="order-item-total">
                <div class="upper-order-item-total">Order Total: <span class="order-total"><i
                            class="fa-solid fa-peso-sign"></i>69</span>
                </div>
            </div>
        </div>
        <div class="my-orders-display hidden" id="to-pay-my-orders">
            <div class="orders-details">
                <div class="orders-details-row">
                    <div class="left-details-row"><i class="fa-solid fa-store"></i><strong>Potato Corner</strong></div>
                    <div class="right-details-row">To Pay</div>
                </div>
            </div>
            <div class="orders-items">
                <div class="orders-product-display">
                    <div class="left-product-display">
                        <div class="order-product-img-container">
                            <img src="../product_img/6664940cc6ce2.jpeg">
                        </div>
                        <div class="order-product-details">
                            <span>French Fries</span>
                            <span>Variation: Sour Cream</span>
                            <span>Size: Tera</span>
                            <span>x1</span>
                        </div>
                    </div>
                    <div class="right-product-display"><i class="fa-solid fa-peso-sign"></i>69</div>
                </div>
            </div>
            <div class="order-item-total">
                <div class="left-order-total">
                    <p>Order Status: Pending for Seller Confirmation</p>
                    <p>Order Placed: </p>
                </div>
                <div class="right-order-total">
                    <div class="upper-order-item-total">
                        Order Total: <span class="order-total"><i class="fa-solid fa-peso-sign"></i>200.00</span>
                    </div>
                    <div class="lower-order-item-total">
                        <a href="" class="rate-product-link">
                            <div class="rate-button">Pay</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script>
    const allMyOrdersBtn = document.getElementById("allMyOrdersBtn");
    const myPendingOrdersBtn = document.getElementById("myPendingOrdersBtn");
    const myToPayOrdersBtn = document.getElementById("myToPayOrdersBtn");
    const myToReceiveOrdersBtn = document.getElementById("myToReceiveOrdersBtn");
    const myCompletedOrdersBtn = document.getElementById("myCompletedOrdersBtn");
    var userID = <?php echo json_encode($userID); ?>;
    const navbarLink1 = document.getElementById('allMyOrdersBtn');
    const navbarLink2 = document.getElementById('myPendingOrdersBtn');
    const navbarLink3 = document.getElementById('myToPayOrdersBtn');
    const navbarLink4 = document.getElementById('myToReceiveOrdersBtn');
    const navbarLink5 = document.getElementById('myCompletedOrdersBtn');

    document.addEventListener("DOMContentLoaded", function() {
        navbarLink1.style.borderBottom = "5px solid #3182CE";
        navbarLink1.style.color = "#3182CE";
    });

    navbarLink1.addEventListener("click", function() {
        navbarLink1.style.borderBottom = "5px solid #3182CE";
        navbarLink1.style.color = "#3182CE";
        navbarLink2.style.borderBottom = "none";
        navbarLink2.style.color = "black";
        navbarLink3.style.borderBottom = "none";
        navbarLink3.style.color = "black";
        navbarLink4.style.borderBottom = "none";
        navbarLink4.style.color = "black";
        navbarLink5.style.borderBottom = "none";
        navbarLink5.style.color = "black";
    });

    navbarLink2.addEventListener("click", function() {
        navbarLink2.style.borderBottom = "5px solid #3182CE";
        navbarLink2.style.color = "#3182CE";
        navbarLink1.style.borderBottom = "none";
        navbarLink1.style.color = "black";
        navbarLink3.style.borderBottom = "none";
        navbarLink3.style.color = "black";
        navbarLink4.style.borderBottom = "none";
        navbarLink4.style.color = "black";
        navbarLink5.style.borderBottom = "none";
        navbarLink5.style.color = "black";
    });

    navbarLink3.addEventListener("click", function() {
        navbarLink3.style.borderBottom = "5px solid #3182CE";
        navbarLink3.style.color = "#3182CE";
        navbarLink1.style.borderBottom = "none";
        navbarLink1.style.color = "black";
        navbarLink2.style.borderBottom = "none";
        navbarLink2.style.color = "black";
        navbarLink4.style.borderBottom = "none";
        navbarLink4.style.color = "black";
        navbarLink5.style.borderBottom = "none";
        navbarLink5.style.color = "black";
    });

    navbarLink4.addEventListener("click", function() {
        navbarLink4.style.borderBottom = "5px solid #3182CE";
        navbarLink4.style.color = "#3182CE";
        navbarLink1.style.borderBottom = "none";
        navbarLink1.style.color = "black";
        navbarLink2.style.borderBottom = "none";
        navbarLink2.style.color = "black";
        navbarLink3.style.borderBottom = "none";
        navbarLink3.style.color = "black";
        navbarLink5.style.borderBottom = "none";
        navbarLink5.style.color = "black";
    });

    navbarLink5.addEventListener("click", function() {
        navbarLink5.style.borderBottom = "5px solid #3182CE";
        navbarLink5.style.color = "#3182CE";
        navbarLink1.style.borderBottom = "none";
        navbarLink1.style.color = "black";
        navbarLink2.style.borderBottom = "none";
        navbarLink2.style.color = "black";
        navbarLink3.style.borderBottom = "none";
        navbarLink3.style.color = "black";
        navbarLink4.style.borderBottom = "none";
        navbarLink4.style.color = "black";
    });

    document.addEventListener("DOMContentLoaded", function() {
        const allMyOrdersBtn = document.getElementById("allMyOrdersBtn");
        if (allMyOrdersBtn) {
            allMyOrdersBtn.addEventListener("click", function() {
                fetch('../crud/allMyOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response
                                .statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        const myOrdersPage = document.getElementById("my-orders-page");
                        const preserveElement = document.getElementById("my-orders-navbar");

                        // Temporarily remove the preserved element
                        if (preserveElement) {
                            myOrdersPage.removeChild(preserveElement);
                        }

                        // Clear the existing content
                        myOrdersPage.innerHTML = '';

                        // Append the preserved element back
                        if (preserveElement) {
                            myOrdersPage.appendChild(preserveElement);
                        }

                        // Append the new content
                        myOrdersPage.insertAdjacentHTML('beforeend', data);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const myPendingOrdersBtn = document.getElementById("myPendingOrdersBtn");
        if (myPendingOrdersBtn) {
            myPendingOrdersBtn.addEventListener("click", function() {
                fetch('../crud/pendingMyOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response
                                .statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        const myOrdersPage = document.getElementById("my-orders-page");
                        const preserveElement = document.getElementById("my-orders-navbar");

                        // Temporarily remove the preserved element
                        if (preserveElement) {
                            myOrdersPage.removeChild(preserveElement);
                        }

                        // Clear the existing content
                        myOrdersPage.innerHTML = '';

                        // Append the preserved element back
                        if (preserveElement) {
                            myOrdersPage.appendChild(preserveElement);
                        }

                        // Append the new content
                        myOrdersPage.insertAdjacentHTML('beforeend', data);

                        const productCount = document.getElementById("product-count").textContent;
                        const pendingCount = document.getElementById("pendingCount");
                        pendingCount.textContent = `(${productCount})`;
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const myToPayOrdersBtn = document.getElementById("myToPayOrdersBtn");
        if (myToPayOrdersBtn) {
            myToPayOrdersBtn.addEventListener("click", function() {
                fetch('../crud/toPayMyOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response
                                .statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        const myOrdersPage = document.getElementById("my-orders-page");
                        const preserveElement = document.getElementById("my-orders-navbar");

                        // Temporarily remove the preserved element
                        if (preserveElement) {
                            myOrdersPage.removeChild(preserveElement);
                        }

                        // Clear the existing content
                        myOrdersPage.innerHTML = '';

                        // Append the preserved element back
                        if (preserveElement) {
                            myOrdersPage.appendChild(preserveElement);
                        }

                        // Append the new content
                        myOrdersPage.insertAdjacentHTML('beforeend', data);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const myToReceiveOrdersBtn = document.getElementById("myToReceiveOrdersBtn");
        if (myToReceiveOrdersBtn) {
            myToReceiveOrdersBtn.addEventListener("click", function() {
                fetch('../crud/toReceiveMyOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response
                                .statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        const myOrdersPage = document.getElementById("my-orders-page");
                        const preserveElement = document.getElementById("my-orders-navbar");

                        // Temporarily remove the preserved element
                        if (preserveElement) {
                            myOrdersPage.removeChild(preserveElement);
                        }

                        // Clear the existing content
                        myOrdersPage.innerHTML = '';

                        // Append the preserved element back
                        if (preserveElement) {
                            myOrdersPage.appendChild(preserveElement);
                        }

                        // Append the new content
                        myOrdersPage.insertAdjacentHTML('beforeend', data);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        if (myCompletedOrdersBtn) {
            myCompletedOrdersBtn.addEventListener("click", function() {
                fetch('../crud/completeMyOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response
                                .statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        const myOrdersPage = document.getElementById("my-orders-page");
                        const preserveElement = document.getElementById("my-orders-navbar");

                        // Temporarily remove the preserved element
                        if (preserveElement) {
                            myOrdersPage.removeChild(preserveElement);
                        }

                        // Clear the existing content
                        myOrdersPage.innerHTML = '';

                        // Append the preserved element back
                        if (preserveElement) {
                            myOrdersPage.appendChild(preserveElement);
                        }

                        // Append the new content
                        myOrdersPage.insertAdjacentHTML('beforeend', data);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });
    </script>
</body>

</html>

<?php
    if(isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
?>