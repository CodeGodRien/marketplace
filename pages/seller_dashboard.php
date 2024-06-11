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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <div class="steps-icon-div" id="edit-step"><i class="fa-solid fa-pen-to-square" id="description-icon"></i></div>
                            <div>Description</div>
                        </div>
                        
                        <div class="hr-div"><hr id="hr-1"></div>

                        <div class="icon-text-body">
                            <div class="steps-icon-div" id="category-step"><i class="fa-solid fa-list" id="category-icon"></i></div>
                            <div>Categories</div>
                        </div>
                        
                        <div class="hr-div"><hr id="hr-2"></div>

                        <div class="icon-text-body">
                            <div class="steps-icon-div" id="payment-step"><i class="fa-solid fa-money-bill" id="payment-icon"></i></div>
                            <div>Payment Methods</div>
                        </div>
                    </div>
                </div>
                <div class="add-product-form" id="add-product-form">
                    <div class="upper-product-form">
                        <h3>Basic Information</h3>
                    </div>
                    <div class="lower-product-form">
                        <div class="left-add-product-form">
                            <div class="product-form-row">
                                <label for="">Product Name</label>
                                <input type="text" class="input">
                            </div>
                            <div class="product-form-row">
                                <label for="">Product Description</label>
                                <textarea name="" id="" rows="4"></textarea>
                            </div>
                            <div class="product-form-row">
                                <label for="">Add Product Photos</label>
                                <input type="text" class="input">
                            </div>
                        </div>
                        <div class="right-add-product-form">
                            <div class="upper-right-add-product-form">
                                <div class="product-form-row">
                                    <label for="">Price</label>
                                    <input type="text" class="input">
                                </div>
                                <div class="product-form-checkbox">
                                    <label class="checkBox">
                                        <input id="ch1" type="checkbox">
                                        <div class="transition"></div>
                                    </label>
                                    <label for="">Made to order</label>
                                </div>
                                <div class="product-form-row">
                                    <label for="">Quantity</label>
                                    <input type="text" class="input" id="product-qty-input">
                                </div>
                            </div>
                            <div class="form-next-button" id="description-next-button">
                                Next
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add-category-form" id="add-category-form">
                    <div class="upper-product-form">
                        <div class="add-product-back-button" id="category-back-btn">
                            <i class="fa-solid fa-arrow-left-long"></i>
                            Back
                        </div>
                        <h3>Product Category</h3>
                    </div>
                    <div class="lower-category-form">
                        <div class="category-list">
                             <div class="category-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="input">
                                    <span class="custom-checkbox"></span>
                                    Electronics
                                </label>
                            </div>
                            <div class="category-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="input">
                                    <span class="custom-checkbox"></span>
                                    Clothing & Apparel
                                </label>
                            </div>
                            <div class="category-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="input">
                                    <span class="custom-checkbox"></span>
                                    Jewelry & Accessories
                                </label>
                            </div>
                            <div class="category-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="input">
                                    <span class="custom-checkbox"></span>
                                    Food
                                </label>
                            </div>
                            <div class="category-item">
                                <label class="checkbox-label">
                                    <input type="checkbox" class="input">
                                    <span class="custom-checkbox"></span>
                                    Beverages
                                </label>
                            </div>
                            <div class="category-item">
                            <label>
                                <input type="checkbox" class="input">
                                <span class="custom-checkbox"></span>
                            </label>
                            </div>
                        </div>
                        <div class="category-next-button" id="category-next-button">
                            Next
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </div>
                    </div>
                </div>
                <div class="payment-method-form" id="payment-method-form">
                    <div class="upper-product-form">
                        <div class="add-product-back-button" id="payment-back-btn">
                            <i class="fa-solid fa-arrow-left-long"></i>
                            Back
                        </div>
                        <h3>Payment Method</h3>
                    </div>
                    <div class="lower-category-form">
                        <div class="payment-methods-div">
                            <div class="payment-method">
                                <div class="left-payment-method">
                                    <label class="checkbox-label" style="color: black;">
                                        <input type="checkbox" class="input">
                                        <span class="custom-checkbox"></span>
                                        Cash-on-delivery (COD)
                                    </label>
                                </div>
                                <div class="right-payment-method">
                                    <i class="fa-solid fa-money-bill-1-wave"></i>
                                </div>
                            </div>
                            <div class="payment-method">
                                <div class="left-payment-method">
                                    <label class="checkbox-label" style="color: black;">
                                        <input type="checkbox" class="input">
                                        <span class="custom-checkbox"></span>
                                        GCash
                                    </label>
                                </div>
                                <div class="right-payment-method">
                                    <div class="payment-method-image">
                                        <img src="../img/GCash_logo.png">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="category-next-button" id="product-submit-button">
                            Submit
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