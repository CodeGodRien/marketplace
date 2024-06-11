<?php
session_start();
require '../config/dbconn.php';
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
    </style>
</head>

<body>
    <div class="seller-dashboard-container">
        <?php include_once '../components/seller_sidebar.php'; ?>
        <div class="inner-dashboard-container">
            <div class="add-product-div">
                <div class="steps-div">
                    <div class="steps-graphic">
                        <div class="icon-text-body description-step">
                            <div class="steps-icon-div" id="edit-step"><i class="fa-solid fa-pen-to-square"
                                    id="description-icon"></i></div>
                            <div>Description</div>
                        </div>

                        <div class="hr-div">
                            <hr id="hr-1">
                        </div>

                        <div class="icon-text-body">
                            <div class="steps-icon-div" id="category-step"><i class="fa-solid fa-list"
                                    id="category-icon"></i></div>
                            <div>Categories</div>
                        </div>

                        <div class="hr-div">
                            <hr id="hr-2">
                        </div>

                        <div class="icon-text-body">
                            <div class="steps-icon-div" id="payment-step"><i class="fa-solid fa-money-bill"
                                    id="payment-icon"></i></div>
                            <div>Payment Methods</div>
                        </div>
                    </div>
                </div>

                <div class="add-category-form" id="add-category-form" style="display: flex;">
                    <div class=" upper-product-form">
                        <div class="add-product-back-button" id="category-back-btn">
                            <i class="fa-solid fa-arrow-left-long"></i>
                            Back
                        </div>
                        <h3>Product Category</h3>
                    </div>
                    <div class="lower-category-form">
                        <div class="upper-category">
                            <div class="category-list">
                                <div class="category-item">
                                    <label class="checkbox-label">
                                        <input type="checkbox" class="input" name="categories[]" value="Electronics">
                                        <span class="custom-checkbox"></span>
                                        Electronics
                                    </label>
                                </div>
                                <div class="category-item">
                                    <label class="checkbox-label">
                                        <input type="checkbox" class="input" name="categories[]" value="Clothing">
                                        <span class="custom-checkbox"></span>
                                        Clothing & Apparel
                                    </label>
                                </div>
                                <div class="category-item">
                                    <label class="checkbox-label">
                                        <input type="checkbox" class="input" name="categories[]" value="Jewelry">
                                        <span class="custom-checkbox"></span>
                                        Jewelry & Accessories
                                    </label>
                                </div>
                                <div class="category-item">
                                    <label class="checkbox-label">
                                        <input type="checkbox" class="input" name="categories[]" value="Food">
                                        <span class="custom-checkbox"></span>
                                        Food
                                    </label>
                                </div>
                                <div class="category-item">
                                    <label class="checkbox-label">
                                        <input type="checkbox" class="input" name="categories[]" value="Beverages">
                                        <span class="custom-checkbox"></span>
                                        Beverages
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="add-variation">
                            <h3>Add Variation</h3>
                            <input type="text" class="variation-input" id="variant-input">
                            <button class="add-variation-btn" onclick="addToVariationArray()">
                                <i class="fa-solid fa-plus"></i>Add Variation</button>
                        </div>
                    </div>
                    <div class="lower-category">
                        <div class="left-category-partition">
                            <div class="variation-group" id="variation-group">
                                Variations
                                <div class="variation-list" id="variation-list">
                                    <div class="variation-div">Chocolate</div>
                                </div>
                            </div>
                            <div class="size-group" id="size-group">
                                Sizes
                                <div class="size-list" id="size-list">
                                    <div class="size-div">Small</div>
                                </div>
                            </div>
                        </div>
                        <div class="right-category-partition">
                            <h3>Add Sizes</h3>
                            <input type="text" class="variation-input" id="size-input">
                            <button class="add-variation-btn" onclick="addToSizeArray()">
                                <i class="fa-solid fa-plus"></i>Add Size</button>
                        </div>
                    </div>
                    <div class="category-next-button" id="category-next-button">
                        Next
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>
    <script src="../js/index.js"></script>
</body>

</html>

<?php
    if(isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
?>