<?php
session_start();
require "../config/dbconn.php";

$userID = $_SESSION['userID'];
$orderID = $_POST['orderID'];

if($_FILES["paymentProof"]["error"] === 4) {
    $_SESSION['alert'] = "<script>
    swal({
        title: 'Error!',
        text: 'Image not found',
        icon: 'error',
    });
    </script>";
    header("Location: ../pages/payment.php?orderID=$orderID");
    exit();
} else {
    $fileName = $_FILES["paymentProof"]["name"];
    $fileSize = $_FILES["paymentProof"]["size"];
    $tmpName = $_FILES["paymentProof"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png', 'avif'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if(!in_array($imageExtension, $validImageExtension)) {
        $_SESSION['alert'] = "<script>
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
    });
        Toast.fire({
          icon: 'error',
          title: 'Invalid file extension'
    });
        </script>";
    }
    else if($fileSize > 10000000) {
        $_SESSION['alert'] = "<script>
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
    });
        Toast.fire({
          icon: 'error',
          title: 'Invalid file size'
    });
        </script>";
    }
    else {
        $newImageName = uniqid() . '.' . $imageExtension;
        move_uploaded_file($tmpName, '../payment_proof/' . $newImageName);
        $sql = "UPDATE orders SET paymentImg = '$newImageName', paymentStatus = 'Waiting for seller confirmation' WHERE orderID = '$orderID'";
        $result = mysqli_query($conn, $sql);
        $_SESSION['alert'] = "<script>
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
          title: 'Payment submitted'
    });
        </script>";
        header("Location: ../pages/my_orders.php");
        exit();
    }
}