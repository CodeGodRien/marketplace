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
    if ($vStatus == 0) {
        header("Location: ../pages/index.php");
    } 
}  
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
                            <div class="steps-icon-div" id="images-step"><i class="fa-solid fa-images"
                                    id="images-icon"></i></div>
                            <div>Product Images</div>
                        </div>

                        <div class="hr-div">
                            <hr id="hr-2">
                        </div>

                        <div class="icon-text-body">
                            <div class="steps-icon-div" id="category-step"><i class="fa-solid fa-list"
                                    id="category-icon"></i></div>
                            <div>Categories</div>
                        </div>

                        <div class="hr-div">
                            <hr id="hr-3">
                        </div>

                        <div class="icon-text-body">
                            <div class="steps-icon-div" id="pricing-step"><i class="fa-solid fa-sack-dollar"
                                    id="pricing-icon"></i></div>
                            <div>Pricing</div>
                        </div>

                        <div class="hr-div">
                            <hr id="hr-4">
                        </div>

                        <div class="icon-text-body">
                            <div class="steps-icon-div" id="payment-step"><i class="fa-solid fa-money-bill"
                                    id="payment-icon"></i></div>
                            <div>Payment Methods</div>
                        </div>
                    </div>
                </div>
                <form class="form-add-products" action="../crud/addProduct.php" method="POST"
                    enctype="multipart/form-data">
                    <div class="add-product-form" id="add-product-form">
                        <div class="upper-product-form">
                            <h3>Product Information</h3>
                        </div>
                        <div class="lower-product-form">
                            <div class="left-add-product-form">
                                <div class="product-form-row">
                                    <label for="">Product Name</label>
                                    <input type="text" class="input" name="productName">
                                </div>
                                <div class="product-form-row">
                                    <label for="">Product Description</label>
                                    <textarea id="" rows="4" name="productDesc"></textarea>
                                </div>
                            </div>
                            <div class="right-add-product-form">
                                <div class="product-form-row">
                                    <label for="">Add Product Display Photo</label>
                                    <input type="file" name="productImg" id="productImg"
                                        accept=".jpg, .jpeg, .png, .avif" onchange="previewImage(event)" />
                                </div>
                                <div class="image-container">
                                    <div class="delete-button-container" id="delete-button-container">
                                        <button class="delete-button" onclick="deleteImage()">X</button>
                                    </div>
                                    <img id="imgPreview" src="#" alt="Preview Image"
                                        style="display: none; max-width: 250px; max-height: 250px;">
                                </div>

                            </div>
                        </div>
                        <div class="form-next-button" id="description-next-button">
                            Next
                            <i class="fa-solid fa-arrow-right-long"></i>
                        </div>
                    </div>
                    <div class="add-product-form" id="add-product-pictures">
                        <div class="upper-product-form">
                            <div class="add-product-back-button" id="images-back-btn">
                                <i class="fa-solid fa-arrow-left-long"></i>
                                Back
                            </div>
                            <h3>Upload Images</h3>
                        </div>
                        <div class="lower-product-form">
                            <div class="left-add-product-form">
                                <div class="upload-images-row">
                                    <label class="custum-file-upload" for="multiple-image-input">
                                        <div class="icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="" viewBox="0 0 24 24">
                                                <g stroke-width="0" id="SVGRepo_bgCarrier"></g>
                                                <g stroke-linejoin="round" stroke-linecap="round"
                                                    id="SVGRepo_tracerCarrier"></g>
                                                <g id="SVGRepo_iconCarrier">
                                                    <path fill=""
                                                        d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z"
                                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="text">
                                            <span>Click to upload image</span>
                                        </div>
                                        <input type="file" id="multiple-image-input" name="images[]"
                                            accept=".jpg, .jpeg, .png, .avif" multiple>
                                    </label>
                                </div>
                                <div class="uploaded-images-display" id="image-preview-container">

                                </div>
                            </div>
                        </div>
                        <div class="form-next-button" id="images-next-button">
                            Next
                            <i class="fa-solid fa-arrow-right-long"></i>
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
                            <div class="upper-category">
                                <div class="category-list">
                                    <div class="category-item">
                                        <label class="checkbox-label">
                                            <input type="checkbox" class="input" name="categories[]"
                                                value="Electronics">
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

                                        </div>
                                    </div>
                                    <div class="size-group" id="size-group">
                                        Sizes
                                        <div class="size-list" id="size-list">

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
                    <div class="add-category-form" id="pricing-form">
                        <div class="upper-product-form">
                            <div class="add-product-back-button" id="pricing-back-btn">
                                <i class="fa-solid fa-arrow-left-long"></i>
                                Back
                            </div>
                            <h3>Product Pricing</h3>
                        </div>
                        <div class="lower-category-form">
                            <div class="pricing-div">
                                <table class="pricing-table" id="pricing-table">
                                    <thead>
                                        <tr>
                                            <th>Variation</th>
                                            <th>Size</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Made to Order</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pricing-table-body">

                                    </tbody>
                                </table>
                                <input type="hidden" name="variationsData" id="variationsInput">
                            </div>
                            <div class="category-next-button" id="pricing-next-button">
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
                                            <input type="checkbox" class="input" name="paymentMethod[]" value="COD">
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
                                            <input type="checkbox" class="input" name="paymentMethod[]" value="GCash">
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
                            <button type="submit" class="category-next-button" value="Submit">
                                Add Product
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </button>
                        </div>
                    </div>
            </div>
            </form>
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