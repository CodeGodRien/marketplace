<?php
session_start();
require '../config/dbconn.php';
if (!isset($_SESSION['userID'])) {
    header("Location: ../pages/index.php");
} else {
    $userID = $_SESSION['userID'];
    $sql = "SELECT * FROM users WHERE userID = '$userID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $vStatus = $row['verify_status'];
    if ($vStatus === 0) {
        header("Location: ../pages/index.php");
    }
}  
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
    <?php
        include_once '../components/navbar.php';

    ?>
    
    <div class="content">
        <div class="searchbar">
            <div class="searchbar-text"><input type="text" placeholder="Search..." id="search-product-input"></div>
            <div class="searchbar-button" id="search-product-button">
                <div><i class="fa-solid fa-magnifying-glass"></i></div>
            </div>
        </div>
        <div class="products-div">
            <div class="product-display">

                <?php
                $sql = "SELECT * FROM products";
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
                <a href='../pages/product_details.php?productID=$productID'><div class='details-button'>More details</div></a>
                <div class='cart-button' data-productid='$productID'><i class='fa-solid fa-cart-shopping' style='color: #ffffff;'></i></div>
                <div id='cartModal_$productID' class='modal' data-productid='$productID'>
                    <div class='modal-content'>
                        <span class='close' data-productid='$productID'>&times;</span>
                        <h2>Add to Cart</h2>
                        <p>Your cart is currently empty.</p>
                        <!-- Add more cart details here -->
                    </div>
                </div>
            </div>
        </div>
    </div>";


                    }
                }
            ?>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all elements with class "cart-button"
        var buttons = document.querySelectorAll(".cart-button");

        // Attach click event listener to each button
        buttons.forEach(function(btn) {
            btn.addEventListener("click", function() {
                // Extract productID from the button's data-productid attribute
                var productID = btn.getAttribute("data-productid");

                // Open the corresponding modal
                openModal(productID);
            });
        });

        // Get all elements with class "close"
        var closeButtons = document.querySelectorAll(".close");

        // Attach click event listener to each close button
        closeButtons.forEach(function(closeBtn) {
            closeBtn.addEventListener("click", function() {
                // Extract productID from the close button's data-productid attribute
                var productID = closeBtn.getAttribute("data-productid");

                // Close the corresponding modal
                closeModal(productID);
            });
        });

        // Close modal when clicking outside of it
        window.addEventListener("click", function(event) {
            if (event.target.classList.contains("modal")) {
                var productID = event.target.getAttribute("data-productid");
                closeModal(productID);
            }
        });
    });

    // Function to open modal
    function openModal(productID) {
        var modal = document.getElementById("cartModal_" + productID);
        if (modal) {
            modal.style.display = "flex";
        }
    }

    // Function to close modal
    function closeModal(productID) {
        var modal = document.getElementById("cartModal_" + productID);
        if (modal) {
            modal.style.display = "none";
        }
    }
    </script>

</body>

</html>

<?php
    if(isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
?>