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
                // Reset form when opening
                const form = document.getElementById('cameraForm');
                if (form) form.reset();
                const filePreview = document.getElementById('filePreview');
                if (filePreview) filePreview.innerHTML = '';
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
            
            // Load analytics data if analytics tab is clicked
            if (targetTab === 'analytics') {
                setTimeout(loadAnalytics, 100);
            }
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
        // Check if this is a transaction view details button (has onclick with viewTransactionDetails)
        if (e.target.getAttribute('onclick') && e.target.getAttribute('onclick').includes('viewTransactionDetails')) {
            // Let the onclick handler take care of it
            return;
        }
        
        const itemId = e.target.getAttribute('data-id');
        showItemDetails(itemId);
    }
});

function showItemDetails(itemId) {
    // In real implementation, this would show a modal or expand the row
    // Alert removed - let inline onclick handlers execute instead
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
    showConfirmationModal('Are you sure you want to approve this item?', () => {
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
                    Toast.success('Item approved successfully!');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    Toast.error('Error: ' + data.message);
                }
            } catch (e) {
                console.error('Failed to parse response:', text);
                Toast.error('Error: Invalid response from server. Check console for details.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Toast.error('Error approving item: ' + error.message);
        });
    });
}

// Reject item submission
function rejectItem(listingId) {
    showConfirmationModal('Are you sure you want to reject this item?', () => {
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
                    Toast.success('Item rejected successfully!');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    Toast.error('Error: ' + data.message);
                }
            } catch (e) {
                console.error('Failed to parse response:', text);
                Toast.error('Error: Invalid response from server. Check console for details.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Toast.error('Error rejecting item: ' + error.message);
        });
    });
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
    
    // Show only 3 latest transactions on overview page
    transactions.slice(0, 3).forEach(transaction => {
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

// Load all transactions - switch to transactions view
async function loadMoreTransactions() {
    try {
        // Load full transaction list
        const response = await fetch('../core/get_admin_transactions.php');
        const data = await response.json();
        
        if (data.status === 'success') {
            displayAllTransactions(data.transactions);
            // Switch to the Customer Orders tab
            switchToTab('customer-orders');
            
            // Scroll to top of the tab
            setTimeout(() => {
                const customerOrdersTab = document.getElementById('customer-orders');
                if (customerOrdersTab) {
                    customerOrdersTab.scrollIntoView({ behavior: 'smooth' });
                }
            }, 300);
        }
    } catch (error) {
        console.error('Error loading transactions:', error);
        alert('Error loading transactions');
    }
}

// Display all transactions (for View All)
function displayAllTransactions(transactions) {
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
    
    // Show all transactions
    transactions.forEach(transaction => {
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
        console.log('Loading analytics...');
        const response = await fetch('../core/get_analytics.php');
        console.log('Analytics response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('Analytics data:', data);
        
        if (data.status === 'success') {
            console.log('Displaying analytics...');
            displayAnalytics(data.analytics);
        } else {
            console.error('Failed to load analytics:', data.message);
            alert('Failed to load analytics: ' + data.message);
        }
    } catch (error) {
        console.error('Error loading analytics:', error);
        alert('Error loading analytics: ' + error.message);
    }
}

// Display analytics data
function displayAnalytics(analytics) {
    console.log('displayAnalytics called with:', analytics);
    
    // Update Monthly Revenue & Profit bars
    const monthlyData = analytics.monthly_revenue_profit || [];
    console.log('Monthly data:', monthlyData);
    
    if (monthlyData.length > 0) {
        const maxRevenue = Math.max(...monthlyData.map(m => m.revenue || 0));
        console.log('Max revenue:', maxRevenue);
        
        const chartDummy = document.querySelector('.chart-dummy');
        if (chartDummy) {
            // Create SVG line chart
            const padding = 40;
            const svgWidth = chartDummy.parentElement.offsetWidth - 80;
            const svgHeight = 200;
            const chartWidth = svgWidth - (padding * 2);
            const chartHeight = svgHeight - (padding * 2);
            
            // Calculate points
            const pointSpacing = chartWidth / (monthlyData.length - 1 || 1);
            const points = monthlyData.map((data, idx) => {
                const x = padding + (idx * pointSpacing);
                const yRatio = maxRevenue > 0 ? (data.revenue / maxRevenue) : 0;
                const y = padding + (chartHeight * (1 - yRatio));
                return { x, y, data };
            });
            
            // Build SVG
            let pathD = `M ${points[0].x} ${points[0].y}`;
            for (let i = 1; i < points.length; i++) {
                pathD += ` L ${points[i].x} ${points[i].y}`;
            }
            
            let svg = `
                <svg width="${svgWidth}" height="${svgHeight}" style="overflow: visible;">
                    <!-- Grid lines -->
                    <line x1="${padding}" y1="${padding}" x2="${padding}" y2="${padding + chartHeight}" stroke="#ccc" stroke-width="1"/>
                    <line x1="${padding}" y1="${padding + chartHeight}" x2="${padding + chartWidth}" y2="${padding + chartHeight}" stroke="#ccc" stroke-width="1"/>
                    
                    <!-- Gradient for area under curve (MONOCHROME) -->
                    <defs>
                        <linearGradient id="areaGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#333333;stop-opacity:0.3" />
                            <stop offset="100%" style="stop-color:#666666;stop-opacity:0" />
                        </linearGradient>
                    </defs>
                    
                    <!-- Area under curve -->
                    <path d="${pathD} L ${points[points.length - 1].x} ${padding + chartHeight} Z" fill="url(#areaGradient)" stroke="none"/>
                    
                    <!-- Line -->
                    <path d="${pathD}" fill="none" stroke="url(#lineGradient)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    
                    <!-- Define line gradient (MONOCHROME) -->
                    <defs>
                        <linearGradient id="lineGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:#333333" />
                            <stop offset="100%" style="stop-color:#666666" />
                        </linearGradient>
                    </defs>
                    
                    <!-- Data points -->
                    ${points.map((point, idx) => `
                        <circle cx="${point.x}" cy="${point.y}" r="5" fill="white" stroke="#333333" stroke-width="2" style="cursor: pointer;" data-index="${idx}"/>
                    `).join('')}
                    
                    <!-- Month labels -->
                    ${points.map((point, idx) => `
                        <text x="${point.x}" y="${padding + chartHeight + 25}" text-anchor="middle" font-size="12" fill="#666" font-weight="${monthlyData[idx].revenue > 0 ? 'bold' : 'normal'}">
                            ${monthlyData[idx].month || '—'}
                        </text>
                    `).join('')}
                </svg>
            `;
            
            chartDummy.innerHTML = svg;
            
            // Store tooltips in a map
            const tooltips = new Map();
            
            // Add interactivity
            const circles = chartDummy.querySelectorAll('circle');
            circles.forEach((circle, idx) => {
                circle.addEventListener('mouseenter', (e) => {
                    const data = monthlyData[idx];
                    
                    // Remove any existing tooltip first
                    if (tooltips.has(idx)) {
                        const oldTooltip = tooltips.get(idx);
                        if (oldTooltip && oldTooltip.parentNode) {
                            oldTooltip.parentNode.removeChild(oldTooltip);
                        }
                    }
                    
                    const tooltip = document.createElement('div');
                    tooltip.style.cssText = `
                        position: fixed;
                        background: rgba(0,0,0,0.9);
                        color: white;
                        padding: 8px 12px;
                        border-radius: 6px;
                        font-size: 12px;
                        white-space: nowrap;
                        pointer-events: none;
                        z-index: 10000;
                    `;
                    tooltip.textContent = `${data.month}: ₱${data.revenue.toLocaleString('en-PH', {minimumFractionDigits: 0})}`;
                    document.body.appendChild(tooltip);
                    
                    const rect = e.target.getBoundingClientRect();
                    tooltip.style.left = (rect.left - tooltip.offsetWidth / 2) + 'px';
                    tooltip.style.top = (rect.top - 35) + 'px';
                    
                    tooltips.set(idx, tooltip);
                    circle.style.r = '7';
                    circle.style.stroke = '#764ba2';
                });
                
                circle.addEventListener('mouseleave', (e) => {
                    const tooltip = tooltips.get(idx);
                    if (tooltip && tooltip.parentNode) {
                        tooltip.parentNode.removeChild(tooltip);
                        tooltips.delete(idx);
                    }
                    e.target.style.r = '5';
                    e.target.style.stroke = '#667eea';
                });
            });
            
            console.log('Line chart rendered with', monthlyData.length, 'months');
        }
    } else {
        console.warn('No monthly revenue data available');
    }

    // Update Monthly Orders & Items Sold
    const monthlyOrdersItems = analytics.monthly_orders_items || {};
    const orderStatusDist = analytics.order_status_distribution || {};
    const analyticsCards = document.querySelectorAll('.analytics-card');
    if (analyticsCards.length > 1) {
        const miniChart = analyticsCards[1].querySelector('.mini-chart');
        if (miniChart) {
            // Create pie chart for order status distribution
            const statuses = ['Pending', 'Processing', 'Shipped', 'Completed', 'Cancelled'];
            const counts = statuses.map(s => orderStatusDist[s] || 0);
            const total = counts.reduce((a, b) => a + b, 0);
            
            // Monochrome color mapping for each status (grayscale)
            const statusColors = {
                'Pending': '#CCCCCC',      // Light gray
                'Processing': '#999999',   // Medium gray
                'Shipped': '#666666',      // Dark gray
                'Completed': '#333333',    // Very dark gray
                'Cancelled': '#E8E8E8'     // Lighter gray
            };
            
            // Calculate pie chart paths
            let cumulativeAngle = -90; // Start from top
            const radius = 70;
            const centerX = 100;
            const centerY = 85;
            
            const paths = statuses.map((status, idx) => {
                const count = counts[idx];
                if (count === 0) return null;
                
                const sliceAngle = (count / total) * 360;
                const endAngle = cumulativeAngle + sliceAngle;
                
                const x1 = centerX + radius * Math.cos((cumulativeAngle * Math.PI) / 180);
                const y1 = centerY + radius * Math.sin((cumulativeAngle * Math.PI) / 180);
                const x2 = centerX + radius * Math.cos((endAngle * Math.PI) / 180);
                const y2 = centerY + radius * Math.sin((endAngle * Math.PI) / 180);
                
                const largeArc = sliceAngle > 180 ? 1 : 0;
                const pathData = `M ${centerX} ${centerY} L ${x1} ${y1} A ${radius} ${radius} 0 ${largeArc} 1 ${x2} ${y2} Z`;
                
                const result = {
                    path: pathData,
                    color: statusColors[status],
                    status: status,
                    count: count,
                    percentage: ((count / total) * 100).toFixed(1),
                    midAngle: cumulativeAngle + sliceAngle / 2
                };
                
                cumulativeAngle = endAngle;
                return result;
            }).filter(p => p !== null);
            
            // Build SVG and legend with hover tooltips
            let svg = `
                <div style="display: flex; flex-direction: column; gap: 0; align-items: center; position: relative; width: 100%; overflow: visible;">
                    <svg width="200" height="160" style="overflow: visible; cursor: pointer; flex-shrink: 0;">
                        <!-- Pie chart slices with hover effects -->
                        ${paths.map((p, idx) => `
                            <g class="pie-slice" data-status="${p.status}" style="cursor: pointer;">
                                <path 
                                    d="${p.path}" 
                                    fill="${p.color}" 
                                    stroke="white" 
                                    stroke-width="2"
                                    style="transition: opacity 0.2s ease;"
                                    onmouseover="
                                        this.style.opacity='0.7';
                                        this.style.filter='brightness(0.9)';
                                    "
                                    onmouseout="
                                        this.style.opacity='1';
                                        this.style.filter='brightness(1)';
                                    "
                                />
                            </g>
                        `).join('')}
                    </svg>
                    <div style="width: 100%; display: flex; flex-direction: column; gap: 4px; padding: 8px 10px; margin-top: 4px; max-height: 130px; overflow-y: auto; overflow-x: hidden;">
                        ${paths.map(p => `
                            <div 
                                class="status-legend-item"
                                data-status="${p.status}"
                                style="display: flex; align-items: center; gap: 8px; font-size: 12px; padding: 4px 6px; border-radius: 4px; transition: background-color 0.2s ease; cursor: pointer; flex-shrink: 0;"
                                onmouseover="this.style.backgroundColor='#f8f8f8';"
                                onmouseout="this.style.backgroundColor='transparent';"
                            >
                                <div style="width: 10px; height: 10px; background-color: ${p.color}; border-radius: 2px; flex-shrink: 0; border: 1px solid rgba(0,0,0,0.1);"></div>
                                <div style="flex: 1; display: flex; justify-content: space-between; align-items: center; gap: 8px; min-width: 0;">
                                    <span style="font-weight: 600; color: #222; white-space: nowrap;">${p.status}</span>
                                    <span style="color: #666; font-size: 11px; font-weight: 500; white-space: nowrap;">${p.count} (${p.percentage}%)</span>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
            
            miniChart.innerHTML = svg;
            
            // Add hover tooltips to pie slices
            const tooltips = new Map();
            const pieSlices = miniChart.querySelectorAll('.pie-slice path');
            pieSlices.forEach((slice, idx) => {
                const path = paths[idx];
                slice.addEventListener('mouseenter', (e) => {
                    // Remove old tooltip if exists
                    if (tooltips.has(idx)) {
                        const oldTooltip = tooltips.get(idx);
                        if (oldTooltip && oldTooltip.parentNode) {
                            oldTooltip.parentNode.removeChild(oldTooltip);
                        }
                    }
                    
                    const tooltip = document.createElement('div');
                    tooltip.style.cssText = `
                        position: fixed;
                        background: rgba(0,0,0,0.9);
                        color: white;
                        padding: 8px 12px;
                        border-radius: 6px;
                        font-size: 12px;
                        white-space: nowrap;
                        pointer-events: none;
                        z-index: 10000;
                    `;
                    tooltip.textContent = `${path.status}: ${path.count} (${path.percentage}%)`;
                    document.body.appendChild(tooltip);
                    
                    const rect = e.target.getBoundingClientRect();
                    tooltip.style.left = (rect.left - tooltip.offsetWidth / 2) + 'px';
                    tooltip.style.top = (rect.top - 35) + 'px';
                    
                    tooltips.set(idx, tooltip);
                });
                
                slice.addEventListener('mouseleave', (e) => {
                    const tooltip = tooltips.get(idx);
                    if (tooltip && tooltip.parentNode) {
                        tooltip.parentNode.removeChild(tooltip);
                        tooltips.delete(idx);
                    }
                });
            });
        }
    }

    // Update Weekly Activity stats
    const weeklyActivity = analytics.weekly_activity || {};
    const viewsStat = document.querySelector('.activity-stats .stat-item:nth-child(1) .stat-value');
    const searchesStat = document.querySelector('.activity-stats .stat-item:nth-child(2) .stat-value');
    const ordersStat = document.querySelector('.activity-stats .stat-item:nth-child(3) .stat-value');
    
    const itemsSold = weeklyActivity.items_sold || 0;
    const completedOrders = weeklyActivity.completed_orders || 0;
    const avgItemsPerOrder = completedOrders > 0 ? (itemsSold / completedOrders).toFixed(1) : 0;
    
    if (viewsStat) viewsStat.textContent = itemsSold.toLocaleString();
    if (searchesStat) searchesStat.textContent = completedOrders.toLocaleString();
    if (ordersStat) ordersStat.textContent = avgItemsPerOrder;

    // Update Top Selling Cameras
    const topCameras = analytics.top_selling_cameras || [];
    console.log('Top Selling Cameras data:', topCameras);
    console.log('Analytics Cards count:', analyticsCards.length);
    if (analyticsCards.length > 3) {
        const topList = analyticsCards[3].querySelector('.top-list');
        console.log('Top List element:', topList);
        if (topList) {
            if (topCameras.length > 0) {
                const html = topCameras.map((camera, idx) => `
                    <div class="top-item">
                        <span class="rank">${idx + 1}</span>
                        <span class="name">${camera.name || 'N/A'}</span>
                        <span class="count">${camera.sold} sold</span>
                    </div>
                `).join('');
                console.log('Updating topList with HTML:', html);
                topList.innerHTML = html;
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
    if (analyticsCards.length > 5) {
        const topViewedList = analyticsCards[5].querySelector('.top-list');
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

    // Update Top Search Terms
    const searchTerms = analytics.top_search_terms || [];
    const searchTermsContainer = document.querySelector('.search-terms');
    if (searchTermsContainer) {
        if (searchTerms.length > 0) {
            searchTermsContainer.innerHTML = searchTerms.map(term => `
                <span class="search-tag">${term}</span>
            `).join('');
        } else {
            searchTermsContainer.innerHTML = '<div style="padding: 20px; text-align: center; color: #999; width: 100%;">No search data yet</div>';
        }
    }

    // Update Payment Method Distribution Donut Chart
    const paymentMethods = analytics.payment_methods || [];
    const paymentMethodChart = document.getElementById('payment-method-chart');
    if (paymentMethodChart) {
        if (paymentMethods.length > 0) {
            const total = paymentMethods.reduce((sum, pm) => sum + pm.count, 0);
            const chartSize = 180;
            const center = chartSize / 2;
            const radius = 60;
            const donutWidth = 20;
            
            // Define colors for payment methods (MONOCHROME - GRAYSCALE)
            const methodColors = {
                'COD': '#333333',
                'PayMaya': '#666666',
                'GCash': '#999999',
                'Maribank': '#CCCCCC',
                'Other': '#E8E8E8'
            };
            
            let sliceStart = 0;
            let slices = [];
            let legendItems = [];
            
            paymentMethods.forEach((pm, idx) => {
                const sliceAngle = (pm.count / total) * (Math.PI * 2);
                const sliceEnd = sliceStart + sliceAngle;
                
                // Calculate path for donut slice
                const x1 = center + radius * Math.cos(sliceStart);
                const y1 = center + radius * Math.sin(sliceStart);
                const x2 = center + radius * Math.cos(sliceEnd);
                const y2 = center + radius * Math.sin(sliceEnd);
                
                const innerRadius = radius - donutWidth;
                const x3 = center + innerRadius * Math.cos(sliceEnd);
                const y3 = center + innerRadius * Math.sin(sliceEnd);
                const x4 = center + innerRadius * Math.cos(sliceStart);
                const y4 = center + innerRadius * Math.sin(sliceStart);
                
                const largeArc = sliceAngle > Math.PI ? 1 : 0;
                const largeArcInner = sliceAngle > Math.PI ? 1 : 0;
                
                const path = `
                    M ${x1} ${y1}
                    A ${radius} ${radius} 0 ${largeArc} 1 ${x2} ${y2}
                    L ${x3} ${y3}
                    A ${innerRadius} ${innerRadius} 0 ${largeArcInner} 0 ${x4} ${y4}
                    Z
                `;
                
                const color = methodColors[pm.method] || '#999999';
                const percentage = ((pm.count / total) * 100).toFixed(0);
                
                slices.push({
                    path,
                    color,
                    method: pm.method,
                    count: pm.count,
                    percentage,
                    midAngle: sliceStart + (sliceAngle / 2)
                });
                
                legendItems.push({
                    color,
                    method: pm.method,
                    count: pm.count,
                    percentage
                });
                
                sliceStart = sliceEnd;
            });
            
            // Build SVG - centered with proper dimensions
            let svg = `
                <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                    <svg width="${chartSize}" height="${chartSize}" style="overflow: visible;">
                        <defs>
                            <style>
                                .donut-slice { cursor: pointer; transition: opacity 0.2s; }
                                .donut-slice:hover { opacity: 0.8; }
                            </style>
                        </defs>
                `;
            
            // Add slices
            slices.forEach((slice, idx) => {
                svg += `<path d="${slice.path}" fill="${slice.color}" class="donut-slice" data-index="${idx}" style="cursor: pointer;"/>`;
            });
            
            svg += `
                    </svg>
            `;
            
            // Add legend below chart with centered alignment
            let legend = '<div class="chart-legend" style="margin-top: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 8px 12px; font-size: 11px; width: 100%; justify-items: center;">';
            legendItems.forEach(item => {
                legend += `
                    <div class="legend-item" style="display: flex; align-items: center; gap: 6px;">
                        <div style="width: 10px; height: 10px; background-color: ${item.color}; border-radius: 2px; flex-shrink: 0;"></div>
                        <span style="color: #333;">${item.method}: ${item.count}</span>
                    </div>
                `;
            });
            legend += '</div>';
            
            svg += legend + '</div>';
            
            paymentMethodChart.innerHTML = svg;
            
            // Add hover tooltips to slices
            const paymentTooltips = new Map();
            const sliceElements = paymentMethodChart.querySelectorAll('.donut-slice');
            sliceElements.forEach((slice, idx) => {
                slice.addEventListener('mouseenter', (e) => {
                    const data = slices[idx];
                    
                    if (paymentTooltips.has(idx)) {
                        const oldTooltip = paymentTooltips.get(idx);
                        if (oldTooltip && oldTooltip.parentNode) {
                            oldTooltip.parentNode.removeChild(oldTooltip);
                        }
                    }
                    
                    const tooltip = document.createElement('div');
                    tooltip.style.cssText = `
                        position: fixed;
                        background: rgba(0,0,0,0.9);
                        color: white;
                        padding: 8px 12px;
                        border-radius: 6px;
                        font-size: 12px;
                        white-space: nowrap;
                        pointer-events: none;
                        z-index: 10000;
                    `;
                    tooltip.textContent = `${data.method}: ${data.count} orders (${data.percentage}%)`;
                    document.body.appendChild(tooltip);
                    
                    const rect = e.target.getBoundingClientRect();
                    tooltip.style.left = (rect.left - tooltip.offsetWidth / 2) + 'px';
                    tooltip.style.top = (rect.top - 35) + 'px';
                    
                    paymentTooltips.set(idx, tooltip);
                });
                
                slice.addEventListener('mouseleave', (e) => {
                    const tooltip = paymentTooltips.get(idx);
                    if (tooltip && tooltip.parentNode) {
                        tooltip.parentNode.removeChild(tooltip);
                        paymentTooltips.delete(idx);
                    }
                });
            });
        } else {
            paymentMethodChart.innerHTML = '<div style="padding: 40px 0; text-align: center; color: #999;">No payment data available</div>';
        }
    }

    // Update Monthly Items Sold Line Chart
    const monthlyItems = analytics.monthly_items_sold || [];
    const monthlyItemsChart = document.getElementById('monthly-items-chart');
    if (monthlyItemsChart) {
        if (monthlyItems.length > 0) {
            const maxItems = Math.max(...monthlyItems.map(m => m.items || 0));
            const padding = 10;
            const topPadding = 140;
            const svgWidth = monthlyItemsChart.parentElement.offsetWidth - 80;
            const svgHeight = 310;
            const chartWidth = svgWidth - (padding * 2);
            const chartHeight = svgHeight - topPadding - (padding * 2);
            
            // Calculate points for line chart
            const pointSpacing = chartWidth / (monthlyItems.length - 1 || 1);
            const points = monthlyItems.map((data, idx) => {
                const x = padding + (idx * pointSpacing);
                const yRatio = maxItems > 0 ? (data.items / maxItems) : 0;
                const y = topPadding + (chartHeight * (1 - yRatio));
                return { x, y, data };
            });
            
            // Build SVG line chart
            let pathD = `M ${points[0].x} ${points[0].y}`;
            for (let i = 1; i < points.length; i++) {
                pathD += ` L ${points[i].x} ${points[i].y}`;
            }
            
            let svg = `
                <div style="margin-top: 30px;">
                <svg width="${svgWidth}" height="${svgHeight}" style="overflow: visible;">
                    <!-- Grid lines -->
                    <line x1="${padding}" y1="${topPadding}" x2="${padding}" y2="${topPadding + chartHeight}" stroke="#ccc" stroke-width="1"/>
                    <line x1="${padding}" y1="${topPadding + chartHeight}" x2="${padding + chartWidth}" y2="${topPadding + chartHeight}" stroke="#ccc" stroke-width="1"/>
                    
                    <!-- Gradient for area under curve (MONOCHROME) -->
                    <defs>
                        <linearGradient id="itemsAreaGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#333333;stop-opacity:0.3" />
                            <stop offset="100%" style="stop-color:#666666;stop-opacity:0" />
                        </linearGradient>
                        <linearGradient id="itemsLineGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:#333333" />
                            <stop offset="100%" style="stop-color:#666666" />
                        </linearGradient>
                    </defs>
                    
                    <!-- Area under curve -->
                    <path d="${pathD} L ${points[points.length - 1].x} ${topPadding + chartHeight} Z" fill="url(#itemsAreaGradient)" stroke="none"/>
                    
                    <!-- Line -->
                    <path d="${pathD}" fill="none" stroke="url(#itemsLineGradient)" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    
                    <!-- Data points -->
                    ${points.map((point, idx) => `
                        <circle cx="${point.x}" cy="${point.y}" r="5" fill="white" stroke="#333333" stroke-width="2" style="cursor: pointer;" data-index="${idx}"/>
                    `).join('')}
                    
                    <!-- Month labels -->
                    ${points.map((point, idx) => `
                        <text x="${point.x}" y="${topPadding + chartHeight + 25}" text-anchor="middle" font-size="12" fill="#666" font-weight="${monthlyItems[idx].items > 0 ? 'bold' : 'normal'}">
                            ${monthlyItems[idx].short_month || '—'}
                        </text>
                    `).join('')}
                </svg>
                </div>
            `;
            
            monthlyItemsChart.innerHTML = svg;
            
            // Add hover tooltips
            const itemsTooltips = new Map();
            const itemsCircles = monthlyItemsChart.querySelectorAll('circle');
            itemsCircles.forEach((circle, idx) => {
                circle.addEventListener('mouseenter', (e) => {
                    const data = monthlyItems[idx];
                    
                    if (itemsTooltips.has(idx)) {
                        const oldTooltip = itemsTooltips.get(idx);
                        if (oldTooltip && oldTooltip.parentNode) {
                            oldTooltip.parentNode.removeChild(oldTooltip);
                        }
                    }
                    
                    const tooltip = document.createElement('div');
                    tooltip.style.cssText = `
                        position: fixed;
                        background: rgba(0,0,0,0.9);
                        color: white;
                        padding: 8px 12px;
                        border-radius: 6px;
                        font-size: 12px;
                        white-space: nowrap;
                        pointer-events: none;
                        z-index: 10000;
                    `;
                    tooltip.textContent = `${data.month}: ${data.items} items`;
                    document.body.appendChild(tooltip);
                    
                    const rect = e.target.getBoundingClientRect();
                    tooltip.style.left = (rect.left - tooltip.offsetWidth / 2) + 'px';
                    tooltip.style.top = (rect.top - 35) + 'px';
                    
                    itemsTooltips.set(idx, tooltip);
                    circle.style.r = '7';
                    circle.style.stroke = '#764ba2';
                });
                
                circle.addEventListener('mouseleave', (e) => {
                    const tooltip = itemsTooltips.get(idx);
                    if (tooltip && tooltip.parentNode) {
                        tooltip.parentNode.removeChild(tooltip);
                        itemsTooltips.delete(idx);
                    }
                    e.target.style.r = '5';
                    e.target.style.stroke = '#667eea';
                });
            });
        } else {
            monthlyItemsChart.innerHTML = '<div style="padding: 40px 0; text-align: center; color: #999;">No sales data available</div>';
        }
    }
}

// Custom confirmation modal function
function showConfirmationModal(message, onConfirm, onCancel = null) {
    // Create modal overlay
    const overlay = document.createElement('div');
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    `;

    // Create modal content
    const modal = document.createElement('div');
    modal.style.cssText = `
        background: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 400px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3s ease-out;
    `;

    modal.innerHTML = `
        <h2 style="margin: 0 0 15px 0; color: #333; font-size: 20px;">Confirm Action</h2>
        <p style="margin: 0 0 30px 0; color: #666; font-size: 16px;">${message}</p>
        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <button class="confirm-cancel-btn" style="
                padding: 10px 20px;
                border: 1px solid #ddd;
                background: #f0f0f0;
                color: #333;
                border-radius: 6px;
                cursor: pointer;
                font-weight: 500;
                transition: all 0.2s;
            ">Cancel</button>
            <button class="confirm-action-btn" style="
                padding: 10px 20px;
                border: none;
                background: #dc3545;
                color: white;
                border-radius: 6px;
                cursor: pointer;
                font-weight: 500;
                transition: all 0.2s;
            ">Confirm</button>
        </div>
    `;

    overlay.appendChild(modal);
    document.body.appendChild(overlay);

    // Add animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);

    // Handle button clicks
    const confirmBtn = modal.querySelector('.confirm-action-btn');
    const cancelBtn = modal.querySelector('.confirm-cancel-btn');

    const closeModal = () => {
        overlay.style.animation = 'slideOut 0.2s ease-out forwards';
        setTimeout(() => {
            overlay.remove();
        }, 200);
    };

    confirmBtn.addEventListener('click', () => {
        closeModal();
        if (onConfirm) onConfirm();
    });

    confirmBtn.addEventListener('mouseover', () => {
        confirmBtn.style.background = '#c82333';
    });

    confirmBtn.addEventListener('mouseout', () => {
        confirmBtn.style.background = '#dc3545';
    });

    cancelBtn.addEventListener('click', () => {
        closeModal();
        if (onCancel) onCancel();
    });

    cancelBtn.addEventListener('mouseover', () => {
        cancelBtn.style.background = '#e0e0e0';
    });

    cancelBtn.addEventListener('mouseout', () => {
        cancelBtn.style.background = '#f0f0f0';
    });

    // Close on overlay click
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            closeModal();
            if (onCancel) onCancel();
        }
    });
}
