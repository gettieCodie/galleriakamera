// User Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log("Dashboard loaded");

    // initializeDashboard();
    loadPurchases();
    loadKPIs();
    loadSellingItems();
    loadWishlist();
    initializeStatusTabs();

    initializeSellItemModal();
});

// function initializeDashboard() {
//     console.log("Dashboard initializing...");
//     // Initialize modal functionality
//     initializeSellItemModal();
    
//     // Initialize tab functionality
//     initializeStatusTabs();
    
//     // Load mock data for demonstration
//     loadMockData();
// }

function loadPurchases() {
    console.log('Loading purchases...');
    
    fetch('core/get_purchases.php') // Use relative path from current location
        .then(res => {
            console.log('Response status:', res.status);
            return res.json();
        })
        .then(data => {
            console.log('Purchases data:', data);
            
            if (data.status === 'success') {
                displayPurchases(data.orders);
                updatePurchaseCount(data.orders.length);
            } else {
                console.error('Error loading purchases:', data.message);
                showEmptyPurchases();
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showEmptyPurchases();
        });
}

function displayPurchases(orders) {
    const purchasesList = document.getElementById('purchases-list');
    
    if (!purchasesList) {
        console.error('purchases-list element not found');
        return;
    }
    
    if (orders.length === 0) {
        showEmptyPurchases();
        return;
    }
    
    purchasesList.innerHTML = orders.map(order => `
        <div class="purchase-card" onclick="viewReceipt(${order.order_id})">
            <div class="purchase-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="purchase-info">
                <h4 class="purchase-title">Order #${order.order_id}</h4>
                <div class="purchase-meta">
                    <span class="purchase-date">
                        <i class="far fa-calendar"></i>
                        ${formatDate(order.date)}
                    </span>
                    <span class="purchase-amount">
                        <i class="fas fa-peso-sign"></i>
                        ₱${parseFloat(order.total).toLocaleString('en-PH', {minimumFractionDigits: 2})}
                    </span>
                    <span class="purchase-items">
                        ${order.items_count} ${order.items_count === 1 ? 'item' : 'items'}
                    </span>
                </div>
                <div class="purchase-status">
                    <span class="status-badge status-${order.status.toLowerCase()}">${order.status}</span>
                    <span class="payment-method">${order.payment_method}</span>
                </div>
            </div>
            <div class="purchase-arrow">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
    `).join('');
}

function showEmptyPurchases() {
    const purchasesList = document.getElementById('purchases-list');
    if (purchasesList) {
        purchasesList.innerHTML = `
            <div class="empty-state">
                <img src="assets/images/empty.png" alt="Empty" class="empty-icon">
                <h3>No purchases yet</h3>
                <p>Your purchase history will appear here</p>
            </div>
        `;
    }
}

function viewReceipt(orderID) {
    console.log('Viewing receipt for order:', orderID);
    window.location.href = `receipt.php?order_id=${orderID}`;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
}

function updatePurchaseCount(count) {
    const purchaseCountElement = document.getElementById('total-purchases');
    if (purchaseCountElement) {
        purchaseCountElement.textContent = count;
    }
}

// ========================================
// KPI SECTION (Placeholder)
// ========================================

function loadKPIs() {
    console.log('Loading KPIs...');

    // Load pending review and total listed counts
    fetch('core/get_kpi_stats.php')
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('pending-review').textContent = data.pending_review || 0;
                document.getElementById('total-listed').textContent = data.total_listed || 0;
            }
        })
        .catch(err => console.error('KPI stats error:', err));

    // ---- Load Wishlist Count ----
    fetch('core/count_wishlist.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('wishlist-count').textContent = data.count || 0;
        })
        .catch(err => console.error('Wishlist count error:', err));
}

