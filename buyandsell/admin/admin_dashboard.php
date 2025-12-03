<?php 
session_start();
include '../includes/header_dashboard_admin.php';
include '../core/db_connect.php';

// Fetch all listings from database
$listings = [];
$limit = 3; // Show only last 3
try {
    $sql = "SELECT 
        l.listing_id,
        l.brand,
        l.model,
        l.selling_price,
        l.original_price,
        l.created_at,
        (SELECT image_path FROM listing_images WHERE listing_id = l.listing_id LIMIT 1) as image_path,
        DATEDIFF(NOW(), l.created_at) as days_listed
    FROM listings l
    ORDER BY l.created_at DESC
    LIMIT ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $listings[] = $row;
        }
    }
    $stmt->close();
} catch (Exception $e) {
    error_log("Error fetching listings: " . $e->getMessage());
}
?>

<div class="admin-dashboard-wrapper">
    <div class="admin-dashboard-container">
        
        <!-- Page Header -->
        <div class="admin-header">
            <h1 class="admin-title">Admin Dashboard</h1>
            <p class="admin-subtitle">Manage your camera marketplace operations</p>
        </div>

        <!-- Navigation Tabs -->
        <nav class="admin-nav-tabs">
            <button class="nav-tab active" data-tab="overview">Overview</button>
            <button class="nav-tab" data-tab="camera-purchases">Camera Purchases</button>
            <button class="nav-tab" data-tab="customer-orders">Customer Orders</button>
            <button class="nav-tab" data-tab="analytics">Analytics</button>
        </nav>

        <!-- Tab Content -->
        <div class="tab-content">
            
            <!-- OVERVIEW TAB -->
            <div id="overview" class="tab-pane active">
                
                <!-- KPI Cards - 4 in a row -->
                <div class="kpi-grid">
                    <div class="kpi-card">
                        <div class="kpi-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="kpi-content">
                            <h3 class="kpi-value">12</h3>
                            <p class="kpi-label">Pending Review</p>
                            <div class="kpi-trend positive">+2 from yesterday</div>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="kpi-content">
                            <h3 class="kpi-value">8</h3>
                            <p class="kpi-label">Pending Orders</p>
                            <div class="kpi-trend negative">-1 from yesterday</div>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="kpi-content">
                            <h3 class="kpi-value">₱284,500</h3>
                            <p class="kpi-label">Total Revenue</p>
                            <div class="kpi-trend positive">+12.5%</div>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="kpi-content">
                            <h3 class="kpi-value">₱89,200</h3>
                            <p class="kpi-label">Total Profit</p>
                            <div class="kpi-trend positive">+8.3%</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & Top Requested - 2 cards side by side -->
                <div class="cards-grid">
                    <!-- Quick Actions Card -->
                    <div class="action-card">
                        <div class="card-header">
                            <h3 class="card-title">Quick Actions</h3>
                            <p class="card-subtitle">Manage your inventory</p>
                        </div>
                        <div class="action-buttons">
                            <button class="action-btn primary" id="openListingModal">
                                <i class="fas fa-plus"></i>
                                <span>Add New Listing</span>
                            </button>
                            <button class="action-btn secondary">
                                <i class="fas fa-eye"></i>
                                <span>Review Pending Items</span>
                            </button>
                            <button class="action-btn tertiary">
                                <i class="fas fa-truck"></i>
                                <span>Process Orders</span>
                            </button>
                        </div>
                    </div>

                    <!-- Top Requested Cameras Card -->
                    <div class="requested-card">
                        <div class="card-header">
                            <h3 class="card-title">Top Requested Cameras</h3>
                            <p class="card-subtitle">Priority to source</p>
                        </div>
                        <div class="requested-list">
                            <div class="requested-item">
                                <div class="camera-info">
                                    <h4>Sony A7 IV</h4>
                                    <p>15 customer requests</p>
                                </div>
                                <span class="priority high">High</span>
                            </div>
                            <div class="requested-item">
                                <div class="camera-info">
                                    <h4>Canon R5</h4>
                                    <p>12 customer requests</p>
                                </div>
                                <span class="priority high">High</span>
                            </div>
                            <div class="requested-item">
                                <div class="camera-info">
                                    <h4>Fujifilm X-T5</h4>
                                    <p>8 customer requests</p>
                                </div>
                                <span class="priority medium">Medium</span>
                            </div>
                            <div class="requested-item">
                                <div class="camera-info">
                                    <h4>Nikon Z6 II</h4>
                                    <p>6 customer requests</p>
                                </div>
                                <span class="priority medium">Medium</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Summary -->
                <div class="inventory-section">
                    <div class="section-header">
                        <h3 class="section-title">Inventory Summary</h3>
                        <button class="btn-view-all" onclick="window.location.href='admin_products.php'">View All Inventory</button>
                    </div>
                    <div class="inventory-table">
                        <div class="table-header">
                            <div class="col">Camera</div>
                            <div class="col">Status</div>
                            <div class="col">Days Listed</div>
                            <div class="col">Price</div>
                            <div class="col">Original</div>
                            <div class="col">Actions</div>
                        </div>
                        <div class="table-body">
                            <?php if (!empty($listings)): ?>
                                <?php foreach ($listings as $item): ?>
                                    <div class="table-row">
                                        <div class="col camera-info">
                                            <img src="<?php echo $item['image_path'] ? (strpos($item['image_path'], 'uploads/') === 0 ? '../' . $item['image_path'] : $item['image_path']) : '../assets/images/empty.png'; ?>" alt="<?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?>" class="camera-thumb" onerror="this.src='../assets/images/empty.png'">
                                            <div>
                                                <h4><?php echo htmlspecialchars($item['brand']); ?> <?php echo htmlspecialchars($item['model']); ?></h4>
                                                <p>Listed: <?php echo date('M d, Y', strtotime($item['created_at'])); ?></p>
                                            </div>
                                        </div>
                                        <div class="col"><span class="status in-stock">Listed</span></div>
                                        <div class="col"><?php echo (int)$item['days_listed']; ?> day<?php echo $item['days_listed'] !== '1' ? 's' : ''; ?></div>
                                        <div class="col price">₱<?php echo number_format((float)$item['selling_price'], 2); ?></div>
                                        <div class="col">₱<?php echo number_format((float)$item['original_price'], 2); ?></div>
                                        <div class="col">
                                            <button class="btn-action view-more" data-id="<?php echo $item['listing_id']; ?>" onclick="editListing(<?php echo $item['listing_id']; ?>)">Edit</button>
                                            <button class="btn-action btn-delete" data-id="<?php echo $item['listing_id']; ?>" onclick="deleteListing(<?php echo $item['listing_id']; ?>, '<?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?>')">Remove</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="table-row">
                                    <div class="col" style="grid-column: 1/-1; text-align: center; padding: 30px; color: #999;">
                                        <p>No listings yet. Add a new listing to get started.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="transaction-section">
                    <div class="section-header">
                        <h3 class="section-title">Transaction History</h3>
                        <button class="btn-view-all">View All Transactions</button>
                    </div>
                    <div class="transaction-table">
                        <div class="table-header">
                            <div class="col">Transaction ID</div>
                            <div class="col">Type</div>
                            <div class="col">Camera</div>
                            <div class="col">Amount</div>
                            <div class="col">Date</div>
                            <div class="col">Status</div>
                            <div class="col">Actions</div>
                        </div>
                        <div class="table-body">
                            <!-- Transaction 1 -->
                            <div class="table-row">
                                <div class="col">#TXN-001</div>
                                <div class="col"><span class="type sold">Sold</span></div>
                                <div class="col">Sony A7 III</div>
                                <div class="col price">₱45,000</div>
                                <div class="col">2024-01-15</div>
                                <div class="col"><span class="status completed">Completed</span></div>
                                <div class="col">
                                    <button class="btn-action view-more" data-id="txn1">View Details</button>
                                </div>
                            </div>
                            <!-- Transaction 2 -->
                            <div class="table-row">
                                <div class="col">#TXN-002</div>
                                <div class="col"><span class="type purchased">Purchased</span></div>
                                <div class="col">Canon R5</div>
                                <div class="col price">₱85,000</div>
                                <div class="col">2024-01-14</div>
                                <div class="col"><span class="status completed">Completed</span></div>
                                <div class="col">
                                    <button class="btn-action view-more" data-id="txn2">View Details</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CAMERA PURCHASES TAB -->
            <div id="camera-purchases" class="tab-pane">
                <div class="purchases-card">
                    <div class="card-header">
                        <h3 class="card-title">Camera Purchases from Sellers</h3>
                    </div>
                    <div class="purchases-tabs">
                        <button class="purchase-tab active" data-purchase-tab="pending">Pending</button>
                        <button class="purchase-tab" data-purchase-tab="purchased">Purchased</button>
                        <button class="purchase-tab" data-purchase-tab="listed">Listed</button>
                    </div>
                    
                    <!-- Pending Purchases Content -->
                    <div class="purchase-content active" data-purchase-content="pending">
                        <!-- Pending Item 1 -->
                        <div class="pending-item">
                            <div class="item-header">
                                <h4>Fujifilm X-T4</h4>
                                <span class="condition excellent">Excellent</span>
                            </div>
                            <div class="item-details">
                                <p class="specs">26MP APS-C, IBIS, excellent condition with box</p>
                                <div class="prices">
                                    <span class="original">Original: ₱85,000</span>
                                    <span class="asking">Asking: ₱58,000</span>
                                </div>
                                <div class="seller-info">
                                    <strong>Seller:</strong> John Doe
                                </div>
                            </div>
                            <button class="btn-review-offer" data-item="1">Review & Make Offer</button>
                        </div>
                        
                        <!-- Pending Item 2 -->
                        <div class="pending-item">
                            <div class="item-header">
                                <h4>Canon EOS R6</h4>
                                <span class="condition good">Good</span>
                            </div>
                            <div class="item-details">
                                <p class="specs">20MP Full Frame, like new with accessories</p>
                                <div class="prices">
                                    <span class="original">Original: ₱120,000</span>
                                    <span class="asking">Asking: ₱75,000</span>
                                </div>
                                <div class="seller-info">
                                    <strong>Seller:</strong> Jane Smith
                                </div>
                            </div>
                            <button class="btn-review-offer" data-item="2">Review & Make Offer</button>
                        </div>
                    </div>
                    
                    <!-- Purchased Content -->
                    <div class="purchase-content" data-purchase-content="purchased">
                        <div class="empty-state">
                            <p>No purchased items yet</p>
                        </div>
                    </div>
                    
                    <!-- Listed Content -->
                    <div class="purchase-content" data-purchase-content="listed">
                        <div class="empty-state">
                            <p>No listed items from purchases yet</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CUSTOMER ORDERS TAB -->
            <div id="customer-orders" class="tab-pane">
                <div class="orders-card">
                    <div class="card-header">
                        <h3 class="card-title">Customer Orders & Shipping</h3>
                        <p class="card-subtitle">Manage orders and shipping status</p>
                    </div>
                    <div class="orders-table">
                        <div class="table-header">
                            <div class="col">Order ID</div>
                            <div class="col">Customer</div>
                            <div class="col">Camera</div>
                            <div class="col">Amount</div>
                            <div class="col">Order Date</div>
                            <div class="col">Status</div>
                            <div class="col">Actions</div>
                        </div>
                        <div class="table-body">
                            <!-- Order 1 -->
                            <div class="table-row">
                                <div class="col">#ORD-001</div>
                                <div class="col">Michael Brown</div>
                                <div class="col">Sony A7 III</div>
                                <div class="col price">₱45,000</div>
                                <div class="col">2024-01-15</div>
                                <div class="col"><span class="status pending">Pending</span></div>
                                <div class="col">
                                    <div class="order-actions">
                                        <button class="btn-update" data-order="1" data-action="ship">Mark as Shipped</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Order 2 -->
                            <div class="table-row">
                                <div class="col">#ORD-002</div>
                                <div class="col">Sarah Johnson</div>
                                <div class="col">Canon R5</div>
                                <div class="col price">₱120,000</div>
                                <div class="col">2024-01-14</div>
                                <div class="col"><span class="status shipped">Shipped</span></div>
                                <div class="col">
                                    <div class="order-actions">
                                        <button class="btn-update" data-order="2" data-action="deliver">Mark as Delivered</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ANALYTICS TAB -->
            <div id="analytics" class="tab-pane">
                <div class="analytics-header">
                    <h2>Business Performance</h2>
                </div>
                
                <!-- Analytics Cards Grid -->
                <div class="analytics-grid">
                    <!-- Monthly Revenue & Profit -->
                    <div class="analytics-card large">
                        <div class="card-header">
                            <h3>Monthly Revenue & Profit</h3>
                            <p>Last 6 months performance</p>
                        </div>
                        <div class="chart-placeholder">
                            <div class="chart-dummy">
                                <div class="chart-bars">
                                    <div class="bar" style="height: 60%"></div>
                                    <div class="bar" style="height: 75%"></div>
                                    <div class="bar" style="height: 85%"></div>
                                    <div class="bar" style="height: 70%"></div>
                                    <div class="bar" style="height: 90%"></div>
                                    <div class="bar" style="height: 95%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Orders & Items Sold -->
                    <div class="analytics-card">
                        <div class="card-header">
                            <h3>Monthly Orders & Items Sold</h3>
                            <p>Sales volume trends</p>
                        </div>
                        <div class="chart-placeholder">
                            <div class="mini-chart">
                                <!-- Mini chart visualization -->
                            </div>
                        </div>
                    </div>

                    <!-- Weekly Activity -->
                    <div class="analytics-card">
                        <div class="card-header">
                            <h3>Weekly Activity</h3>
                            <p>Views, searches, and orders by day</p>
                        </div>
                        <div class="activity-stats">
                            <div class="stat-item">
                                <span class="stat-value">1,245</span>
                                <span class="stat-label">Views</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">356</span>
                                <span class="stat-label">Searches</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">28</span>
                                <span class="stat-label">Orders</span>
                            </div>
                        </div>
                    </div>

                    <!-- Top Selling Cameras -->
                    <div class="analytics-card">
                        <div class="card-header">
                            <h3>Top Selling Cameras</h3>
                        </div>
                        <div class="top-list">
                            <div class="top-item">
                                <span class="rank">1</span>
                                <span class="name">Sony A7 III</span>
                                <span class="count">15 sold</span>
                            </div>
                            <div class="top-item">
                                <span class="rank">2</span>
                                <span class="name">Canon R5</span>
                                <span class="count">12 sold</span>
                            </div>
                            <div class="top-item">
                                <span class="rank">3</span>
                                <span class="name">Fujifilm X-T4</span>
                                <span class="count">8 sold</span>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory by Brand -->
                    <div class="analytics-card">
                        <div class="card-header">
                            <h3>Inventory by Brand</h3>
                        </div>
                        <div class="brand-stats">
                            <div class="brand-item">
                                <span class="brand-name">Sony</span>
                                <div class="brand-bar">
                                    <div class="brand-fill" style="width: 40%"></div>
                                </div>
                                <span class="brand-count">40%</span>
                            </div>
                            <div class="brand-item">
                                <span class="brand-name">Canon</span>
                                <div class="brand-bar">
                                    <div class="brand-fill" style="width: 30%"></div>
                                </div>
                                <span class="brand-count">30%</span>
                            </div>
                            <div class="brand-item">
                                <span class="brand-name">Nikon</span>
                                <div class="brand-bar">
                                    <div class="brand-fill" style="width: 20%"></div>
                                </div>
                                <span class="brand-count">20%</span>
                            </div>
                            <div class="brand-item">
                                <span class="brand-name">Fujifilm</span>
                                <div class="brand-bar">
                                    <div class="brand-fill" style="width: 10%"></div>
                                </div>
                                <span class="brand-count">10%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Top Viewed Cameras -->
                    <div class="analytics-card">
                        <div class="card-header">
                            <h3>Top Viewed Cameras</h3>
                        </div>
                        <div class="top-list">
                            <div class="top-item">
                                <span class="rank">1</span>
                                <span class="name">Sony A7 IV</span>
                                <span class="count">2,456 views</span>
                            </div>
                            <div class="top-item">
                                <span class="rank">2</span>
                                <span class="name">Canon R6 Mark II</span>
                                <span class="count">1,890 views</span>
                            </div>
                            <div class="top-item">
                                <span class="rank">3</span>
                                <span class="name">Nikon Z8</span>
                                <span class="count">1,567 views</span>
                            </div>
                        </div>
                    </div>

                    <!-- Top Search Terms -->
                    <div class="analytics-card">
                        <div class="card-header">
                            <h3>Top Search Terms</h3>
                        </div>
                        <div class="search-terms">
                            <span class="search-tag">mirrorless camera</span>
                            <span class="search-tag">full frame</span>
                            <span class="search-tag">sony a7</span>
                            <span class="search-tag">used camera</span>
                            <span class="search-tag">canon r5</span>
                            <span class="search-tag">vlogging camera</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Review & Make Offer Modal -->
