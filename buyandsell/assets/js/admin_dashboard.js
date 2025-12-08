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
    
    // Load transactions
    loadAdminTransactions();
}

// Quick Action Buttons Functionality
function initializeQuickActions() {
    // Add New Listing Button
    const addListingBtn = document.querySelector('.action-btn.primary');
    if (addListingBtn) {
        addListingBtn.addEventListener('click', function() {
            // Open the add listing modal
            const listingModal = document.getElementById('listingModal');
            if (listingModal) {
                listingModal.style.display = 'flex';
            } else {
                alert('Listing modal not found');
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

// Approve item from modal
function approveCurrentItem() {
    if (currentModalItemId) {
        approveItem(currentModalItemId);
    } else {
        alert('No item selected');
    }
}

// Reject item from modal
function rejectCurrentItem() {
    if (currentModalItemId) {
        rejectItem(currentModalItemId);
    } else {
        alert('No item selected');
    }
}

// Approve item submission
function approveItem(listingId) {
    if (confirm('Are you sure you want to approve this item?')) {
        fetch('approve_reject_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=approve&listing_id=' + listingId
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('HTTP error status: ' + res.status);
            }
            return res.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.status === 'success') {
                    alert('Item approved successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (e) {
                console.error('Failed to parse response:', text);
                alert('Error: Invalid response from server. Check console for details.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error approving item: ' + error.message);
        });
    }
}

// Reject item submission
function rejectItem(listingId) {
    if (confirm('Are you sure you want to reject this item?')) {
        fetch('approve_reject_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=reject&listing_id=' + listingId
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('HTTP error status: ' + res.status);
            }
            return res.text();
        })
        .then(text => {
            try {
                const data = JSON.parse(text);
                if (data.status === 'success') {
                    alert('Item rejected successfully!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (e) {
                console.error('Failed to parse response:', text);
                alert('Error: Invalid response from server. Check console for details.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error rejecting item: ' + error.message);
        });
    }
}

// Store current item ID for modal actions
let currentModalItemId = null;

// Open pending item modal with item data
function openPendingModal(itemData) {
    const modal = document.getElementById('reviewOfferModal');
    if (modal) {
        // Store the item ID for approve/reject actions
        currentModalItemId = itemData.user_listing_id;
        
        // Update modal with item data
        document.getElementById('modalCameraName').textContent = itemData.brand + ' ' + itemData.model;
        
        // Update price information
        const priceInfo = modal.querySelector('.price-info');
        if (priceInfo) {
            const rows = priceInfo.querySelectorAll('.price-row');
            if (rows[0]) rows[0].querySelector('.price-value').textContent = '₱' + parseFloat(itemData.original_price).toLocaleString('en-US', { minimumFractionDigits: 2 });
            if (rows[1]) rows[1].querySelector('.price-value').textContent = '₱' + parseFloat(itemData.asking_price).toLocaleString('en-US', { minimumFractionDigits: 2 });
            if (rows[2]) rows[2].querySelector('.seller-name').textContent = itemData.FullName;
        }
        
        // Update purchase offer with asking price
        const purchaseOffer = modal.querySelector('#purchaseOffer');
        if (purchaseOffer) {
            purchaseOffer.value = parseFloat(itemData.asking_price) || 0;
        }
        
        // Trigger calculations
        setTimeout(() => {
            const event = new Event('input', { bubbles: true });
            if (purchaseOffer) purchaseOffer.dispatchEvent(event);
        }, 100);
        
        // Show modal
        modal.style.display = 'flex';
    }
}

// Add approved item to marketplace listings
function addToListings(itemData) {
    const brand = itemData.brand;
    const model = itemData.model;
    const originalPrice = parseFloat(itemData.original_price);
    const sellingPrice = parseFloat(itemData.asking_price);
    const condition = itemData.condition;
    const megapixels = itemData.megapixels;
    const sensor = itemData.sensor;
    const inclusions = itemData.inclusions;
    const knownIssues = itemData.known_issues;
    
    // Store data in localStorage for the add listing modal
    localStorage.setItem('pendingItemData', JSON.stringify({
        brand: brand,
        model: model,
        original_price: originalPrice,
        selling_price: sellingPrice,
        condition: condition,
        megapixels: megapixels,
        sensor: sensor,
        inclusions: inclusions,
        known_issues: knownIssues
    }));
    
    // Switch to Overview tab
    switchToTab('overview');
    
    // Show the add listing modal (you'll need to adjust based on your modal ID)
    setTimeout(() => {
        const modal = document.getElementById('addListingModal') || document.getElementById('sellItemModal');
        if (modal) {
            modal.style.display = 'flex';
            // You could also populate the form with the stored data here
        } else {
            alert('Add listing modal not found. Please use the "Add New Listing" button to add this camera.');
        }
    }, 300);
}

// ===== TRANSACTION HISTORY FUNCTIONS =====

// Load and display transactions on page load
async function loadAdminTransactions() {
    try {
        const response = await fetch('../core/get_admin_transactions.php');
        const data = await response.json();
        
        if (data.status === 'success') {
            displayTransactions(data.transactions);
        } else {
            displayError('Failed to load transactions');
        }
    } catch (error) {
        console.error('Error loading transactions:', error);
        displayError('Error loading transactions');
    }
}

// Display transactions in the table
function displayTransactions(transactions) {
    const tableBody = document.getElementById('transactions-table-body');
    
    if (!tableBody) {
        console.error('Transactions table body not found');
        return;
    }
    
    if (transactions.length === 0) {
        tableBody.innerHTML = '<div style="padding: 20px; text-align: center; color: #666;">No transactions found.</div>';
        return;
    }
    
    let html = '';
    
    transactions.slice(0, 10).forEach(transaction => {
        const statusClass = transaction.status.toLowerCase().replace(/\s+/g, '-');
        const transactionDate = formatTransactionDate(transaction.date);
        
        html += `
            <div class="table-row">
                <div class="col">#${transaction.transaction_id}</div>
                <div class="col"><span class="type ${transaction.type.toLowerCase()}">${transaction.type}</span></div>
                <div class="col">${escapeHtml(transaction.camera_name)}</div>
                <div class="col price">₱${formatCurrency(transaction.amount)}</div>
                <div class="col">${transactionDate}</div>
                <div class="col"><span class="status ${statusClass}">${transaction.status}</span></div>
                <div class="col">
                    <button class="btn-action view-more" onclick="viewTransactionDetails('${escapeHtml(transaction.transaction_id)}')">View Details</button>
                </div>
            </div>
        `;
    });
    
    tableBody.innerHTML = html;
}

// View transaction details - redirects to receipt page
function viewTransactionDetails(transactionId) {
    // Extract order ID from transaction ID (e.g., "#TXN-0001" -> "1")
    const orderId = transactionId.replace('#TXN-', '').replace(/^0+/, '') || transactionId;
    window.location.href = `../receipt.php?order_id=${orderId}&source=admin`;
}

// Load all transactions - switch to Customer Orders tab
async function loadMoreTransactions() {
    try {
        // Switch to the Customer Orders tab
        switchToTab('customer-orders');
        
        // Scroll to top of the tab
        setTimeout(() => {
            const customerOrdersTab = document.getElementById('customer-orders');
            if (customerOrdersTab) {
                customerOrdersTab.scrollIntoView({ behavior: 'smooth' });
            }
        }, 300);
        
    } catch (error) {
        console.error('Error switching to Customer Orders:', error);
        alert('Error switching to Customer Orders tab');
    }
}

// Format currency
function formatCurrency(amount) {
    const num = parseFloat(amount);
    return num.toLocaleString('en-PH', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

// Format transaction date
function formatTransactionDate(dateString) {
    const date = new Date(dateString);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();
    return `${day} ${month} ${year}`;
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Display error message
function displayError(message) {
    const tableBody = document.getElementById('transactions-table-body');
    if (tableBody) {
        tableBody.innerHTML = `<div style="padding: 20px; text-align: center; color: #d32f2f;">${message}</div>`;
    }
}

// ===== ANALYTICS FUNCTIONS =====

// Load analytics when Analytics tab is clicked
document.addEventListener('click', function(e) {
    if (e.target.matches('[data-tab="analytics"]')) {
        setTimeout(loadAnalytics, 100);
    }
});

// Load and display analytics data
async function loadAnalytics() {
    try {
        const response = await fetch('../core/get_analytics.php');
        const data = await response.json();
        
        if (data.status === 'success') {
            displayAnalytics(data.analytics);
        } else {
            console.error('Failed to load analytics:', data.message);
        }
    } catch (error) {
        console.error('Error loading analytics:', error);
    }
}

// Display analytics data
function displayAnalytics(analytics) {
    // Update Monthly Revenue & Profit bars
    const monthlyData = analytics.monthly_revenue_profit || [];
    if (monthlyData.length > 0) {
        const maxRevenue = Math.max(...monthlyData.map(m => m.revenue || 0));
        const barsContainer = document.querySelector('.chart-bars');
        if (barsContainer) {
            barsContainer.innerHTML = monthlyData.map((data, idx) => {
                const percentage = maxRevenue > 0 ? (data.revenue / maxRevenue) * 100 : 10;
                const title = data.month ? `${data.month}: ₱${data.revenue.toLocaleString('en-PH', {minimumFractionDigits: 0})}` : 'No data';
                return `<div class="bar" style="height: ${Math.max(percentage, 10)}%" title="${title}"></div>`;
            }).join('');
        }
    }

    // Update Weekly Activity stats
    const weeklyActivity = analytics.weekly_activity || {};
    const viewsStat = document.querySelector('.activity-stats .stat-item:nth-child(1) .stat-value');
    const searchesStat = document.querySelector('.activity-stats .stat-item:nth-child(2) .stat-value');
    const ordersStat = document.querySelector('.activity-stats .stat-item:nth-child(3) .stat-value');
    
    if (viewsStat) viewsStat.textContent = (weeklyActivity.views || 0).toLocaleString();
    if (searchesStat) searchesStat.textContent = (weeklyActivity.searches || 0).toLocaleString();
    if (ordersStat) ordersStat.textContent = (weeklyActivity.orders || 0).toLocaleString();

    // Update Top Selling Cameras
    const topCameras = analytics.top_selling_cameras || [];
    const analyticsCards = document.querySelectorAll('.analytics-card');
    if (analyticsCards.length > 2) {
        const topList = analyticsCards[2].querySelector('.top-list');
        if (topList) {
            if (topCameras.length > 0) {
                topList.innerHTML = topCameras.map((camera, idx) => `
                    <div class="top-item">
                        <span class="rank">${idx + 1}</span>
                        <span class="name">${camera.name || 'N/A'}</span>
                        <span class="count">${camera.sold} sold</span>
                    </div>
                `).join('');
            } else {
                topList.innerHTML = '<div style="padding: 20px; text-align: center; color: #999;">No sales data yet</div>';
            }
        }
    }

    // Update Inventory by Brand
    const brandInventory = analytics.inventory_by_brand || [];
    const brandStats = document.querySelector('.brand-stats');
    if (brandStats) {
        if (brandInventory.length > 0) {
            brandStats.innerHTML = brandInventory.map(brand => `
                <div class="brand-item">
                    <span class="brand-name">${brand.brand || 'Other'}</span>
                    <div class="brand-bar">
                        <div class="brand-fill" style="width: ${brand.percentage}%"></div>
                    </div>
                    <span class="brand-count">${brand.percentage}%</span>
                </div>
            `).join('');
        } else {
            brandStats.innerHTML = '<div style="padding: 20px; text-align: center; color: #999;">No inventory data</div>';
        }
    }

    // Update Top Viewed Cameras
    const topViewed = analytics.top_viewed_cameras || [];
    if (analyticsCards.length > 4) {
        const topViewedList = analyticsCards[4].querySelector('.top-list');
        if (topViewedList) {
            if (topViewed.length > 0) {
                topViewedList.innerHTML = topViewed.map((camera, idx) => `
                    <div class="top-item">
                        <span class="rank">${idx + 1}</span>
                        <span class="name">${camera.name || 'N/A'}</span>
                        <span class="count">${camera.views} views</span>
                    </div>
                `).join('');
            } else {
                topViewedList.innerHTML = '<div style="padding: 20px; text-align: center; color: #999;">No listing data</div>';
            }
        }
    }
}
