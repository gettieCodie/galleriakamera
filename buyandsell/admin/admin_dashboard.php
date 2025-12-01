<?php 
session_start();
include '../includes/header_dashboard_admin.php';
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
                        <button class="btn-view-all">View All Inventory</button>
                    </div>
                    <div class="inventory-table">
                        <div class="table-header">
                            <div class="col">Camera</div>
                            <div class="col">Status</div>
                            <div class="col">Days Listed</div>
                            <div class="col">Price</div>
                            <div class="col">Views</div>
                            <div class="col">Actions</div>
                        </div>
                        <div class="table-body">
                            <!-- Item 1 -->
                            <div class="table-row">
                                <div class="col camera-info">
                                    <img src="assets/images/camera1.jpg" alt="Sony A7 III" class="camera-thumb">
                                    <div>
                                        <h4>Sony A7 III</h4>
                                        <p>24MP • Full Frame</p>
                                    </div>
                                </div>
                                <div class="col"><span class="status in-stock">In Stock</span></div>
                                <div class="col">3 days</div>
                                <div class="col price">₱45,000</div>
                                <div class="col">156</div>
                                <div class="col">
                                    <button class="btn-action view-more" data-id="1">View More</button>
                                </div>
                            </div>
                            <!-- Item 2 -->
                            <div class="table-row">
                                <div class="col camera-info">
                                    <img src="assets/images/camera2.jpg" alt="Canon R5" class="camera-thumb">
                                    <div>
                                        <h4>Canon R5</h4>
                                        <p>45MP • Full Frame</p>
                                    </div>
                                </div>
                                <div class="col"><span class="status low-stock">Low Stock</span></div>
                                <div class="col">7 days</div>
                                <div class="col price">₱120,000</div>
                                <div class="col">289</div>
                                <div class="col">
                                    <button class="btn-action view-more" data-id="2">View More</button>
                                </div>
                            </div>
                            <!-- Add more items as needed -->
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
<?php include 'includes/footer.php'; ?>


