<?php
session_start();
require '../config/dbconn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="../styles/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
    <?php
        $productID = $_GET['productID'];
        $sql = "SELECT productImg FROM products WHERE productID = '$productID'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>

    <div class="product-detail-content">
        <div class="left-product-detail">
            <section class="container">
                <div class="slider-wrapper">
                    <div class="slider">
                        <img id="slide-1" src="../product_img/<?php echo $row['productImg']; ?>">
                        <?php 
                            $sql = "SELECT * FROM product_img WHERE productID = '$productID'";
                            $result = mysqli_query($conn, $sql);
                            $numRows = mysqli_num_rows($result);
                            if ($numRows > 0) {
                                for ($counter = 2; $counter < $numRows + 2; $counter++) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo '<img id="slide-' . $counter . '" src="../product_img/' . $row['productImg'] . '">';
                                }
                            }
                        ?>

                    </div>
                    <div class="slider-nav">
                        <a href="#slide-1"></a>
                        <?php 
                            if ($numRows > 1) {
                                for ($counter = 2; $counter <= $numRows + 1; $counter++) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo '<a href="#slide-' . $counter . '"></a>';
                                }
                            }

                        ?>

                    </div>
                </div>
            </section>

            <div class="left-product-rating">
                <div>
                    <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                    <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                    <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                    <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                    <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                </div>
                <div>4.8/5</div>
                <div>69 Reviews</div>
            </div>
            <div class="long-cart-btn-div">
                <a href="" id="addToCartLink">
                    <div class="cart-button-long"><i class='fa-solid fa-cart-shopping' style='color: #ffffff;'></i>Add
                        to Cart</div>
                </a>
            </div>
        </div>
        <?php
            $sql = "SELECT * FROM products WHERE productID = '$productID'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $sellerID = $row['productSellerID'];
        ?>
        <div class="right-product-detail">
            <div class="right-product-upper-detail">
                <div>
                    <h1><?php echo $row['productName']; ?></h1>
                    <h2 id="productPrice">69</h2>
                    <p><?php echo $row['productDesc']; ?></p>
                    <select name="variation" id="variationSelect"></select>
                    <select name="size" id="sizeSelect" onchange="displayPrice()"></select>
                </div>
                <div>
                    <h2>Sold by: <?php echo $sellerID; ?></h2>
                </div>
            </div>
            <div class="right-product-lower-detail">
                <div class="reviews-h2-div">
                    <h2>Reviews</h2>
                </div>
                <div class="review-box">
                    <div class="profile-rating-div">
                        <div class="feedback-profile">
                            <img src="../profile_pics/anthony.png">
                        </div>
                        <div class="feedback-stars">
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                        </div>
                    </div>
                    <div class="feedback-name-date-div">
                        <div class="feedback-name">Anthony Edwards</div>
                        <div class="feedback-date">May 25, 2024</div>
                    </div>
                    <div class="feedback-content-div">
                        Hell nah.
                    </div>
                    <div class="feedback-img"></div>
                </div>
                <div class="review-box">
                    <div class="profile-rating-div">
                        <div class="feedback-profile">
                            <img src="../profile_pics/anthony.png">
                        </div>
                        <div class="feedback-stars">
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                        </div>
                    </div>
                    <div class="feedback-name-date-div">
                        <div class="feedback-name">Anthony Edwards</div>
                        <div class="feedback-date">May 25, 2024</div>
                    </div>
                    <div class="feedback-content-div">
                        Hell nah.
                    </div>
                    <div class="feedback-img"></div>
                </div>
                <div class="review-box">
                    <div class="profile-rating-div">
                        <div class="feedback-profile">
                            <img src="../profile_pics/anthony.png">
                        </div>
                        <div class="feedback-stars">
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                            <i class='fa-solid fa-star' style='color: #FFD43B;'></i>
                        </div>
                    </div>
                    <div class="feedback-name-date-div">
                        <div class="feedback-name">Anthony Edwards</div>
                        <div class="feedback-date">May 25, 2024</div>
                    </div>
                    <div class="feedback-content-div">
                        Hell nah.
                    </div>
                    <div class="feedback-img"></div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const variationSelect = document.getElementById('variationSelect');
    const sizeSelect = document.getElementById('sizeSelect');
    const price = document.getElementById('productPrice');
    const addToCartLink = document.getElementById('addToCartLink');
    let addToCartUrl = "../crud/add_to_cart.php?pageID=detailed";
    var productID = <?php echo json_encode($productID); ?>;

    if (!variationSelect || !sizeSelect || !price || !addToCartLink) {
        console.error('One or more elements are not found in the DOM.');
        return;
    }

    fetch('../crud/getVariations.php?productID=' + productID)
        .then(response => response.json())
        .then(data => {
            data.forEach((variation, index) => {
                var option = document.createElement('option');
                option.value = variation;
                option.text = variation;
                if (index === 0) {
                    option.selected = true;
                }
                variationSelect.appendChild(option);
            });
            populateSizes(variationSelect.value);
        })
        .catch(error => console.error('Error fetching variations:', error));

    function populateSizes(variationName) {
        let url = '../crud/getSizes.php';
        if (!variationName) {
            url += '?productID=' + productID;
        } else {
            url += '?variationName=' + encodeURIComponent(variationName) + '&productID=' + productID;
        }
        fetch(url)
            .then(response => response.json())
            .then(data => {
                sizeSelect.innerHTML = ''; // Clear existing options
                data.forEach((size, index) => {
                    var option = document.createElement('option');
                    option.value = size;
                    option.text = size;
                    if (index === 0) {
                        option.selected = true;
                    }
                    sizeSelect.appendChild(option);
                });
                displayPrice(); // Call displayPrice after sizes are populated
                updateAddToCartUrl();
            })
            .catch(error => console.error('Error fetching sizes:', error));
    }

    function displayPrice() {
        let variation = variationSelect.value;
        let size = sizeSelect.value;

        fetch('../crud/displayPrice.php?variation=' + encodeURIComponent(variation) + '&size=' +
                encodeURIComponent(size) + '&productID=' + productID)
            .then(response => response.text())
            .then(data => {
                price.textContent = data.replace(/"/g, '');
            })
            .catch(error => console.error('Error fetching price:', error));
    }

    function updateAddToCartUrl() {
        addToCartUrl = "../crud/add_to_cart.php?pageID=detailed";
        addToCartUrl += "&productID=" + productID + "&variation=" + encodeURIComponent(variationSelect.value) +
            "&size=" + encodeURIComponent(sizeSelect.value);
        addToCartLink.href = addToCartUrl;
        console.log('Add to Cart URL set to:', addToCartLink.href);
    }

    variationSelect.addEventListener('change', function() {
        populateSizes(this.value);
    });

    sizeSelect.addEventListener('change', function() {
        displayPrice();
        updateAddToCartUrl();
    });

    document.getElementById('variationSelect').addEventListener('change', function() {
        var selectedVariation = this.value;
        populateSizes(selectedVariation);
    });
});
</script>



</html>

<?php
    if(isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
?>