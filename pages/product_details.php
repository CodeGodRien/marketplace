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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
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
                <a href="../crud/add_to_cart.php?productID=<?php echo $productID; ?>&pageID=detailed"><div class="cart-button-long"><i class='fa-solid fa-cart-shopping' style='color: #ffffff;'></i>Add to Cart</div></a>
            </div>
        </div>
        <?php
            $sql = "SELECT * FROM products WHERE productID = '$productID'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <div class="right-product-detail">
            <div class="right-product-upper-detail">
                <div>
                    <h1><?php echo $row['productName']; ?></h1>
                    <h2>₱<?php echo $row['productPrice']; ?></h2>
                    <p><?php echo $row['productDesc']; ?></p>
                </div>
                <div>
                    <h2>Sold by: <?php echo $row['productSellerID']; ?></h2>
                </div>
            </div>
            <div class="right-product-lower-detail">
                <div class="reviews-h2-div"><h2>Reviews</h2></div>
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
</html>

<?php
    if(isset($_SESSION['alert'])) {
        echo $_SESSION['alert'];
        unset($_SESSION['alert']);
    }
?>