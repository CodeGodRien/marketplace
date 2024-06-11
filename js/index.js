const descriptionNextBtn = document.getElementById("description-next-button");
const categoryNextBtn = document.getElementById("category-next-button");
const addProductPage1 = document.getElementById("add-product-form");
const addProductPage2 = document.getElementById("add-category-form");
const addProductPage3 = document.getElementById("payment-method-form");
const categoryBackBtn = document.getElementById("category-back-btn");
const paymentBackBtn = document.getElementById("payment-back-btn");
const descriptionStep = document.getElementById("description-step");
const categoryStep = document.getElementById("category-step");
const paymentStep = document.getElementById("payment-step");
const descriptionIcon = document.getElementById("description-icon");
const categoryIcon = document.getElementById("category-icon");
const paymentIcon = document.getElementById("payment-icon");
const hr1 = document.getElementById("hr-1");
const hr2 = document.getElementById("hr-2");
const made2OrderCheckbox = document.getElementById("ch1");
const productQtyInput = document.getElementById("product-qty-input");
let variantArray = [];

descriptionNextBtn.addEventListener("click", e => {
    addProductPage1.style.display = "none";
    addProductPage2.style.display = "flex";
    categoryStep.style.backgroundColor = "#3182CE";
    categoryIcon.style.color = "white";
    hr1.style.borderTopColor = "#3182CE";
});

categoryBackBtn.addEventListener("click", e => {
    addProductPage2.style.display = "none";
    addProductPage1.style.display = "flex";
    categoryStep.style.backgroundColor = "#FFF5EC";
    categoryIcon.style.color = "#3182CE";
    hr1.style.borderTopColor = "#C3E2FF";
});

categoryNextBtn.addEventListener("click", e => {
    addProductPage2.style.display = "none";
    addProductPage3.style.display = "flex";
    paymentStep.style.backgroundColor = "#3182CE";
    paymentIcon.style.color = "white";
    hr2.style.borderTopColor = "#3182CE";

});

paymentBackBtn.addEventListener( "click", e => {
    addProductPage3.style.display = "none";
    addProductPage2.style.display = "flex";
    paymentStep.style.backgroundColor = "#FFF5EC";
    paymentIcon.style.color = "#3182CE";
    hr2.style.borderTopColor = "#C3E2FF";
});

function disableQuantity() {
    if (made2OrderCheckbox.checked == true) {
        productQtyInput.value = "";
        productQtyInput.disabled = true;
    } else {
        productQtyInput.disabled = false;
    }
}

function addToArray() {
    console.log("naclick to");
    console.log(variantArray);
    let variantInput = document.getElementById("variant-input").value;
    if (variantInput.trim() !== "") {
        variantArray.push(variantInput);
        document.getElementById("variant-input").value = "";
        let newDiv = document.createElement('div');
        newDiv.textContent = variantInput;
        document.getElementById("variant-input-div").appendChild(newDiv);
    }
}

