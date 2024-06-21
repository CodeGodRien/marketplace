<?php
session_start();
require '../config/dbconn.php';

// Check if user is logged in and verified
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

// Fetch products based on category
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$sql = "SELECT * FROM products";
if ($category !== 'all') {
    $sql .= " WHERE category = '$category'";
}
$result = mysqli_query($conn, $sql);
$products = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');

        *::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body>
    <div class="navbar-marketplace">
        <div class="navbar-left">
            <a href="../pages/customer_dashboard.php">
                <div class="nav-div">Home</div>
            </a>
            <nav>
                <ul class="navbar">
                    <li class="nav-item dropdown">
                        <a href="#" class="dropbtn">Categories</a>
                        <div class="dropdown-content">
                            <a href="#" data-category="all">All</a>
                            <a href="#" data-category="food">Food</a>
                            <a href="#" data-category="accessories">Accessories</a>
                            <a href="#" data-category="fashion">Fashion</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <a href="../pages/my_orders.php">
                <div class="nav-div">My Orders</div>
            </a>
            <a href="../pages/about_us.php">
                <div class="nav-div">About Us</div>
            </a>
            <a href="../pages/contact_us.php">
                <div class="nav-div">Contact Us</div>
            </a>
            <a href="../pages/settings.php">
                <div class="nav-div">Settings</div>
            </a>
            <a href="../pages/manage_product.php">
                <div class="nav-div">Seller Dashboard</div>
            </a>
        </div>
        <div class="navbar-right">
            <p></p>
            <a href="../pages/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
    </div>

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
                if (!empty($products)) {
                    foreach ($products as $product) {
                        $productID = $product['productID'];
                        $productName = $product['productName'];
                        $productDesc = $product['productDesc'];
                        $productPrice = $product['productPrice'];
                        $productImg = $product['productImg'];
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo "<p>No products available</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Event listeners for category links
            document.querySelectorAll('.dropdown-content a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const category = this.getAttribute('data-category');
                    loadCategory(category);
                });
            });

            // Function to load category products
            function loadCategory(category) {
                fetch(`../pages/dashboard.php?category=${category}`)
                    .then(response => response.text())
                    .then(html => {
                        document.querySelector('.product-display').innerHTML = new DOMParser().parseFromString(html, 'text/html').querySelector('.product-display').innerHTML;
                    })
                    .catch(error => console.error('Error fetching products:', error));
            }

            // Modal functionality
            var buttons = document.querySelectorAll(".cart-button");
            buttons.forEach(function(btn) {
                btn.addEventListener("click", function() {
                    var productID = btn.getAttribute("data-productid");
                    openModal(productID);
                });
            });

            var closeButtons = document.querySelectorAll(".close");
            closeButtons.forEach(function(closeBtn) {
                closeBtn.addEventListener("click", function() {
                    var productID = closeBtn.getAttribute("data-productid");
                    closeModal(productID);
                });
            });

            window.addEventListener("click", function(event) {
                if (event.target.classList.contains("modal")) {
                    var productID = event.target.getAttribute("data-productid");
                    closeModal(productID);
                }
            });

            function openModal(productID) {
                var modal = document.getElementById("cartModal_" + productID);
                if (modal) {
                    modal.style.display = "flex";
                }
            }

            function closeModal(productID) {
                var modal = document.getElementById("cartModal_" + productID);
                if (modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
</body>

</html>

<?php
if (isset($_SESSION['alert'])) {
    echo $_SESSION['alert'];
    unset($_SESSION['alert']);
}
?>
