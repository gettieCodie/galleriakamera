const productList = document.getElementById("product-list");
const noListings = document.getElementById("no-listings");

async function loadMarketplace() {
    try {
        const res = await fetch('core/get_listings.php');
        
        if (!res.ok) {
            throw new Error('Failed to fetch listings');
        }
        
        const listings = await res.json();

        productList.innerHTML = "";

        if (listings.length > 0) {
            noListings.style.display = "none";

            listings.forEach(product => {
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
                
                // Use the first image or default image
                const image = product.image_path || product.images?.[0] || 'assets/images/empty-box.png';
                
                // Format condition with proper styling
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
                        <button class="action-btn wishlist-btn" onclick="addToWishlist(${product.listing_id})">
                            <img src="assets/images/wishlist.png" alt="Add to Wishlist">
                        </button>
                        <button class="action-btn cart-btn" onclick="addToCart(${product.listing_id})">
                            <img src="assets/images/shopping-bag.png" alt="Add to Cart">
                        </button>
                    </div>
                `;
                productList.appendChild(card);
            });
        } else {
            noListings.style.display = "flex";
        }
    } catch (error) {
        console.error("Failed to load listings:", error);
        noListings.style.display = "flex";
        productList.innerHTML = `
            <div class="error-message">
                <p>Failed to load products. Please try again later.</p>
            </div>
        `;
    }
}

// Placeholder functions for buttons
function addToWishlist(listingId) {
    console.log('Add to wishlist:', listingId);
    // Implement wishlist functionality
}

function addToCart(listingId) {
    console.log('Add to cart:', listingId);
    // Implement cart functionality
}

// Refresh listings when new products are added
function refreshListings() {
    loadMarketplace();
}

document.addEventListener('DOMContentLoaded', loadMarketplace);

// Optional: Auto-refresh every 30 seconds to see new listings
setInterval(loadMarketplace, 30000);