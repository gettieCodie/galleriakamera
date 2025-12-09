window.allProducts = [];

// Search function
function searchProducts(searchTerm) {
    const productList = document.getElementById("product-list");
    const noListings = document.getElementById("no-listings");
    
    searchTerm = searchTerm.toLowerCase().trim();

    console.log("Searching for:", searchTerm);
    console.log("Total products:", window.allProducts.length);
    
    // If search is empty, show all products
    if (searchTerm === "") {
        displayProducts(allProducts);
        return;
    }
    
    // Filter products based on search term
    const filteredProducts = allProducts.filter(product => {
        const brand = product.brand.toLowerCase();
        const model = product.model.toLowerCase();
        const description = product.description.toLowerCase();
        const sensor = product.sensor.toLowerCase();
        const condition = product.condition.toLowerCase();
        
        return brand.includes(searchTerm) || 
               model.includes(searchTerm) || 
               description.includes(searchTerm) ||
               sensor.includes(searchTerm) ||
               condition.includes(searchTerm);
    });

    console.log("Filtered products:", filteredProducts.length);
    
    // Display filtered results
    if (filteredProducts.length > 0) {
        displayProducts(filteredProducts);
        noListings.style.display = "none";
    } else {
        productList.innerHTML = `
            <div class="no-results">
                <img src="assets/images/empty.png" alt="No results" style="width: 150px; opacity: 0.5;">
                <h3>No results found for "${searchTerm}"</h3>
                <p>Try searching for different keywords</p>
            </div>
        `;
        noListings.style.display = "none";
    }
}

// Display products (reusable function)
function displayProducts(products) {
    const productList = document.getElementById("product-list");
    const noListings = document.getElementById("no-listings");
    
    productList.innerHTML = "";
    
    if (products.length === 0) {
        noListings.style.display = "flex";
        return;
    }
    
    noListings.style.display = "none";
    
    products.forEach(product => {
        const name = `${product.brand} ${product.model}`;
        const price = parseFloat(product.selling_price).toLocaleString('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        const originalPrice = parseFloat(product.original_price).toLocaleString('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        const savings = (product.original_price - product.selling_price).toLocaleString('en-PH', {
            style: 'currency',
            currency: 'PHP',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        
        const image = product.image_path || 'assets/images/empty.png';
        const conditionClass = product.condition.toLowerCase() === 'new' ? 'condition-new' : 'condition-used';

        const card = document.createElement("div");
        card.className = "product-card";
        card.innerHTML = `
            <div class="product-image-container">
                <img src="${image}" class="product-image" alt="${name}" onerror="this.src='assets/images/empty-box.png'">
                <span class="product-condition ${conditionClass}">${product.condition}</span>
            </div>
            <div class="product-details">
                <h3 class="product-title">${name}</h3>
                <p class="product-specs">${product.megapixels}MP • ${product.sensor}</p>
                <p class="product-description">${product.description.substring(0, 100)}${product.description.length > 100 ? '...' : ''}</p>
                <div class="product-prices">
                    <span class="current-price">${price}</span>
                    <span class="original-price">${originalPrice}</span>
                </div>
                <div class="savings">You save ${savings}</div>
            </div>
            <div class="actions-group">
                <button class="action-btn wishlist-btn" data-listing-id="${product.listing_id}">
                    <img src="assets/images/wishlist.png" alt="Add to Wishlist">
                </button>
                <button class="action-btn cart-btn" data-listing-id="${product.listing_id}">
                    <img src="assets/images/shopping-bag.png" alt="Add to Cart">
                </button>
            </div>
        `;
        productList.appendChild(card);

        // Click on card to open modal (excluding action buttons)
        card.addEventListener('click', (e) => {
            if (!e.target.closest('.actions-group')) {
                if (typeof openProductModal === 'function') {
                    openProductModal(product);
                }
            }
        });

        const wishlistBtn = card.querySelector('.wishlist-btn');
        const cartBtn = card.querySelector('.cart-btn');

        wishlistBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            addToWishlist(product.listing_id);
        });
        cartBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            addToCart(product.listing_id);
        });
    });
}

// Initialize search functionality
function initializeSearch() {
    const searchInput = document.getElementById("searchInput");
    const searchClearBtn = document.getElementById("searchClearBtn");
    
    if (!searchInput){
        console.error("Search input not found!");
        return;
    }

    console.log("Initializing search...")

    // Search on input (real-time search)
    searchInput.addEventListener("input", (e) => {
        const searchTerm = e.target.value;
        searchProducts(searchTerm);
        
        // Show/hide clear button
        if (searchTerm) {
            searchClearBtn.style.display = "block";
        } else {
            searchClearBtn.style.display = "none";
        }
    });
    
    // Clear button functionality
    searchClearBtn.addEventListener("click", () => {
        searchInput.value = "";
        searchClearBtn.style.display = "none";
        searchProducts("");
        searchInput.focus();
    });
    
    // Search on Enter key
    searchInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            searchProducts(searchInput.value);
        }
    });

    console.log("Search initialized successfully")
}

// Price filter function
window.applyPriceFilter = function() {
    const minPriceInput = document.getElementById("minPrice");
    const maxPriceInput = document.getElementById("maxPrice");
    const minPrice = minPriceInput.value ? parseFloat(minPriceInput.value) : 0;
    const maxPrice = maxPriceInput.value ? parseFloat(maxPriceInput.value) : Infinity;
    
    const filteredProducts = window.allProducts.filter(product => {
        const price = parseFloat(product.selling_price);
        return price >= minPrice && price <= maxPrice;
    });
    
    console.log(`Filtering by price: ₱${minPrice} - ₱${maxPrice}`);
    console.log(`Filtered products: ${filteredProducts.length}`);
    
    if (filteredProducts.length > 0) {
        displayProducts(filteredProducts);
    } else {
        const productList = document.getElementById("product-list");
        const noListings = document.getElementById("no-listings");
        productList.innerHTML = `
            <div class="no-results">
                <img src="assets/images/empty.png" alt="No results" style="width: 150px; opacity: 0.5;">
                <h3>No products found in price range ₱${minPrice.toLocaleString()} - ₱${maxPrice.toLocaleString()}</h3>
                <p>Try adjusting your price filter</p>
            </div>
        `;
        noListings.style.display = "none";
    }
}