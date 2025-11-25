const productList = document.getElementById("product-list");
const noListings = document.getElementById("no-listings");

window.addToWishlist = async function(listingId) {
    const formData = new FormData();
    formData.append("listing_id", listingId);

    const res = await fetch("core/add_wishlist.php", {
        method: "POST",
        body: formData,
        credentials: "same-origin"
    });

    const data = await res.json();

    if (data.status === "ok") {
        updateWishlistBadge();
        alert("Added to wishlist!");
    } else {
        alert("Error: " + (data.msg || "Failed to add"));
    }
}

window.addToCart = async function(listingId) {
    const formData = new FormData();
    formData.append("listing_id", listingId);

    const res = await fetch("core/add_cart.php", {
        method: "POST",
        body: formData,
        credentials: "same-origin"
    });

    const data = await res.json();

    if (data.status === "ok") {
        updateCartBadge();
        alert("Added to cart!");
    } else {
        alert("Error: " + (data.msg || "Failed to add"));
    }
}

async function updateWishlistBadge() {
    try {
        const res = await fetch("core/count_wishlist.php");
        const text = await res.text(); // Get as text first
        console.log("Wishlist response:", text); // Debug log
        
        const data = JSON.parse(text); // Then parse
        const badge = document.getElementById("wishlist-count");
        if (badge) {
            badge.textContent = data.count || 0;
        }
    } catch (error) {
        console.error("Error updating wishlist badge:", error);
    }
}

async function updateCartBadge() {
    try {
        const res = await fetch("core/count_cart.php");
        const text = await res.text(); // Get as text first
        console.log("Cart response:", text); // Debug log
        
        const data = JSON.parse(text); // Then parse
        const badge = document.getElementById("cart-count");
        if (badge) {
            badge.textContent = data.count || 0;
        }
    } catch (error) {
        console.error("Error updating cart badge:", error);
    }
}

async function loadMarketplace() {
    try {
        const res = await fetch('core/get_listings.php');
        
        if (!res.ok) {
            throw new Error('Failed to fetch listings');
        }
        
        const listings = await res.json();
        console.log('Loaded listings:', listings);

        //Store all products globally for searcgh
        window.allProducts = listings;

        //Display all products initially
        if(typeof displayProducts == 'function'){
            displayProducts(allProducts);
        } else {
            console.error('displayProducts function not found!');
        }

        // productList.innerHTML = "";

        // if (listings.length > 0) {
        //     noListings.style.display = "none";

        //     listings.forEach(product => {
        //         const name = `${product.brand} ${product.model}`;
        //         const price = parseFloat(product.selling_price).toLocaleString('en-PH', {
        //             style: 'currency',
        //             currency: 'PHP',
        //             minimumFractionDigits: 2,
        //             maximumFractionDigits: 2
        //         });
        //         const originalPrice = parseFloat(product.original_price).toLocaleString('en-PH', {
        //             style: 'currency',
        //             currency: 'PHP',
        //             minimumFractionDigits: 2,
        //             maximumFractionDigits: 2
        //         });
        //         const savings = (product.original_price - product.selling_price).toLocaleString('en-PH', {
        //             style: 'currency',
        //             currency: 'PHP',
        //             minimumFractionDigits: 2,
        //             maximumFractionDigits: 2
        //         });
                
        //         // Use the first image or default image
        //         const image = product.image_path || product.images?.[0] || 'assets/images/empty-box.png';
                
        //         // Format condition with proper styling
        //         const conditionClass = product.condition.toLowerCase() === 'new' ? 'condition-new' : 'condition-used';

        //         const card = document.createElement("div");
        //         card.className = "product-card";
        //         card.innerHTML = `
        //             <div class="product-image-container">
        //                 <img src="${image}" class="product-image" alt="${name}" onerror="this.src='assets/images/empty-box.png'">
        //                 <span class="product-condition ${conditionClass}">${product.condition}</span>
        //             </div>
        //             <div class="product-details">
        //                 <h3 class="product-title">${name}</h3>
        //                 <p class="product-specs">${product.megapixels}MP • ${product.sensor}</p>
        //                 <p class="product-description">${product.description.substring(0, 100)}${product.description.length > 100 ? '...' : ''}</p>
        //                 <div class="product-prices">
        //                     <span class="current-price">${price}</span>
        //                     <span class="original-price">${originalPrice}</span>
        //                 </div>
        //                 <div class="savings">You save ${savings}</div>
        //             </div>
        //             <div class="actions-group">
        //                 <button class="action-btn wishlist-btn" onclick="addToWishlist(${product.listing_id})">
        //                     <img src="assets/images/wishlist.png" alt="Add to Wishlist">
        //                 </button>
        //                 <button class="action-btn cart-btn" onclick="addToCart(${product.listing_id})">
        //                     <img src="assets/images/shopping-bag.png" alt="Add to Cart">
        //                 </button>
        //             </div>
        //         `;
        //         productList.appendChild(card);
        //     });
        // } else {
        //     noListings.style.display = "flex";
        // }
    } catch (error) {
        console.error("Failed to load listings:", error);
        const noListings = document.getElementById("no-listings");
        const productList = document.getElementById("product-list");
        noListings.style.display = "flex";
        productList.innerHTML = `
            <div class="error-message">
                <p>Failed to load products. Please try again later.</p>
            </div>
        `;
    }
}

// Refresh listings when new products are added
function refreshListings() {
    loadMarketplace();
    updateWishlistBadge();
    updateCartBadge();
}

document.addEventListener('DOMContentLoaded', () => {
    console.log("Marketplace loaded, updating badges...");
    loadMarketplace();
    updateWishlistBadge();
    updateCartBadge();
    initializeSearch();
    console.log("Search initialization attempt complete.");
});

// // Optional: Auto-refresh every 30 seconds to see new listings
// setInterval(() => {
//     loadMarketplace();
//     updateWishlistBadge();
//     updateCartBadge();
// }, 30000);