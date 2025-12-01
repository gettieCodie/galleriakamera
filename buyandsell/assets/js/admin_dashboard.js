// Admin Dashboard JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeAdminDashboard();
});

function initializeAdminDashboard() {
    // Initialize tab navigation
    initializeTabNavigation();
    
    // Initialize purchase tabs
    initializePurchaseTabs();
    
    // Initialize modals
    initializeModals();
    
    // Initialize dynamic calculations
    initializeCalculations();
    
    // Initialize Quick Action buttons
    initializeQuickActions();
}

// Quick Action Buttons Functionality
function initializeQuickActions() {
    // Add New Listing Button
    const addListingBtn = document.querySelector('.action-btn.primary');
    if (addListingBtn) {
        addListingBtn.addEventListener('click', function() {
            // Open your existing sell item modal or create a new one
            const sellModal = document.getElementById('sellItemModal');
            if (sellModal) {
                sellModal.style.display = 'flex';
            } else {
                alert('Add New Listing feature would open here');
                // Or redirect to listing page
                // window.location.href = 'add_listing.php';
            }
        });
    }

    // Review Pending Items Button
    const reviewItemsBtn = document.querySelector('.action-btn.secondary');
    if (reviewItemsBtn) {
        reviewItemsBtn.addEventListener('click', function() {
            // Switch to Camera Purchases tab and show pending items
            switchToTab('camera-purchases');
            
            // Ensure pending tab is active
            setTimeout(() => {
                const pendingTab = document.querySelector('[data-purchase-tab="pending"]');
                if (pendingTab) {
                    pendingTab.click();
                }
            }, 100);
        });
    }

    // Process Orders Button
    const processOrdersBtn = document.querySelector('.action-btn.tertiary');
    if (processOrdersBtn) {
        processOrdersBtn.addEventListener('click', function() {
            // Switch to Customer Orders tab
            switchToTab('customer-orders');
        });
    }
}

// Helper function to switch tabs
function switchToTab(tabName) {
    const tabButton = document.querySelector(`[data-tab="${tabName}"]`);
    if (tabButton) {
        tabButton.click();
    }
}

// Tab Navigation
function initializeTabNavigation() {
    const navTabs = document.querySelectorAll('.nav-tab');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    navTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all tabs and panes
            navTabs.forEach(t => t.classList.remove('active'));
            tabPanes.forEach(p => p.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding pane
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
}

// Purchase Tabs
function initializePurchaseTabs() {
    const purchaseTabs = document.querySelectorAll('.purchase-tab');
    const purchaseContents = document.querySelectorAll('.purchase-content');
    
    purchaseTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetContent = this.getAttribute('data-purchase-tab');
            
            // Remove active class from all tabs and contents
            purchaseTabs.forEach(t => t.classList.remove('active'));
            purchaseContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked tab and corresponding content
            this.classList.add('active');
            document.querySelector(`[data-purchase-content="${targetContent}"]`).classList.add('active');
        });
    });
}

// Modal Functionality
function initializeModals() {
    const reviewButtons = document.querySelectorAll('.btn-review-offer');
    const modal = document.getElementById('reviewOfferModal');
    const closeBtn = modal?.querySelector('.close');
    
    // Open review modal
    reviewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item');
            openReviewModal(itemId);
        });
    });
    
    // Close modal
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
}

function openReviewModal(itemId) {
    const modal = document.getElementById('reviewOfferModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Dynamic Calculations for Offer Modal
function initializeCalculations() {
    const purchaseOfferInput = document.getElementById('purchaseOffer');
    const markupInput = document.getElementById('markupPrice');
    
    if (purchaseOfferInput && markupInput) {
        [purchaseOfferInput, markupInput].forEach(input => {
            input.addEventListener('input', calculateFinalPrices);
        });
    }
}

function calculateFinalPrices() {
    const purchaseOffer = parseFloat(document.getElementById('purchaseOffer').value) || 0;
    const markup = parseFloat(document.getElementById('markupPrice').value) || 0;
    
    const finalPrice = purchaseOffer + markup;
    const potentialProfit = markup;
    
    // Update displayed prices
    const finalPriceElement = document.querySelector('.final-price');
    const profitPriceElement = document.querySelector('.profit-price');
    
    if (finalPriceElement) {
        finalPriceElement.textContent = `₱${finalPrice.toLocaleString()}`;
    }
    
    if (profitPriceElement) {
        profitPriceElement.textContent = `₱${potentialProfit.toLocaleString()}`;
    }
}

// Order Status Updates
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-update')) {
        const orderId = e.target.getAttribute('data-order');
        const action = e.target.getAttribute('data-action');
        updateOrderStatus(orderId, action);
    }
});

function updateOrderStatus(orderId, action) {
    // In real implementation, this would make an API call
    const statusMap = {
        'ship': 'Shipped',
        'deliver': 'Delivered'
    };
    
    alert(`Order ${orderId} marked as ${statusMap[action]}`);
    // Here you would update the UI and make API call
}

// View More functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('view-more')) {
        const itemId = e.target.getAttribute('data-id');
        showItemDetails(itemId);
    }
});

function showItemDetails(itemId) {
    // In real implementation, this would show a modal or expand the row
    alert(`Showing details for item ${itemId}`);
    // You can implement a modal or expandable row here
}