<?php
session_start();
require "../config/dbconn.php";

$orderID = isset($_POST['orderID']) ? $_POST['orderID'] : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;
$eta = isset($_POST['eta']) ? $_POST['eta'] : null;

if ($orderID && $action) {
    if ($action === 'approve') {
        if ($eta) {
            $sql = "UPDATE orders SET paymentStatus = 'Payment Verified', orderStatus = 'To Receive', deliveryDate = '$eta' WHERE orderID = '$orderID'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
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
        }
        
    } else {
        $sql = "UPDATE orders SET paymentStatus = 'Payment Not Verified', orderStatus = 'Completed', detailedStatus = 'Order Cancelled', paymentStatus = 'Payment not verified' WHERE orderID = '$orderID'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
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
    }
    header("Location: ../pages/orders.php");
    
}