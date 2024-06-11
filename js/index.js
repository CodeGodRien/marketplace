let variations = [];
let variationArray = [];
let sizeArray = [];

const descriptionNextBtn = document.getElementById("description-next-button");
const imagesNextBtn = document.getElementById("images-next-button");
const categoryNextBtn = document.getElementById("category-next-button");
const pricingNextBtn = document.getElementById("pricing-next-button");
const addProductPage1 = document.getElementById("add-product-form");
const addProductPage2 = document.getElementById("add-product-pictures");
const addProductPage3 = document.getElementById("add-category-form");
const addProductPage4 = document.getElementById("pricing-form");
const addProductPage5 = document.getElementById("payment-method-form");
const categoryBackBtn = document.getElementById("category-back-btn");
const imagesBackBtn = document.getElementById("images-back-btn");
const pricingBackBtn = document.getElementById("pricing-back-btn");
const paymentBackBtn = document.getElementById("payment-back-btn");
const descriptionStep = document.getElementById("description-step");
const imagesStep  = document.getElementById("images-step");
const categoryStep = document.getElementById("category-step");
const pricingStep = document.getElementById("pricing-step");
const paymentStep = document.getElementById("payment-step");
const descriptionIcon = document.getElementById("description-icon");
const imagesIcon = document.getElementById("images-icon");
const categoryIcon = document.getElementById("category-icon");
const pricingIcon = document.getElementById("pricing-icon");
const paymentIcon = document.getElementById("payment-icon");
const hr1 = document.getElementById("hr-1");
const hr2 = document.getElementById("hr-2");
const hr3 = document.getElementById("hr-3");
const hr4 = document.getElementById("hr-4");
const made2OrderCheckbox = document.getElementById("ch1");
const productQtyInput = document.getElementById("product-qty-input");
const tableBody = document.getElementById("pricing-table-body");
const addProductSubmitBtn = document.getElementById("product-submit-button");
const variationsInput = document.getElementById("variationsInput");
const deleteButtonContainer = document.getElementById("delete-button-container");
const productImgInput = document.getElementById("productImg");

descriptionNextBtn.addEventListener("click", (e) => {
  addProductPage1.style.visibility = "hidden";
  addProductPage1.style.position = "absolute";
  addProductPage2.style.display = "flex";
  addProductPage2.style.position = "static";
  addProductPage2.style.visibility = "visible";
  imagesStep.style.backgroundColor = "#3182CE";
  imagesIcon.style.color = "white";
  hr1.style.borderTopColor = "#3182CE";
});

imagesBackBtn.addEventListener("click", (e) => {
  addProductPage2.style.visibility = "hidden";
  addProductPage2.style.position = "absolute";
  addProductPage1.style.display = "flex";
  addProductPage1.style.position = "static";
  addProductPage1.style.visibility = "visible";
  imagesStep.style.backgroundColor = "#FFF5EC";
  imagesIcon.style.color = "#3182CE";
  hr1.style.borderTopColor = "#C3E2FF";
});

imagesNextBtn.addEventListener("click", (e) => {
  addProductPage2.style.visibility = "hidden";
  addProductPage2.style.position = "absolute";
  addProductPage3.style.display = "flex";
  addProductPage3.style.visibility = "visible";
  addProductPage3.style.position = "static";
  categoryStep.style.backgroundColor = "#3182CE";
  categoryIcon.style.color = "white";
  hr2.style.borderTopColor = "#3182CE";
});

categoryBackBtn.addEventListener("click", (e) => {
  addProductPage3.style.visibility = "hidden";
  addProductPage3.style.position = "absolute";
  addProductPage2.style.display = "flex";
  addProductPage2.style.visibility = "visible";
  addProductPage2.style.position = "static";
  categoryStep.style.backgroundColor = "#FFF5EC";
  categoryIcon.style.color = "#3182CE";
  hr2.style.borderTopColor = "#C3E2FF";
});

categoryNextBtn.addEventListener("click", (e) => {
  addProductPage3.style.visibility = "hidden";
  addProductPage3.style.position = "absolute";
  addProductPage4.style.display = "flex";
  addProductPage4.style.visibility = "visible";
  addProductPage4.style.position = "static";
  pricingStep.style.backgroundColor = "#3182CE";
  pricingIcon.style.color = "white";
  hr3.style.borderTopColor = "#3182CE";
  createVariation();
  populateTable();
});

pricingBackBtn.addEventListener("click", (e) => {
  addProductPage4.style.visibility = "hidden";
  addProductPage4.style.position = "absolute";
  addProductPage3.style.display = "flex";
  addProductPage3.style.visibility = "visible";
  addProductPage3.style.position = "static";
  pricingStep.style.backgroundColor = "#FFF5EC";
  pricingIcon.style.color = "#3182CE";
  hr3.style.borderTopColor = "#C3E2FF";
});