function loadSellingItems(status = 'all') {
    console.log('Loading selling items with status:', status);
    const container = document.getElementById('selling-items-list');
    
    const url = status === 'all' ? 'core/get_user_listings.php' : `core/get_user_listings.php?status=${status}`;
    
    fetch(url)
        .then(res => res.json())
        .then(data => {
            console.log('Selling items data:', data);
            
            if (!Array.isArray(data) || data.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <img src="assets/images/empty.png" alt="No listings" class="empty-icon">
                        <h3>No items listed yet</h3>
                        <p>Start selling your cameras by clicking "Sell an Item"</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = data.map(item => `
                <div class="item-card" data-status="${item.status.toLowerCase()}">
                    <img src="${item.image_path || 'assets/images/empty.png'}" alt="${item.brand} ${item.model}" class="item-image" onerror="this.src='assets/images/empty.png'">
                    <div class="item-details">
                        <h4 class="item-title">${item.brand} ${item.model}</h4>
                        <p class="item-specs">${item.megapixels}MP • ${item.sensor}</p>
                        <p class="item-price">₱${parseFloat(item.asking_price).toLocaleString('en-PH', {minimumFractionDigits: 2})}</p>
                    </div>
                    <span class="item-status status-${item.status.toLowerCase()}">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</span>
                </div>
            `).join('');
        })
        .catch(error => {
            console.error('Error loading selling items:', error);
            container.innerHTML = `
                <div class="empty-state">
                    <h3>Error loading items</h3>
                </div>
            `;
        });
}

function loadWishlist() {
    console.log('Loading wishlist...');

    const container = document.getElementById('wishlist-items');

      fetch('core/get_wishlist.php')
        .then(res => res.json())
        .then(data => {
            console.log("Wishlist data:", data);

            if (!Array.isArray(data) || data.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <img src="assets/images/empty.png" class="empty-icon">
                        <h3>Wishlist is empty</h3>
                        <p>Save cameras you're interested in from the marketplace</p>
                    </div>
                `;
                return;
            }

            // Render items
            container.innerHTML = data.map(item => `
                <div class="wishlist-card" style="cursor: pointer;" onclick="wishlistCardClick({listing_id: ${item.listing_id}, brand: '${item.brand.replace(/'/g, "\\'")}', model: '${item.model.replace(/'/g, "\\'")}', megapixels: ${item.megapixels}, sensor: '${item.sensor.replace(/'/g, "\\'")}', selling_price: ${item.selling_price}, original_price: ${item.original_price || 0}, image_path: '${item.image_path}', description: '${(item.description || '').replace(/'/g, "\\'")}'})">
                    <img 
                        src="${item.image_path ? item.image_path : 'assets/images/empty.png'}" 
                        class="wishlist-card-image"
                        onerror="this.src='assets/images/empty.png'"
                    >
                    <div class="wishlist-card-content">
                        <h4 class="wishlist-card-title">${item.brand} ${item.model}</h4>
                        <p class="wishlist-card-specs">${item.megapixels}MP • ${item.sensor}</p>
                        <div class="wishlist-card-price">
                            <span class="wishlist-card-price-current">₱${parseFloat(item.selling_price).toLocaleString()}</span>
                            ${item.original_price ? `<span class="wishlist-card-price-original">₱${parseFloat(item.original_price).toLocaleString()}</span>` : ''}
                        </div>
                    </div>
                    <div class="wishlist-card-actions">
                        <button class="wishlist-btn wishlist-btn-primary" onclick="event.stopPropagation(); addToCartWishlist(${item.listing_id})">Add to Cart</button>
                        <button class="wishlist-btn wishlist-btn-secondary" onclick="event.stopPropagation(); removeWishlistItem(${item.listing_id})">Remove</button>
                    </div>
                </div>
            `).join('');
        })
        .catch(error => {
            console.error("Wishlist fetch error:", error);
            container.innerHTML = `
                <div class="empty-state">
                    <h3>Error loading wishlist</h3>
                </div>
            `;
        });
}

function loadReviews() {
    const container = document.getElementById('reviews-list');
    // Mock reviews data
}

// Modal functionality
function initializeSellItemModal() {
    const modal = document.getElementById('sellItemModal');
    const sellBtn = document.getElementById('sellItemBtn');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancelSellBtn');
    const form = document.getElementById('sellItemForm');

    // Check if all elements exist
    if (!modal || !sellBtn || !closeBtn || !cancelBtn || !form) {
        console.error('Modal elements not found');
        return;
    }

    // Open modal
    sellBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    // Close modal
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    cancelBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitSellItemForm();
    });
}

// Status tabs functionality
function initializeStatusTabs() {
    const tabs = document.querySelectorAll('.status-tab');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Fetch items from backend based on status
            const status = this.getAttribute('data-status');
            loadSellingItems(status);
        });
    });
}

// Form submission handler
function submitSellItemForm() {
    const form = document.getElementById('sellItemForm');
    const formData = new FormData(form);
    
    // Disable submit button to prevent double submission
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';
    
    fetch('core/submit_listing.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showSuccessNotification('Your camera has been submitted for review!');
            document.getElementById('sellItemModal').style.display = 'none';
            form.reset();
            loadSellingItems();
            loadKPIs();
            // Reset button
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit for Review';
        } else {
            showErrorNotification('Error: ' + (data.message || 'Failed to submit'));
            // Reset button
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit for Review';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showErrorNotification('Error submitting form: ' + error.message);
        // Reset button
        submitBtn.disabled = false;
        submitBtn.textContent = 'Submit for Review';
    });
}

// Wishlist card click handler - opens product modal
function wishlistCardClick(product) {
    console.log('Wishlist card clicked:', product);
    if (typeof openProductModal === 'function') {
        openProductModal(product);
    } else {
        console.error('openProductModal function not available');
    }
}

// Add to cart from wishlist
async function addToCartWishlist(listingId) {
    const formData = new FormData();
    formData.append("listing_id", listingId);

    try {
        const res = await fetch("core/add_cart.php", {
            method: "POST",
            body: formData,
            credentials: "same-origin"
        });

        const data = await res.json();

        if (data.status === "ok") {
            showSuccessNotification("Added to cart! 🛒");
            loadKPIs();
        } else {
            showErrorNotification(data.msg || "Failed to add to cart");
        }
    } catch (error) {
        console.error("Error adding to cart:", error);
        showErrorNotification("Error adding to cart");
    }
}

// Remove from wishlist
async function removeWishlistItem(listingId) {
    // Show confirmation modal instead of browser confirm
    showConfirmationModal(
        "Remove from Wishlist?",
        "Are you sure you want to remove this item from your wishlist?",
        async () => {
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
                    showSuccessNotification("Removed from wishlist");
                    loadWishlist();
                    loadKPIs();
                } else {
                    showErrorNotification("Failed to remove from wishlist");
                }
            } catch (error) {
                console.error("Error removing from wishlist:", error);
                showErrorNotification("Error removing item");
            }
        }
    );
}

// Success Notification UI
function showSuccessNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification notification-success';
    notification.innerHTML = `
        <div class="notification-content">
            <div class="notification-icon">
                <i class="fa-solid fa-check-circle"></i>
            </div>
            <div class="notification-text">
                <h4 class="notification-title">Success</h4>
                <p class="notification-message">${message}</p>
            </div>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Error Notification UI
function showErrorNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification notification-error';
    notification.innerHTML = `
        <div class="notification-content">
            <div class="notification-icon">
                <i class="fa-solid fa-exclamation-circle"></i>
            </div>
            <div class="notification-text">
                <h4 class="notification-title">Error</h4>
                <p class="notification-message">${message}</p>
            </div>
            <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Confirmation Modal UI
function showConfirmationModal(title, message, onConfirm, onCancel = null) {
    const modal = document.createElement('div');
    modal.className = 'confirmation-modal-overlay';
    modal.innerHTML = `
        <div class="confirmation-modal">
            <div class="confirmation-modal-header">
                <h3 class="confirmation-modal-title">${title}</h3>
                <button class="confirmation-modal-close" onclick="this.closest('.confirmation-modal-overlay').remove()">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <div class="confirmation-modal-body">
                <p class="confirmation-modal-message">${message}</p>
            </div>
            <div class="confirmation-modal-footer">
                <button class="confirmation-btn cancel" onclick="
                    const modal = this.closest('.confirmation-modal-overlay');
                    modal.remove();
                ">Cancel</button>
                <button class="confirmation-btn confirm" onclick="
                    const modal = this.closest('.confirmation-modal-overlay');
                    modal.remove();
                ">Remove</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Handle confirm button click
    const confirmBtn = modal.querySelector('.confirmation-btn.confirm');
    confirmBtn.addEventListener('click', () => {
        if (onConfirm) onConfirm();
    });
    
    // Close modal when clicking overlay
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.remove();
            if (onCancel) onCancel();
        }
    });
}