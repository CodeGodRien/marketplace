<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>

<body>
    <div class="sidebar">
        <!-- Main Menu nav-link -->
        <a href="../pages/customer_dashboard.php" class="sidebar-link">
            <div class="sidebar-item">
                <div class="icon"><i class="fa-solid fa-arrow-left-long"></i></div>
                <div class="nav-title">Back to Main Menu</div>
            </div>
        </a>

        <a href="../pages/manage_product.php" class="sidebar-link" id="sidebar-manage-products">
            <div class="sidebar-item">
                <div class="icon"><i class="fa-solid fa-pen-to-square"></i></div>
                <div class="nav-title">Manage Products</div>
            </div>
        </a>

        <a href="../pages/add_product.php" class="sidebar-link">
            <div class="sidebar-item" id="sidebar-add-products">
                <div class="icon"><i class="fa-solid fa-plus"></i></div>
                <div class="nav-title">Add Products</div>
            </div>
        </a>

        <a href="../pages/orders.php" class="sidebar-link">
            <div class="sidebar-item" id="sidebar-orders">
                <div class="icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                <div class="nav-title">Orders</div>
            </div>
        </a>

        <a href="../crud/logout.php" class="sidebar-link">
            <div class="sidebar-item">
                <div class="icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                <div class="nav-title red">Sign out</div>
            </div>
        </a>
    </div>
</body>

</html>