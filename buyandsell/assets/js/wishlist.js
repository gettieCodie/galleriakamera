async function loadWishlist() {
    try {
        const res = await fetch('core/get_wishlist.php');
        
        if (!res.ok) {
            throw new Error('Failed to fetch wishlist');
        }
        
        const items = await res.json();
        console.log("Wishlist items: ", items);

        const wishlistGrid = document.getElementById("wishlist-grid");
        const emptyWishlist = document.getElementById("empty-wishlist");
        
        wishlistGrid.innerHTML = "";
        
        if (items.length > 0) {
            emptyWishlist.style.display = "none";
            wishlistGrid.style.display = "grid";
            
            items.forEach(product => {
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
                        <img src="${image}" class="product-image" alt="${name}" onerror="this.src='assets/images/empty.png'">
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
                    <div class="card-actions">
                        <button class="btn-remove" data-listing-id="${product.listing_id}">
                            Remove from Wishlist
                        </button>
                    </div>
                `;
                
                wishlistGrid.appendChild(card);
                
                const removeBtn = card.querySelector('.btn-remove');
                removeBtn.addEventListener('click', () => removeFromWishlist(product.listing_id));
            });
        } else {
            wishlistGrid.style.display = "none";
            emptyWishlist.style.display = "flex";
        }
    } catch (error) {
        console.error("Failed to load wishlist:", error);
        document.getElementById("empty-wishlist").style.display = "flex";
    }
}

async function removeFromWishlist(listingId) {
    // Show custom modal instead of confirm dialog
    showRemoveWishlistConfirmModal(listingId);
}

function showRemoveWishlistConfirmModal(listingId) {
    // Create modal overlay
    const modal = document.createElement('div');
    modal.className = 'remove-modal-overlay';
    modal.innerHTML = `
        <div class="remove-modal">
            <div class="remove-modal-header">
                <h2>Remove Item</h2>
                <button class="remove-modal-close" aria-label="Close">✕</button>
            </div>
            <div class="remove-modal-body">
                <p>Are you sure you want to remove this item from your wishlist?</p>
            </div>
            <div class="remove-modal-footer">
                <button class="remove-modal-cancel">Cancel</button>
                <button class="remove-modal-confirm">Remove</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Close button
    const closeBtn = modal.querySelector('.remove-modal-close');
    closeBtn.addEventListener('click', () => modal.remove());
    
    // Cancel button
    const cancelBtn = modal.querySelector('.remove-modal-cancel');
    cancelBtn.addEventListener('click', () => modal.remove());
    
    // Confirm button
    const confirmBtn = modal.querySelector('.remove-modal-confirm');
    confirmBtn.addEventListener('click', async () => {
        modal.remove();
        await performRemoveFromWishlist(listingId);
    });
    
    // Close on overlay click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

async function performRemoveFromWishlist(listingId) {
    try {
        const formData = new FormData();
        formData.append("listing_id", listingId);
        
        const res = await fetch("core/delete_wishlist.php", {
            method: "POST",
            body: formData
        });
        
        const data = await res.json();
        console.log("Remove response:", data);
        
        if (data.status === "ok") {
            await updateWishlistBadge();
            await loadWishlist();
        }
    } catch (error) {
        console.error("Error removing from wishlist:", error);
        alert("Failed to remove item");
    }
}

async function updateWishlistBadge() {
    try {
        const res = await fetch("core/count_wishlist.php");
        const text = await res.text();
        console.log("Wishlist badge response:", text);
        
        const data = JSON.parse(text);
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
        const text = await res.text();
        console.log("Cart badge response:", text);
        
        const data = JSON.parse(text);
        const badge = document.getElementById("cart-count");
        if (badge) {
            badge.textContent = data.count || 0;
        }
    } catch (error) {
        console.error("Error updating cart badge:", error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log("Wishlist page loaded, updating badges...");
    loadWishlist();
    updateWishlistBadge();
    updateCartBadge();
});