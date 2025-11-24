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
                        ${quantity > 1 ? `<div class="quantity-info">Quantity: ${quantity}</div>` : ''}
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
    if (!confirm("Remove this item from your cart?")) {
        return;
    }
    
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

document.addEventListener('DOMContentLoaded', () => {
    console.log("Cart page loaded, updating badges...");
    loadCart();
    updateWishlistBadge();
    updateCartBadge();
});