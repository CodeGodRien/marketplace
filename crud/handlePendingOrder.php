<?php
session_start();
require "../config/dbconn.php";
$orderID = $_GET['orderID'];
$action = $_GET['action'];

if ($action == 'approve') {

  $sql = "SELECT paymentMethod FROM orders WHERE orderID = '$orderID'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $paymentMethod = $row['paymentMethod'];
  
  if ($paymentMethod == 'Cash') {
    $sql = "UPDATE orders SET orderStatus = 'To Receive' WHERE orderID = '$orderID'";
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
          title: 'Order #{$orderID} Accepted'
        });
    </script>
    ";
  }
  } else {
    $sql = "UPDATE orders SET orderStatus = 'To Pay', paymentStatus = 'Awaiting Payment' WHERE orderID = '$orderID'";
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
          title: 'Order #{$orderID} Accepted'
        });
    </script>
    ";
  }
  }
  
} else {
  $sql = "UPDATE orders SET orderStatus = 'Completed', detailedStatus = 'Cancelled' WHERE orderID = '$orderID'";
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
          title: 'Order #{$orderID} Cancelled'
        });
    </script>
    ";
  }
}


header("Location: ../pages/orders.php");

?>