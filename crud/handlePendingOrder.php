<?php
session_start();
require "../config/dbconn.php";

$orderID = isset($_GET['orderID']) ? $_GET['orderID'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;

if ($orderID && $action) {
    if ($action == 'approve') {
        $sql = "SELECT paymentMethod FROM orders WHERE orderID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $paymentMethod = $row['paymentMethod'];

            if ($paymentMethod == 'Cash') {
                $sql = "UPDATE orders SET orderStatus = 'To Receive' WHERE orderID = ?";
            } else {
                $sql = "UPDATE orders SET orderStatus = 'To Pay', paymentStatus = 'Awaiting Payment' WHERE orderID = ?";
            }

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
                        title: 'Order #{$orderID} Accepted'
                    });
                </script>
            ";
        }
    } elseif ($action == 'cancel') {
        $sql = "UPDATE orders SET orderStatus = 'Completed', detailedStatus = 'Cancelled' WHERE orderID = ?";
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
                    title: 'Order #{$orderID} Cancelled'
                });
            </script>
        ";
    }

    header("Location: ../pages/orders.php");
    exit();
} else {
    $_SESSION['alert'] = "Invalid action or order ID.";
    header("Location: ../pages/orders.php");
    exit();
}
?>
