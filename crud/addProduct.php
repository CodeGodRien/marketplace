<?php
session_start();
require "../config/dbconn.php";

$userID = $_SESSION['userID'];
$productName = $conn->real_escape_string($_POST['productName']);
$productDescription = $conn->real_escape_string($_POST['productDesc']);
$categories = $_POST['categories'];
$variationsData = json_decode($_POST['variationsData'], true);
$paymentMethod = $_POST['paymentMethod'];

if (empty(trim($_POST['productName'])) || empty(trim($_POST['productDesc']))) {
    echo 'Make sure to add a product name and a description for your product';
    exit();
}

if ($_FILES["productImg"]["error"] === 4) {
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

    if (!in_array($imageExtension, $validImageExtension)) {
        echo "<script>console.log('Invalid image extension');</script>";
    } else if ($fileSize > 10000000) {
        echo "<script>console.log('File size exceeds limit');</script>";
    } else {
        $newImageName = uniqid() . '.' . $imageExtension;
        move_uploaded_file($tmpName, '../product_img/' . $newImageName);

        // Insert product
        $sql = "INSERT INTO products (productSellerID, productName, productDesc, productImg) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $userID, $productName, $productDescription, $newImageName);
        $stmt->execute();
        $productID = $stmt->insert_id;

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
                    $sql = "INSERT INTO product_img (userID, productID, productImg) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sis', $userID, $productID, $newImageName);
                    $stmt->execute();
                }
            }
        }

        foreach ($categories as $category) {
            $categoryID = 0;
            switch ($category) {
                case "Electronics":
                    $categoryID = 1;
                    break;
                case "Clothing":
                    $categoryID = 2;
                    break;
                case "Jewelry":
                    $categoryID = 3;
                    break;
                case "Food":
                    $categoryID = 4;
                    break;
                case "Beverages":
                    $categoryID = 5;
                    break;
            }
            if ($categoryID) {
                $sql = "INSERT INTO product_categories (productID, categoryID) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii', $productID, $categoryID);
                $stmt->execute();
            }
        }

        foreach ($paymentMethod as $method) {
            $methodID = 0;
            switch ($method) {
                case "GCash":
                    $methodID = 1;
                    break;
                case "COD":
                    $methodID = 2;
                    break;
            }
            if ($methodID) {
                $sql = "INSERT INTO payment_method (methodID, productID) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ii', $methodID, $productID);
                $stmt->execute();
            }
        }

        $lowestPrice = PHP_FLOAT_MAX;
        foreach ($variationsData as $variation) {
            $variationName = $variation['variation'];
            $size = $variation['size'];
            $price = $variation['price'];
            $quantity = $variation['quantity'];
            $isMadeToOrder = $variation['isMadeToOrder'];

            $sql = "INSERT INTO variations (productID, variationName, variationSize, variationPrice, variationQty, isMadeToOrder) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('issdis', $productID, $variationName, $size
            , $price, $quantity, $isMadeToOrder);
            $stmt->execute();

            if ($price < $lowestPrice) {
                $lowestPrice = $price;
            }
        }

        $sql = "UPDATE products SET productPrice = ? WHERE productID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('di', $lowestPrice, $productID);
        $stmt->execute();

        header("Location: ../pages/add_product.php");
        exit();
    }
}
?>
