<?php
session_start();
require "../config/dbconn.php";

$userID = $_SESSION['userID'];

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
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="../styles/index.css">
    <link rel="stylesheet" href="../styles/cart.css">
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

<body style="background-color: #CDE1F4;">
    <?php
        include_once '../components/navbar.php';
    ?>
    <div class="content">

        <?php
$sql = "SELECT DISTINCT sellerID FROM cart WHERE userID = '$userID'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sellerID = $row['sellerID'];
        $sql_items = "
            SELECT e1.productName, 
                   variations.variationPrice, 
                   e1.productImg, 
                   cart.quantity, 
                   cart.productID,
                   variations.variationID,
                   SUM(variations.variationPrice * cart.quantity) OVER () AS totalAmount,
                   SUM(cart.quantity) OVER () AS totalQuantity
            FROM products e1 
            INNER JOIN cart ON e1.productID = cart.productID 
            INNER JOIN variations ON cart.variationID = variations.variationID
            WHERE cart.userID = '$userID' 
              AND cart.sellerID = '$sellerID' 
            ORDER BY cart.timeAdded;
        ";
        $result_items = mysqli_query($conn, $sql_items);
        echo "<div class='cart'>
              <div class='cart-item-div'>";
        
        if (mysqli_num_rows($result_items) > 0) {
            $row = mysqli_fetch_assoc($result_items);
            $totalAmount = $row['totalAmount'];
            $totalQuantity = $row['totalQuantity'];
            mysqli_data_seek($result_items, 0);

            echo "<form method='POST' action='../crud/process_order.php'>";
            
            while ($item = mysqli_fetch_assoc($result_items)) {
                $variationID = $item['variationID'];
                $sql = "SELECT * FROM variations WHERE variationID = '$variationID'";
                $variation_result = mysqli_query($conn, $sql);
                $variation_row = mysqli_fetch_assoc($variation_result);
                $variation = $variation_row['variationName'];
                $size = $variation_row['variationSize'];

                echo "<div class='cart-item'>
                        <div class='cart-item-pic'>
                            <img src='../product_img/" . $item['productImg'] . "'>
                        </div>
                        <div class='cart-item-name'><p>" . $item['productName'] . "</p></div>
                        <div class='cart-item-details'>
                            <p>" . $variation . "</p>
                        </div>
                        <div class='cart-item-details'>
                            <p>" . $size . "</p>
                        </div>
                        <div class='cart-item-quantity'>
                            <div class='quantity-icon-div'>
                                <a href='../crud/minusQuantity.php?productID=" . $item['productID'] . "&variationID=" . $variationID . "'><i class='fa-solid fa-square-minus'></i></a>
                            </div>
                            <p>" . $item['quantity'] . "</p>
                            <div class='quantity-icon-div'>
                                <a href='../crud/addQuantity.php?productID=" . $item['productID'] . "&variationID=" . $variationID . "'><i class='fa-solid fa-square-plus'></i></a>
                            </div>
                        </div>
                        <div class='cart-item-price'>
                            <p class=''><i class='fa-solid fa-peso-sign'></i>" . number_format((float)$item['variationPrice'] * $item['quantity'], 2, '.', '') . "</p>
                        </div>
                        <div class='cart-item-delete'>
                            <a href='../crud/delete_from_cart.php?productID=" . $item['productID'] . "'><i class='fa-solid fa-x'></i></a>
                        </div>
                    </div>
                    <div class='cart-item-border'>
                        <span class='border-bottom'></span>
                    </div>
                    <input type='hidden' name='productID[]' value='" . $item['productID'] . "'>
                    <input type='hidden' name='quantity[]' value='" . $item['quantity'] . "'>
                    <input type='hidden' name='variationID[]' value='" . $variationID . "'>
                    <input type='hidden' name='price[]' value='" . $item['variationPrice'] . "'>";
            }
            
            echo "</div>
                  <div class='cart-total'>
                    <div class='cart-upper'>
                        <div class='cart-total-row'>
                            <div class='cart-total-items'>Subtotal (" . $totalQuantity . " items)</div>
                            <div class='cart-subtotal'>" . number_format((float)$totalAmount, 2, '.', ',') . "</div>
                        </div>
                        <div class='cart-total-row'>
                            <div class='cart-total-items'>Taxes and fees</div>
                            <div class='cart-subtotal'>0.00</div>
                        </div>
                        <hr>
                        <div class='cart-total-row'>
                            <div class='cart-total-items'>Total</div>
                            <div class='cart-subtotal'><i class='fa-solid fa-peso-sign'></i>" . number_format((float)$totalAmount, 2, '.', ',') . "</div>
                        </div>
                        <div class='radio-inputs'>
                            <label>
                                <input class='radio-input' type='radio' name='payment-method' value='Cash'>
                                <span class='radio-tile'>
                                    <span class='radio-icon'>
                                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 576 512'><path d='M0 112.5V422.3c0 18 10.1 35 27 41.3c87 32.5 174 10.3 261-11.9c79.8-20.3 159.6-40.7 239.3-18.9c23 6.3 48.7-9.5 48.7-33.4V89.7c0-18-10.1-35-27-41.3C462 15.9 375 38.1 288 60.3C208.2 80.6 128.4 100.9 48.7 79.1C25.6 72.8 0 88.6 0 112.5zM288 352c-44.2 0-80-43-80-96s35.8-96 80-96s80 43 80 96s-35.8 96-80 96zM64 352c35.3 0 64 28.7 64 64H64V352zm64-208c0 35.3-28.7 64-64 64V144h64zM512 304v64H448c0-35.3 28.7-64 64-64zM448 96h64v64c-35.3 0-64-28.7-64-64z'/></svg>
                                    </span>
                                    <span class='radio-label'>Cash</span>
                                </span>
                            </label>
                            <label>
                                <input checked class='radio-input' type='radio' name='payment-method' value='GCash'>
                                <span class='radio-tile'>
                                    <span class='radio-icon'>
                                        <img src='../img/GCash_logo.png' width='150' height='40' draggable='false'>
                                    </span>
                                    <span class='radio-label'>GCash</span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <input type='hidden' name='sellerID' value='" . $sellerID . "'>
                    <input type='hidden' name='totalAmount' value='" . $totalAmount . "'>
                    <div class='place-order-btn-container'>
                        <button type='submit' class='place-order-btn'>
                            Place Order
                        </button>
                    </div>
                </div>
            </form>
            </div>";
        }
    }
}
?>






    </div>
    </div>

</body>

</html>