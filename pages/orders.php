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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
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
                    $_GET['userID'] = $userID;
                    include_once "../crud/allOrders.php"; 
                ?>
            </div>
        </div>

    </div>
    <script>
    var userID = <?php echo json_encode($userID); ?>;
    const navbarLink1 = document.getElementById('allOrdersBtn');
    const navbarLink2 = document.getElementById('pendingOrdersBtn');
    const navbarLink3 = document.getElementById('toPayOrdersBtn');
    const navbarLink4 = document.getElementById('toDeliverOrdersBtn');
    const navbarLink5 = document.getElementById('completedOrdersBtn');

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
        const allOrdersBtn = document.getElementById("allOrdersBtn");
        if (allOrdersBtn) {
            allOrdersBtn.addEventListener("click", function() {
                fetch('../crud/allOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        // Ensure the orders-tab element exists
                        const ordersTab = document.getElementById("orders-tab");
                        if (!ordersTab) {
                            console.error("Element with id 'orders-tab' not found.");
                            return;
                        }

                        // Ensure the orders-display div exists or create it
                        let ordersDisplay = document.getElementById("orders-display");
                        if (!ordersDisplay) {
                            ordersDisplay = document.createElement("div");
                            ordersDisplay.id = "orders-display";
                            ordersTab.appendChild(ordersDisplay);
                        }

                        // Remove the element with the ID "displayedOrder" if it exists
                        const displayedOrder = document.getElementById("displayedOrder");
                        if (displayedOrder) {
                            displayedOrder.parentNode.removeChild(displayedOrder);
                        }

                        // Clear the content of orders-display
                        while (ordersDisplay.firstChild) {
                            ordersDisplay.removeChild(ordersDisplay.firstChild);
                        }

                        // Append the fetched data to orders-display
                        ordersDisplay.insertAdjacentHTML('beforeend', data);
                    })

                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const pendingOrdersBtn = document.getElementById("pendingOrdersBtn");
        if (pendingOrdersBtn) {
            pendingOrdersBtn.addEventListener("click", function() {
                fetch('../crud/pendingOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        // Ensure the orders-tab element exists
                        const ordersTab = document.getElementById("orders-tab");
                        if (!ordersTab) {
                            console.error("Element with id 'orders-tab' not found.");
                            return;
                        }

                        // Ensure the orders-display div exists or create it
                        let ordersDisplay = document.getElementById("orders-display");
                        if (!ordersDisplay) {
                            ordersDisplay = document.createElement("div");
                            ordersDisplay.id = "orders-display";
                            ordersTab.appendChild(ordersDisplay);
                        }

                        // Remove the element with the ID "displayedOrder" if it exists
                        const displayedOrder = document.getElementById("displayedOrder");
                        if (displayedOrder) {
                            displayedOrder.parentNode.removeChild(displayedOrder);
                        }

                        // Clear the content of orders-display
                        while (ordersDisplay.firstChild) {
                            ordersDisplay.removeChild(ordersDisplay.firstChild);
                        }

                        // Append the fetched data to orders-display
                        ordersDisplay.insertAdjacentHTML('beforeend', data);
                    })

                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const toPayOrdersBtn = document.getElementById("toPayOrdersBtn");
        if (toPayOrdersBtn) {
            toPayOrdersBtn.addEventListener("click", function() {
                fetch('../crud/toPayOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        // Ensure the orders-tab element exists
                        const ordersTab = document.getElementById("orders-tab");
                        if (!ordersTab) {
                            console.error("Element with id 'orders-tab' not found.");
                            return;
                        }

                        // Ensure the orders-display div exists or create it
                        let ordersDisplay = document.getElementById("orders-display");
                        if (!ordersDisplay) {
                            ordersDisplay = document.createElement("div");
                            ordersDisplay.id = "orders-display";
                            ordersTab.appendChild(ordersDisplay);
                        }

                        // Remove the element with the ID "displayedOrder" if it exists
                        const displayedOrder = document.getElementById("displayedOrder");
                        if (displayedOrder) {
                            displayedOrder.parentNode.removeChild(displayedOrder);
                        }

                        // Clear the content of orders-display
                        while (ordersDisplay.firstChild) {
                            ordersDisplay.removeChild(ordersDisplay.firstChild);
                        }

                        // Append the fetched data to orders-display
                        ordersDisplay.insertAdjacentHTML('beforeend', data);
                    })

                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });

    // document.addEventListener("DOMContentLoaded", function() {
    //     const pendingOrdersBtn = document.getElementById("toPayOrdersBtn");
    //     if (toPayOrdersBtn) {
    //         toPayOrdersBtn.addEventListener("click", function() {
    //             fetch('../crud/toPayOrders.php?userID=' + userID)
    //                 .then(response => {
    //                     if (!response.ok) {
    //                         throw new Error('Network response was not ok ' + response.statusText);
    //                     }
    //                     return response.text();
    //                 })
    //                 .then(data => {
    //                     const ordersTable = document.getElementById("orders-table");

    //                     // Clear the content of the table
    //                     ordersTable.innerHTML = '';

    //                     // Append the fetched data to the table
    //                     ordersTable.insertAdjacentHTML('beforeend', data);
    //                 })
    //                 .catch(error => {
    //                     console.error('There was a problem with the fetch operation:', error);
    //                 });
    //         });
    //     }
    // });

    document.addEventListener("DOMContentLoaded", function() {
        const pendingOrdersBtn = document.getElementById("toDeliverOrdersBtn");
        if (toDeliverOrdersBtn) {
            toDeliverOrdersBtn.addEventListener("click", function() {
                fetch('../crud/toDeliverOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        const ordersTable = document.getElementById("orders-table");

                        // Clear the content of the table
                        ordersTable.innerHTML = '';

                        // Append the fetched data to the table
                        ordersTable.insertAdjacentHTML('beforeend', data);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const completedOrdersBtn = document.getElementById("completedOrdersBtn");
        if (completedOrdersBtn) {
            completedOrdersBtn.addEventListener("click", function() {
                fetch('../crud/completeOrders.php?userID=' + userID)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.text();
                    })
                    .then(data => {
                        const ordersTable = document.getElementById("orders-table");

                        // Clear the content of the table
                        ordersTable.innerHTML = '';

                        // Append the fetched data to the table
                        ordersTable.insertAdjacentHTML('beforeend', data);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Add click event listener to all i elements within td-nextBtn class
        document.addEventListener("click", function(event) {
            if (event.target.closest('.td-nextBtn i')) {
                // Get the clicked element
                const iElement = event.target;

                // Retrieve orderID and orderStatus from data attributes
                const orderID = iElement.getAttribute('data-order-id');
                const orderStatus = iElement.getAttribute('data-order-status');

                // Remove the existing table
                const ordersTable = document.getElementById('orders-table');
                if (ordersTable) {
                    ordersTable.remove();
                }

                // You can now use orderID and orderStatus for your desired operation
                if (orderStatus === 'Pending') {
                    console.log('Pending order ID:', orderID);
                    fetch('../crud/seller_orders/displayPendingOrder.php?orderID=' + orderID)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response
                                    .statusText);
                            }
                            return response.text();
                        })
                        .then(data => {
                            const ordersPage = document.getElementById("orders-tab");
                            const preserveElement = document.getElementById("orders-navbar");

                            // Temporarily remove the preserved element
                            if (preserveElement) {
                                ordersPage.removeChild(preserveElement);
                            }

                            // Clear the existing content
                            ordersPage.innerHTML = '';

                            // Append the preserved element back
                            if (preserveElement) {
                                ordersPage.appendChild(preserveElement);
                            }

                            // Append the new content
                            ordersPage.insertAdjacentHTML('beforeend', data);
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                } else if (orderStatus === 'To Pay') {
                    fetch('../crud/seller_orders/displayOrderPayment.php?orderID=' + orderID)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response
                                    .statusText);
                            }
                            return response.text();
                        })
                        .then(data => {
                            const ordersPage = document.getElementById("orders-tab");
                            const preserveElement = document.getElementById("orders-navbar");

                            // Temporarily remove the preserved element
                            if (preserveElement) {
                                ordersPage.removeChild(preserveElement);
                            }

                            // Clear the existing content
                            ordersPage.innerHTML = '';

                            // Append the preserved element back
                            if (preserveElement) {
                                ordersPage.appendChild(preserveElement);
                            }

                            // Append the new content
                            ordersPage.insertAdjacentHTML('beforeend', data);
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        setMinDateTime();
    });

    function setMinDateTime() {
        const etaInput = document.getElementById('eta');
        if (etaInput) {
            // Set the minimum date and time to the current date and time
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            etaInput.min = minDateTime;
        }
    }

    function checkAndSubmitForm(action) {
        const etaInput = document.getElementById('eta');
        if (!etaInput) {
            // If the etaInput element does not exist, return and do nothing
            return;
        }

        setMinDateTime(); // Ensure the min datetime is up to date

        if (etaInput.value === '') {
            etaInput.style.border = '2px solid red';
            Swal.fire({
                title: "Error!",
                text: "Please select an estimated delivery date.",
                icon: "error"
            });
        } else if (new Date(etaInput.value) < new Date(etaInput.min)) {
            etaInput.style.border = '2px solid red';
            Swal.fire({
                title: "Error!",
                text: "The selected date and time cannot be in the past.",
                icon: "error"
            });
        } else {
            etaInput.style.border = '';

            // Set the action value and submit the form
            const form = document.getElementById('payment-approval-form');

            // Create and set the action input value
            let actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;

            form.appendChild(actionInput);
            form.submit();
        }
    }
    </script>
</body>

</html>

<?php
    if(isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
?>