pricingNextBtn.addEventListener("click", (e) => {
  addProductPage4.style.visibility = "hidden";
  addProductPage4.style.position = "absolute";
  addProductPage5.style.display = "flex";
  addProductPage5.style.visibility = "visible";
  addProductPage5.style.position = "static";
  paymentStep.style.backgroundColor = "#3182CE";
  paymentIcon.style.color = "white";
  hr4.style.borderTopColor = "#3182CE";
  let variationsData = JSON.stringify(variations);
  variationsInput.value = variationsData;
  console.log(variationsData);
});

paymentBackBtn.addEventListener("click", (e) => {
  addProductPage5.style.visibility = "hidden";
  addProductPage5.style.position = "absolute";
  addProductPage4.style.display = "flex";
  addProductPage4.style.visibility = "visible";
  addProductPage4.style.position = "static";
  paymentStep.style.backgroundColor = "#FFF5EC";
  paymentIcon.style.color = "#3182CE";
  hr4.style.borderTopColor = "#C3E2FF";
});



function disableQuantity() {
  if (made2OrderCheckbox.checked == true) {
    productQtyInput.value = "";
    productQtyInput.disabled = true;
  } else {
    productQtyInput.disabled = false;
  }
}

function addToVariationArray() {
  event.preventDefault();
  let variantInput = document.getElementById("variant-input").value;
  if (variantInput.trim() !== "") {
    variationArray.push(variantInput);
    document.getElementById("variant-input").value = "";
    let variationDiv = document.createElement("div");
    variationDiv.classList.add("variation-div");
    let textSpan = document.createElement("span");
    textSpan.textContent = variantInput;
    let deleteButton = document.createElement("button");
    let deleteIcon = document.createElement("i");
    deleteIcon.classList.add("fa-solid", "fa-x");
    deleteButton.appendChild(deleteIcon);
    deleteButton.addEventListener("click", function () {
      let index = variationArray.indexOf(variantInput);
      if (index > -1) {
        variationArray.splice(index, 1);
      }
      variationDiv.remove();
    });

    variationDiv.appendChild(textSpan);
    variationDiv.appendChild(deleteButton);
    document.getElementById("variation-list").appendChild(variationDiv);
  }
}

document
  .getElementById("variant-input")
  .addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      addToVariationArray();
    }
  });

function addToSizeArray() {
  event.preventDefault();
  let sizeInput = document.getElementById("size-input").value;
  if (sizeInput.trim() !== "") {
    sizeArray.push(sizeInput);
    document.getElementById("size-input").value = "";
    let sizeDiv = document.createElement("div");
    sizeDiv.classList.add("size-div");
    let textSpan = document.createElement("span");
    textSpan.textContent = sizeInput;
    let deleteButton = document.createElement("button");
    let deleteIcon = document.createElement("i");
    deleteIcon.classList.add("fa-solid", "fa-x");
    deleteButton.appendChild(deleteIcon);
    deleteButton.addEventListener("click", function () {
      let index = sizeArray.indexOf(sizeInput);
      let sizeName = sizeArray[index];
      if (index > -1) {
        sizeArray.splice(index, 1);
      }
      sizeDiv.remove();
      variations = variations.filter((product) => product.size !== sizeName);
    });
    sizeDiv.appendChild(textSpan);
    sizeDiv.appendChild(deleteButton);
    document.getElementById("size-list").appendChild(sizeDiv);
  }
}

document
  .getElementById("size-input")
  .addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      addToSizeArray();
    }
  });

function createVariation() {
  variations = [];
  sizeArray.forEach((size) => {
    variationArray.forEach((variation) => {
      const product = {
        variation: variation,
        size: size,
        price: 0.0,
        quantity: 0,
        isMadeToOrder: false,
      };

      if (!isPriceSet(variation, size)) {
        variations.push(product);
      }
    });
  });
  variations.sort((a, b) => a.variation.localeCompare(b.variation));
  updateLocalStorageOnChange();
  console.log(sizeArray);
  console.log(variations);
}

function isPriceSet(variation, size) {
  return variations.some(
    (product) =>
      product.variation === variation &&
      product.size === size &&
      product.price !== 0
  );
}