<div id="reviewOfferModal" class="modal">
    <div class="modal-content large">
        <span class="close">&times;</span>
        <h2>Review: <span id="modalCameraName">Fujifilm X-T4</span></h2>
        <p class="modal-subtitle">Set purchase offer and markup</p>
        
        <div class="offer-form">
            <div class="price-info">
                <div class="price-row">
                    <label>Original Price:</label>
                    <span class="price-value">₱85,000</span>
                </div>
                <div class="price-row">
                    <label>Seller Asking:</label>
                    <span class="price-value">₱58,000</span>
                </div>
                <div class="price-row">
                    <label>Seller:</label>
                    <span class="seller-name">John Doe</span>
                </div>
            </div>
            
            <div class="offer-inputs">
                <div class="form-group">
                    <label for="purchaseOffer">Purchase Offer</label>
                    <div class="input-with-currency">
                        <span class="currency">₱</span>
                        <input type="number" id="purchaseOffer" value="58000">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="markupPrice">Markup</label>
                    <div class="input-with-currency">
                        <span class="currency">₱</span>
                        <input type="number" id="markupPrice" value="10000">
                    </div>
                </div>
            </div>
            
            <div class="calculated-prices">
                <div class="calculated-row">
                    <label>Final List Price:</label>
                    <span class="final-price">₱68,000</span>
                </div>
                <div class="calculated-row">
                    <label>Potential Profit:</label>
                    <span class="profit-price">₱10,000</span>
                </div>
            </div>
            
            <div class="modal-actions">
                <button class="btn-reject">Reject</button>
                <button class="btn-approve">Approve & Purchase</button>
            </div>
        </div>
    </div>
