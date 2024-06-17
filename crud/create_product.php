<?php
session_start();
include "../config/dbconn.php";

// Validate and sanitize input data
$productName = validateInput($_POST['productName']);
$productDesc = validateInput($_POST['productDesc']);
$productPrice = validateInput($_POST['productPrice']);
$productStock = validateInput($_POST['productStock']);
$productSellerID = $_SESSION['userID'];

function validateInput($data) {
    $data = trim($data);
    $data = htmlspecialchars($data);
    return $data;
}

// File upload handling
if ($_FILES["productImg"]["error"] === 4) {
    $_SESSION['alert'] = "<script>alert('Image does not exist.');</script>";
    header("Location: ../pages/add_product.php");
    exit();
} else {
    $fileName = $_FILES["productImg"]["name"];
    $fileSize = $_FILES["productImg"]["size"];
    $tmpName = $_FILES["productImg"]["tmp_name"];

    $validImageExtensions = ['jpg', 'jpeg', 'png', 'avif'];
    $imageExtension = pathinfo($fileName, PATHINFO_EXTENSION);

    if (!in_array(strtolower($imageExtension), $validImageExtensions)) {
        $_SESSION['alert'] = "<script>alert('Invalid image extension.')</script>";
        header("Location: ../pages/add_product.php");
        exit();
    } elseif ($fileSize > 1000000) { // 1MB limit
        $_SESSION['alert'] = "<script>alert('Image size is too large')</script>";
        header("Location: ../pages/add_product.php");
        exit();
    } else {
        $newImageName = uniqid() . '.' . $imageExtension;
        $destination = '../product_img/' . $newImageName;

        if (move_uploaded_file($tmpName, $destination)) {
            // Insert product into database
            $sql = "INSERT INTO products (productName, productSellerID, productDesc, productPrice, productStock, productImg) 
                    VALUES ('$productName', '$productSellerID', '$productDesc', '$productPrice', '$productStock', '$newImageName')";

            if (mysqli_query($conn, $sql)) {
                $_SESSION['alert'] = "
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Product Added!',
                            text: 'You can now view your product in the dashboard.'
                        });
                    </script>";
                header("Location: ../pages/add_product.php");
                exit();
            } else {
                $_SESSION['alert'] = "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Creation Failed!',
                            text: 'Something went wrong. Please try again.'
                        });
                    </script>";
                header("Location: ../pages/add_product.php");
                exit();
            }
        } else {
            $_SESSION['alert'] = "<script>alert('Failed to move uploaded file.')</script>";
            header("Location: ../pages/add_product.php");
            exit();
        }
    }
}

?>
