async function loadCart() {
    try {
        const res = await fetch('core/get_cart.php');
        
        if (!res.ok) {
            throw new Error('Failed to fetch cart');
        }
        
        const items = await res.json();
        const cartGrid = document.getElementById("cart-grid");
        const emptyCart = document.getElementById("empty-cart");
        const cartSummary = document.getElementById("cart-summary");
        
        cartGrid.innerHTML = "";
        
        if (items.length > 0) {
            emptyCart.style.display = "none";
            cartGrid.style.display = "grid";
            cartSummary.style.display = "block";
            
            let subtotal = 0;
            
            items.forEach(product => {
                const name = `${product.brand} ${product.model}`;
                const price = parseFloat(product.selling_price);
                const quantity = parseInt(product.quantity) || 1;
                const itemTotal = price * quantity;
                
                const priceFormatted = price.toLocaleString('en-PH', {
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
                
                subtotal += itemTotal;
                
                const image = product.image_path || 'assets/images/empty-box.png';
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
                            <span class="current-price">${priceFormatted}</span>
                            <span class="original-price">${originalPrice}</span>
                        </div>
                        <div class="savings">You save ${savings}</div>
                        <div class="quantity-control">
                            <button class="qty-btn qty-minus" data-listing-id="${product.listing_id}">−</button>
                            <input type="number" class="qty-input" value="${quantity}" min="1" data-listing-id="${product.listing_id}" readonly>
                            <button class="qty-btn qty-plus" data-listing-id="${product.listing_id}">+</button>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="btn-remove" data-listing-id="${product.listing_id}">
                            Remove from Cart
                        </button>
                    </div>
                `;
                
                cartGrid.appendChild(card);
                
                const removeBtn = card.querySelector('.btn-remove');
                removeBtn.addEventListener('click', () => removeFromCart(product.listing_id));
                
                // Quantity control buttons
                const minusBtn = card.querySelector('.qty-minus');
                const plusBtn = card.querySelector('.qty-plus');
                const qtyInput = card.querySelector('.qty-input');
                
                minusBtn.addEventListener('click', () => {
                    const currentQty = parseInt(qtyInput.value) || 1;
                    if (currentQty > 1) {
                        const newQty = currentQty - 1;
                        updateCartQuantity(product.listing_id, newQty);
                    }
                });
                
                plusBtn.addEventListener('click', () => {
                    const currentQty = parseInt(qtyInput.value) || 1;
                    const newQty = currentQty + 1;
                    updateCartQuantity(product.listing_id, newQty);
                });
            });
            
            const subtotalFormatted = subtotal.toLocaleString('en-PH', {
                style: 'currency',
                currency: 'PHP',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById("subtotal").textContent = subtotalFormatted;
            document.getElementById("total").textContent = subtotalFormatted;
            
        } else {
            cartGrid.style.display = "none";
            cartSummary.style.display = "none";
            emptyCart.style.display = "flex";
        }
    } catch (error) {
        console.error("Failed to load cart:", error);
        document.getElementById("empty-cart").style.display = "flex";
    }
}

async function removeFromCart(listingId) {
    // Show custom modal instead of confirm dialog
    showRemoveConfirmModal(listingId);
}

function showRemoveConfirmModal(listingId) {
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
                <p>Are you sure you want to remove this item from your cart?</p>
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
        await performRemoveFromCart(listingId);
    });
    
    // Close on overlay click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
        }
    });
}

async function performRemoveFromCart(listingId) {
    try {
        const formData = new FormData();
        formData.append("listing_id", listingId);
        
        const res = await fetch("core/delete_cart.php", {
            method: "POST",
            body: formData
        });
        
        const data = await res.json();
        
        if (data.status === "ok") {
            await updateCartBadge();
            await loadCart();
        }
    } catch (error) {
        console.error("Error removing from cart:", error);
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

// Update quantity in cart
async function updateCartQuantity(listingId, newQuantity) {
    try {
        const formData = new FormData();
        formData.append('listing_id', listingId);
        formData.append('quantity', newQuantity);
        
        const res = await fetch('core/update_cart_quantity.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await res.json();
        
        if (data.status === 'ok') {
            console.log('Quantity updated successfully');
            loadCart();
            updateCartBadge();
        } else {
            alert('Failed to update quantity: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error updating quantity:', error);
        alert('Error updating quantity');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log("Cart page loaded, updating badges...");
    loadCart();
    updateWishlistBadge();
    updateCartBadge();
});