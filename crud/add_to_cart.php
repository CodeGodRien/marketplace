<?php
session_start();
require "../config/dbconn.php";

$productID = $_GET['productID'];
$userID = $_SESSION['userID'];
$page = $_GET['pageID'];

$sql = "SELECT * FROM products WHERE productID = '$productID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$productName = $row['productName'];
$productSellerID = $row['productSellerID'];
$productUnitPrice = $row['productPrice'];

$sql = "SELECT * FROM cart WHERE productID = '$productID'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE productID = '$productID'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = "
    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
    icon: 'success',
    title: '$productName added to cart!'
}); 
    </script>
    ";
    if ($page != "detailed") {
        header("Location: ../pages/customer_dashboard.php");
    } else {
        header("Location: ../pages/product_details.php?productID=$productID");
    }
    exit();
    } else {
        $_SESSION['alert'] = "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Adding to cart failed!',
                text: 'Sum Ting Went Wong.'
          });
        </script>
        ";
    if ($page != "detailed") {
        header("Location: ../pages/customer_dashboard.php");
    } else {
        header("Location: ../pages/product_details.php?productID=$productID");
    }
    exit();
    }
} else {
    $sql = "INSERT INTO cart (userID, productID, sellerID, quantity, unitPrice, timeAdded) VALUES ('$userID', '$productID', '$productSellerID', 1,
    '$productUnitPrice', CURRENT_TIMESTAMP)";

if (mysqli_query($conn, $sql)) {
    $_SESSION['alert'] = "
    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
    icon: 'success',
    title: '$productName added to cart!'
}); 
    </script>
    ";
    if ($page != "detailed") {
        header("Location: ../pages/customer_dashboard.php");
    } else {
        header("Location: ../pages/product_details.php?productID=$productID");
    }
    exit();
} else {
    $_SESSION['alert'] = "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Creation Failed!',
                text: 'Sum Ting Went Wong.'
          });
        </script>
        ";
    if ($page != "detailed") {
        header("Location: ../pages/customer_dashboard.php");
    } else {
        header("Location: ../pages/product_details.php?productID=$productID");
    }
    exit();
}
}
?>