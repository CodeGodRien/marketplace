<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
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
                <a href="#" onclick="loadCategory('food')">Food</a>
                    <a href="#" onclick="loadCategory('accessories')">Accessories</a>
                    <a href="#" onclick="loadCategory('fashion')">Fashion</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="product-list"></div>

<script src="categories.js"></script>

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
</body>

</html>