function populateTable() {
  tableBody.innerHTML = "";
  variations.forEach((product, index) => {
    const tableRow = document.createElement("tr");
    const variationName = document.createElement("td");
    variationName.textContent = product.variation;
    tableRow.appendChild(variationName);

    const size = document.createElement("td");
    size.textContent = product.size;
    tableRow.appendChild(size);

    const price = document.createElement("td");
    const priceInput = document.createElement("input");
    priceInput.type = "number";
    priceInput.value = product.price;
    priceInput.classList.add("price-input");
    priceInput.addEventListener("change", function () {
      variations[index].price = parseFloat(this.value) || 0;
      updateLocalStorageOnChange();
      console.log(variations);
    });
    price.appendChild(priceInput);
    tableRow.appendChild(price);

    const quantity = document.createElement("td");
    const quantityInput = document.createElement("input");
    quantityInput.type = "number";
    quantityInput.value = product.quantity;
    quantityInput.classList.add("price-input");
    quantityInput.addEventListener("change", function () {
      variations[index].quantity = parseInt(this.value, 10) || 0;
      updateLocalStorageOnChange();
      console.log(variations);
    });
    quantity.appendChild(quantityInput);
    tableRow.appendChild(quantity);

    const isMadeToOrder = document.createElement("td");
    const isMadeToOrderCheckbox = document.createElement("input");
    isMadeToOrderCheckbox.type = "checkbox";
    isMadeToOrderCheckbox.checked = product.isMadeToOrder;
    isMadeToOrderCheckbox.classList.add("isMadeToOrder-checkbox");
    isMadeToOrderCheckbox.addEventListener("change", function () {
      variations[index].isMadeToOrder = this.checked;
      updateLocalStorageOnChange();
      console.log(variations);
    });
    isMadeToOrder.appendChild(isMadeToOrderCheckbox);
    tableRow.appendChild(isMadeToOrder);

    const deleteRow = document.createElement("td");
    const deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete";
    deleteButton.classList.add("delete-variation-button");
    deleteButton.addEventListener("click", function () {
      tableBody.removeChild(tableRow);
      variations.splice(index, 1);
      updateLocalStorageOnChange();
      populateTable();
      console.log(variations);
    });
    deleteRow.appendChild(deleteButton);
    tableRow.appendChild(deleteRow);
    tableBody.appendChild(tableRow);
  });
}

function saveVariationsToLocalStorage() {
  localStorage.setItem("variations", JSON.stringify(variations));
}

function loadVariationsFromLocalStorage() {
  const storedVariations = localStorage.getItem("variations");
  if (storedVariations) {
    variations = JSON.parse(storedVariations);
  }
}

window.onload = function () {
  loadVariationsFromLocalStorage();
  populateTable();
};

function updateLocalStorageOnChange() {
  saveVariationsToLocalStorage();
}


function previewImage(event) {
  const fileInput = event.target;
  const file = fileInput.files[0];

  if (file) {
      const reader = new FileReader();

      reader.onload = function(e) {
          const imgPreview = document.getElementById('imgPreview');
          imgPreview.src = e.target.result;
          imgPreview.style.display = 'block';
          deleteButtonContainer.style.display = "block";
      };

      reader.readAsDataURL(file);
  } 
}

document.addEventListener("DOMContentLoaded", function() {
  const productImgInput = document.getElementById("productImg"); // Assuming "productImg" is the id of your file input element

  if (!productImgInput.value) {
      deleteButtonContainer.style.display = "none";
  } else {
      deleteButtonContainer.style.display = "block";
  }
});


document.addEventListener("DOMContentLoaded", function() {
  const multipleImageInput = document.getElementById("multiple-image-input");
  const previewContainer = document.getElementById('image-preview-container');

  multipleImageInput.addEventListener('change', function(event) {
      const files = event.target.files;

      // Clear previous previews
      previewContainer.innerHTML = '';

      Array.from(files).forEach((file, index) => {
          const reader = new FileReader();

          reader.onload = function(e) {
              const imageContainer = document.createElement('div');
              imageContainer.className = 'image-container';

              const deleteButtonContainer = document.createElement('div');
              deleteButtonContainer.className = 'delete-button-container';

              const deleteButton = document.createElement('button');
              deleteButton.className = 'delete-button';
              deleteButton.textContent = 'X';
              deleteButton.addEventListener('click', function() {
                  previewContainer.removeChild(imageContainer);
                  toggleDeleteButtonVisibility();
              });

              deleteButtonContainer.appendChild(deleteButton);

              const img = document.createElement('img');
              img.src = e.target.result;
              img.alt = `Preview Image ${index + 1}`;
              img.style.maxWidth = '100px'; 
              img.style.maxHeight = '100px';

              imageContainer.appendChild(deleteButtonContainer);
              imageContainer.appendChild(img);

              previewContainer.appendChild(imageContainer);

              // Show the delete button container
              deleteButtonContainer.style.display = 'block';
          };

          reader.readAsDataURL(file);
      });

      // Update delete button visibility after handling all files
      toggleDeleteButtonVisibility();
  });

  function toggleDeleteButtonVisibility() {
      const deleteButtonContainers = previewContainer.querySelectorAll('.delete-button-container');
      deleteButtonContainers.forEach(container => {
          if (previewContainer.children.length > 0) {
              container.style.display = 'block';
          } else {
              container.style.display = 'none';
          }
      });
  }

  // Initial check
  toggleDeleteButtonVisibility();
});