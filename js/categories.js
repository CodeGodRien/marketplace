function loadCategory(category) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `getProducts.php?category=${category}`, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const products = JSON.parse(xhr.responseText);
            displayProducts(products, category);
        } else {
            console.error('Failed to fetch products');
        }
    };

    xhr.send();
}

function displayProducts(products, category) {
    const productDisplay = document.getElementById('product-display');
    let productsHTML = `<h2>${capitalizeFirstLetter(category)} Products</h2><div class='product-display-grid'>`;

    if (products.length === 0) {
        productsHTML += '<p>No products found</p>';
    } else {
        products.forEach(product => {
            productsHTML += `
                <div class='item'>
                    <div class='item-upper'>
                        <img src='../product_img/${product.productImg}' class='product-img' draggable='false'>
                    </div>
                    <div class='item-lower'>
                        <div class='product-name'>${product.productName}</div>
                        <div class='product-desc'>${product.productDesc}</div>
                        <div class='price-rating'>
                            <div class='price'>₱${product.productPrice}</div>
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
                            <a href='../pages/product_details.php?productID=${product.productID}'><div class='details-button'>More details</div></a>
                            <div class='cart-button' data-productid='${product.productID}'><i class='fa-solid fa-cart-shopping' style='color: #ffffff;'></i></div>
                            <div id='cartModal_${product.productID}' class='modal' data-productid='${product.productID}'>
                                <div class='modal-content'>
                                    <span class='close' data-productid='${product.productID}'>&times;</span>
                                    <h2>Add to Cart</h2>
                                    <p>Your cart is currently empty.</p>
                                    <!-- Add more cart details here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    }

    productsHTML += '</div>';
    productDisplay.innerHTML = productsHTML;
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