</div>

<!-- Include the Add Listing Modal -->
<?php include '../includes/admin_addlisting.php'; ?>
<script src="../assets/js/admin_dashboard.js"></script>

<style>
.btn-delete {
    background-color: #ff3b30 !important;
    color: white !important;
    margin-left: 5px;
}
.btn-delete:hover {
    background-color: #e63321 !important;
}

/* Delete Confirmation Modal */
.delete-modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    justify-content: center;
    align-items: center;
}

.delete-modal-content {
    background-color: #fff;
    padding: 30px;
    border-radius: 12px;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.delete-modal-content h2 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 20px;
}

.delete-modal-content p {
    color: #666;
    margin: 0 0 20px 0;
}

.delete-modal-content .modal-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.delete-modal-content .btn-confirm {
    background-color: #ff3b30;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}

.delete-modal-content .btn-confirm:hover {
    background-color: #e63321;
}

.delete-modal-content .btn-cancel {
    background-color: #e5e7eb;
    color: #333;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}

.delete-modal-content .btn-cancel:hover {
    background-color: #d1d5db;
}
</style>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="delete-modal">
    <div class="delete-modal-content">
        <h2>Delete Listing?</h2>
        <p>Are you sure you want to delete <strong id="deleteItemName"></strong>? This action cannot be undone.</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn-confirm" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
let deleteListingId = null;

function editListing(listingId) {
    // Redirect to edit page or open edit modal
    window.location.href = 'edit_listing.php?id=' + listingId;
}

function deleteListing(listingId, itemName) {
    deleteListingId = listingId;
    document.getElementById('deleteItemName').textContent = itemName;
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    deleteListingId = null;
}

function confirmDelete() {
    if (!deleteListingId) return;
    
    fetch('../core/delete_listing.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            listing_id: deleteListingId
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Listing deleted successfully!');
            location.reload();
        } else {
            alert('Error deleting listing: ' + (data.message || 'Unknown error'));
            console.log('Delete response:', data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    });
    
    closeDeleteModal();
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>

<?php include 'includes/footer.php'; ?>


