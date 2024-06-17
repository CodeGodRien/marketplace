<?php
session_start();
require "../config/dbconn.php";

$orderID = isset($_POST['orderID']) ? $_POST['orderID'] : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;
$eta = isset($_POST['eta']) ? $_POST['eta'] : null;

if ($orderID && $action) {
    if ($action === 'approve') {
        if ($eta) {
            // Update query with prepared statement for security
            $sql = "UPDATE orders SET paymentStatus = 'Payment Verified', orderStatus = 'To Receive', deliveryDate = ? WHERE orderID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $eta, $orderID);
            $stmt->execute();
            $stmt->close();

            $_SESSION['alert'] = "
                <script>
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Verified Payment for Order #{$orderID}'
                    });
                </script>
            ";
        }
    } elseif ($action === 'cancel') {
        // Update query for order cancellation with prepared statement
        $sql = "UPDATE orders SET paymentStatus = 'Payment Not Verified', orderStatus = 'Completed', detailedStatus = 'Order Cancelled' WHERE orderID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
        $stmt->close();

        $_SESSION['alert'] = "
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Cancelled Order #{$orderID}'
                });
            </script>
        ";
    }

    header("Location: ../pages/orders.php");
    exit();
}
?>
