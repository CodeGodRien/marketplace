<?php
session_start();
require '../config/dbconn.php';
$userID = $_SESSION['userID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styles/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    *::-webkit-scrollbar {
        display: none;
    }
    </style>
</head>

<body>
    <div class="seller-dashboard-container">
        <?php include_once '../components/seller_sidebar.php'; ?>
        <div class="inner-dashboard-container">
            <div class="seller-products-container">
                <h1>Your Products</h1>
                <div class="manage-product-display">
                    <?php
                $sql = "SELECT * FROM products WHERE productSellerID = '$userID'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $productID = $row['productID'];
                        $productName = $row['productName'];
                        $productDesc = $row['productDesc'];
                        $productPrice = $row['productPrice'];
                        $productImg = $row['productImg'];
                        echo "<div class='item'>
                            <div class='item-upper'>
                                <img src='../product_img/$productImg' class='product-img' draggable='false'>
                            </div>
                            <div class='item-lower'>
                                <div class='product-name'>$productName</div>
                                <div class='product-desc'>$productDesc</div>
                                <div class='price-rating'>
                                    <div class='price'>₱$productPrice</div>
                                    <div class='rating'>
                                        <div class='stars'>
                                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                                        </div>
                                        <div class='numeric-rating'>4.9</div>
                                    </div>
                                </div>
                                <div class='details-cart'>
                                    <a href='../pages/product_details.php?productID=$productID'><div class='details-button'>Edit</div></a>
                                    <a href='../crud/add_to_cart.php?productID=$productID'><div class='cart-button'><i class='fa-solid fa-trash' style='color: #ffffff;'></i></div></a>
                                </div>
                            </div>
                        </div>";
                    }
                }
            ?>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
</body>

</html>

<?php
    if(isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
?>