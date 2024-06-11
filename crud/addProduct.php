<?php
session_start();
require "../config/dbconn.php";

$userID = $_SESSION['userID'];
$productName = $conn->real_escape_string($_POST['productName']);
$productDescription = $conn->real_escape_string($_POST['productDesc']);
$categories = $_POST['categories'];
$variationsData = json_decode($_POST['variationsData'], true);
$paymentMethod = $_POST['paymentMethod'];


if($_FILES["productImg"]["error"] === 4) {
    $_SESSION['alert'] = "<script>
    swal({
        title: 'Error!',
        text: 'Image not found',
        icon: 'error',
    });
    </script>";
    header("Location: ../pages/add_product.php");
    exit();
} else {
    $fileName = $_FILES["productImg"]["name"];
    $fileSize = $_FILES["productImg"]["size"];
    $tmpName = $_FILES["productImg"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png', 'avif'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if(!in_array($imageExtension, $validImageExtension)) {
        echo "<script>console.log('problima');</script>";
    }
    else if($fileSize > 10000000) {
        echo "<script>console.log('lake file mo');</script>";
    }
    else {
        $newImageName = uniqid() . '.' . $imageExtension;
        move_uploaded_file($tmpName, '../product_img/' . $newImageName);
        $sql = "INSERT INTO products (productSellerID, productName, productDesc, productImg) VALUES ('$userID', '$productName', '$productDescription', '$newImageName')";
        $result = mysqli_query($conn, $sql);
        $productID = mysqli_insert_id($conn);
        foreach ($_FILES['images']['name'] as $key => $fileName) {
            $fileSize = $_FILES['images']['size'][$key];
            $tmpName = $_FILES['images']['tmp_name'][$key];
    
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));
            
            if (!in_array($imageExtension, $validImageExtension)) {
                echo "<script>console.log('Invalid image extension for file: $fileName');</script>";
            } else if ($fileSize > 10000000) {
                echo "<script>console.log('File size exceeds limit for file: $fileName');</script>";
            } else {
                $newImageName = uniqid() . '.' . $imageExtension;
                if (move_uploaded_file($tmpName, '../product_img/' . $newImageName)) {
                    $sql = "INSERT INTO product_img (userID, productID, productImg) VALUES ('$userID', '$productID', '$newImageName')";
                    $result = mysqli_query($conn, $sql);
                }
            }
        }         
                
if ($result) {
    $sql = "INSERT INTO product_img (userID, productID, productImg) VALUES ('$userID', '$productID', '$newImageName')";
    $result = mysqli_query($conn, $sql);
    
    foreach ($categories as $category) {
        switch ($category) {
            case "Electronics":
                $sql = "INSERT INTO product_categories (productID, categoryID) VALUES ('$productID', 1)";
                $result = mysqli_query($conn, $sql);
                break;
            case "Clothing":
                $sql = "INSERT INTO product_categories (productID, categoryID) VALUES ('$productID', 2)";
                $result = mysqli_query($conn, $sql);
                break;
            case "Jewelry":
                $sql = "INSERT INTO product_categories (productID, categoryID) VALUES ('$productID', 3)";
                $result = mysqli_query($conn, $sql);
                break;
            case "Food":
                $sql = "INSERT INTO product_categories (productID, categoryID) VALUES ('$productID', 4)";
                $result = mysqli_query($conn, $sql);
                break;
            case "Beverages":
                $sql = "INSERT INTO product_categories (productID, categoryID) VALUES ('$productID', 5)";
                $result = mysqli_query($conn, $sql);
                break;
        }
    }

    foreach ($paymentMethod as $method) {
        switch ($method) {
            case "GCash":
                $sql = "INSERT INTO payment_method (methodID, productID) VALUES ( 1, '$productID')";
                $result = mysqli_query($conn, $sql);
                break;
            case "COD":
                $sql = "INSERT INTO payment_method (methodID, productID) VALUES (2, '$productID')";
                $result = mysqli_query($conn, $sql);
                break;
        }
    }
    $lowestPrice = PHP_FLOAT_MAX;
    foreach ($variationsData as $variation) {
        $variationName = $variation['variation'];
        $size = $variation['size'];
        $price = $variation['price'];
        $quantity = $variation['quantity'];
        $isMadeToOrder = $variation['isMadeToOrder'];
        
        $sql = "INSERT INTO variations (productID, variationName, variationSize, variationPrice, variationQty, isMadeToOrder) VALUES ('$productID', '$variationName', '$size', '$price', '$quantity', '$isMadeToOrder')";
        $result = mysqli_query($conn, $sql);

        if ($price < $lowestPrice) {
            $lowestPrice = $price;
        }
    }
    
    $sql = "UPDATE products SET productPrice = '$lowestPrice' WHERE productID = '$productID'";
    $result = mysqli_query($conn, $sql);
    
    header("Location: ../pages/add_product.php");
}
    }
}


?>