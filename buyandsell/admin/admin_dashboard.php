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

// Fetch KPI metrics
$kpi_pending_review = 0;
$kpi_pending_orders = 0;
$kpi_total_revenue = 0;
$kpi_total_profit = 0;

// Trend data
$pending_review_trend = 0;
$pending_orders_trend = 0;
$revenue_trend_percent = 0;
$profit_trend_percent = 0;

try {
    // Pending Review count (from user_listings with status = 'pending')
    $sql = "SELECT COUNT(*) as count FROM user_listings WHERE status = 'pending'";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $kpi_pending_review = $row['count'];
    }
    
    // Pending Review trend (compare with yesterday)
    $sql = "SELECT COUNT(*) as count FROM user_listings WHERE status = 'pending' AND DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $yesterday_pending_review = $row['count'];
        $pending_review_trend = $kpi_pending_review - $yesterday_pending_review;
    }
    
    // Pending Orders count (orders with status = 'pending')
    $sql = "SELECT COUNT(*) as count FROM orders WHERE Status = 'pending'";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $kpi_pending_orders = $row['count'];
    }
    
    // Pending Orders trend (compare with yesterday)
    $sql = "SELECT COUNT(*) as count FROM orders WHERE Status = 'pending' AND DATE(OrderDate) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $yesterday_pending_orders = $row['count'];
        $pending_orders_trend = $kpi_pending_orders - $yesterday_pending_orders;
    }
    
    // Total Revenue (sum of all completed orders)
    $sql = "SELECT SUM(TotalAmount) as total FROM orders WHERE Status = 'completed'";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $kpi_total_revenue = $row['total'] ? (float)$row['total'] : 0;
    }
    
    // Revenue trend (compare with yesterday)
    $sql = "SELECT SUM(TotalAmount) as total FROM orders WHERE Status = 'completed' AND DATE(OrderDate) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $yesterday_revenue = $row['total'] ? (float)$row['total'] : 0;
        if ($yesterday_revenue > 0) {
            $revenue_trend_percent = (($kpi_total_revenue - $yesterday_revenue) / $yesterday_revenue) * 100;
        }
    }
    
    // Total Profit (sum of selling_price - original_price for completed orders)
    // We need to calculate based on the marketplace listings that have been sold
    $sql = "SELECT SUM(l.selling_price - l.original_price) as profit
            FROM listings l
            JOIN orderitems oi ON CONCAT(l.brand, ' ', l.model) = oi.ProductName
            JOIN orders o ON oi.OrderID = o.OrderID
            WHERE o.Status = 'completed'";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $kpi_total_profit = $row['profit'] ? (float)$row['profit'] : 0;
    }
    
    // Profit trend (compare with yesterday)
    $sql = "SELECT SUM(l.selling_price - l.original_price) as profit
            FROM listings l
            JOIN orderitems oi ON CONCAT(l.brand, ' ', l.model) = oi.ProductName
            JOIN orders o ON oi.OrderID = o.OrderID
            WHERE o.Status = 'completed' AND DATE(o.OrderDate) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
    $result = $conn->query($sql);
    if ($result) {
        $row = $result->fetch_assoc();
        $yesterday_profit = $row['profit'] ? (float)$row['profit'] : 0;
        if ($yesterday_profit > 0) {
            $profit_trend_percent = (($kpi_total_profit - $yesterday_profit) / $yesterday_profit) * 100;
        }
    }
} catch (Exception $e) {
    error_log("Error fetching KPI metrics: " . $e->getMessage());
}

// Fetch top requested cameras based on wishlist
$top_requested = [];
try {
    $sql = "SELECT 
        l.listing_id,
        l.brand,
        l.model,
        COUNT(w.WishlistID) as wishlist_count
    FROM listings l
    LEFT JOIN wishlist w ON l.listing_id = w.ListingID
    GROUP BY l.listing_id
    ORDER BY wishlist_count DESC
    LIMIT 4";
    
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $top_requested[] = $row;
        }
    }
} catch (Exception $e) {
    error_log("Error fetching top requested: " . $e->getMessage());
}

// Fetch pending customer submissions for review
$pending_items = [];
try {
    // First, test basic connection
    $test_sql = "SELECT COUNT(*) as count FROM user_listings WHERE status = 'pending'";
    $test_result = $conn->query($test_sql);
    if ($test_result) {
        $test_row = $test_result->fetch_assoc();
        error_log("Total pending count: " . $test_row['count']);
    }
    
    $sql = "SELECT 
        ul.user_listing_id,
        ul.brand,
        ul.model,
        ul.condition,
        ul.megapixels,
        ul.sensor,
        ul.original_price,
        ul.asking_price,
        ul.status,
        ul.created_at,
        ul.inclusions,
        ul.known_issues,
        c.FullName,
        c.Email,
        (SELECT image_path FROM user_listing_images WHERE user_listing_id = ul.user_listing_id LIMIT 1) as image_path
    FROM user_listings ul
    LEFT JOIN customers c ON ul.CustomerID = c.CustomerID
    WHERE ul.status = 'pending'
    ORDER BY ul.created_at DESC";
    
    error_log("Executing SQL: " . $sql);
    
    $result = $conn->query($sql);
    if (!$result) {
        error_log("Query error: " . $conn->error);
    } else {
        error_log("Query successful, rows: " . $result->num_rows);
        
        while ($row = $result->fetch_assoc()) {
            error_log("Found pending item: " . json_encode($row));
            $pending_items[] = $row;
        }
    }
    
    error_log("Total pending items fetched: " . count($pending_items));
    
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
}

// Fetch approved (purchased) items from user_listings
$purchased_items = [];
try {
    $sql = "SELECT 
        ul.user_listing_id,
        ul.brand,
        ul.model,
        ul.condition,
        ul.megapixels,
        ul.sensor,
        ul.original_price,
        ul.asking_price,
        ul.status,
        ul.created_at,
        ul.inclusions,
        ul.known_issues,
        c.FullName,
        c.Email,
        (SELECT image_path FROM user_listing_images WHERE user_listing_id = ul.user_listing_id LIMIT 1) as image_path
    FROM user_listings ul
    LEFT JOIN customers c ON ul.CustomerID = c.CustomerID
    WHERE ul.status = 'approved'
    ORDER BY ul.created_at DESC";
    
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $purchased_items[] = $row;
        }
    }
} catch (Exception $e) {
    error_log("Error fetching purchased items: " . $e->getMessage());
}

// Fetch listed items (from marketplace listings table)
$listed_items = [];
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
    ORDER BY l.created_at DESC";
    
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $listed_items[] = $row;
        }
    }
} catch (Exception $e) {
    error_log("Error fetching listed items: " . $e->getMessage());
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
                            <h3 class="kpi-value"><?php echo $kpi_pending_review; ?></h3>
                            <p class="kpi-label">Pending Review</p>
                            <div class="kpi-trend <?php echo $pending_review_trend >= 0 ? 'positive' : 'negative'; ?>">
                                <?php echo ($pending_review_trend >= 0 ? '+' : '') . $pending_review_trend; ?> from yesterday
                            </div>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="kpi-content">
                            <h3 class="kpi-value"><?php echo $kpi_pending_orders; ?></h3>
                            <p class="kpi-label">Pending Orders</p>
                            <div class="kpi-trend <?php echo $pending_orders_trend >= 0 ? 'positive' : 'negative'; ?>">
                                <?php echo ($pending_orders_trend >= 0 ? '+' : '') . $pending_orders_trend; ?> from yesterday
                            </div>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="kpi-content">
                            <h3 class="kpi-value">₱<?php echo number_format($kpi_total_revenue, 2); ?></h3>
                            <p class="kpi-label">Total Revenue</p>
                            <div class="kpi-trend <?php echo $revenue_trend_percent >= 0 ? 'positive' : 'negative'; ?>">
                                <?php echo ($revenue_trend_percent >= 0 ? '+' : '') . number_format($revenue_trend_percent, 1); ?>%
                            </div>
                        </div>
                    </div>

                    <div class="kpi-card">
                        <div class="kpi-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="kpi-content">
                            <h3 class="kpi-value">₱<?php echo number_format($kpi_total_profit, 2); ?></h3>
                            <p class="kpi-label">Total Profit</p>
                            <div class="kpi-trend <?php echo $profit_trend_percent >= 0 ? 'positive' : 'negative'; ?>">
                                <?php echo ($profit_trend_percent >= 0 ? '+' : '') . number_format($profit_trend_percent, 1); ?>%
                            </div>
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
                            <?php if (!empty($top_requested)): ?>
                                <?php foreach ($top_requested as $camera): ?>
                                    <?php
                                        // Determine priority based on wishlist count
                                        $priority = 'low';
                                        $priority_class = 'low';
                                        if ($camera['wishlist_count'] >= 10) {
                                            $priority = 'High';
                                            $priority_class = 'high';
                                        } elseif ($camera['wishlist_count'] >= 5) {
                                            $priority = 'Medium';
                                            $priority_class = 'medium';
                                        } else {
                                            $priority = 'Low';
                                            $priority_class = 'low';
                                        }
                                    ?>
                                    <div class="requested-item">
                                        <div class="camera-info">
                                            <h4><?php echo htmlspecialchars($camera['brand'] . ' ' . $camera['model']); ?></h4>
                                            <p><?php echo $camera['wishlist_count']; ?> customer request<?php echo $camera['wishlist_count'] !== '1' ? 's' : ''; ?></p>
                                        </div>
                                        <span class="priority <?php echo $priority_class; ?>"><?php echo $priority; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="requested-item">
                                    <div class="camera-info">
                                        <p>No wishlist data available</p>
                                    </div>
                                </div>
                            <?php endif; ?>
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
                        <!-- Debug info -->
                        <script>
                            console.log('Pending items count: <?php echo count($pending_items); ?>');
                            console.log('Pending items data: <?php echo json_encode($pending_items); ?>');
                        </script>
                        <?php if (!empty($pending_items)): ?>
                            <?php foreach ($pending_items as $item): ?>
                                <div class="pending-item" onclick="openPendingModal(<?php echo htmlspecialchars(json_encode($item)); ?>)" style="cursor: pointer;">
                                    <img src="<?php echo $item['image_path'] ? (strpos($item['image_path'], 'uploads/') === 0 ? '../' . $item['image_path'] : $item['image_path']) : '../assets/images/empty.png'; ?>" alt="<?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?>" class="camera-thumb" onerror="this.src='../assets/images/empty.png'">
                                    <div class="item-header">
                                        <h4><?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?></h4>
                                        <span class="condition excellent"><?php echo ucfirst($item['condition']); ?></span>
                                    </div>
                                    <div class="item-details">
                                        <p class="specs"><?php echo $item['megapixels']; ?>MP • <?php echo htmlspecialchars($item['sensor']); ?></p>
                                        <?php if ($item['inclusions']): ?>
                                            <p class="specs"><strong>Includes:</strong> <?php echo htmlspecialchars($item['inclusions']); ?></p>
                                        <?php endif; ?>
                                        <?php if ($item['known_issues']): ?>
                                            <p class="specs"><strong>Issues:</strong> <?php echo htmlspecialchars($item['known_issues']); ?></p>
                                        <?php endif; ?>
                                        <div class="prices">
                                            <span class="original">Original: ₱<?php echo number_format($item['original_price'], 2); ?></span>
                                            <span class="asking">Asking: ₱<?php echo number_format($item['asking_price'], 2); ?></span>
                                        </div>
                                        <div class="seller-info">
                                            <strong>Seller:</strong> <?php echo htmlspecialchars($item['FullName']); ?><br>
                                            <strong>Email:</strong> <?php echo htmlspecialchars($item['Email']); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <p>No pending items for review</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Purchased Content -->
                    <div class="purchase-content" data-purchase-content="purchased">
                        <?php if (!empty($purchased_items)): ?>
                            <?php foreach ($purchased_items as $item): ?>
                                <div class="pending-item">
                                    <img src="<?php echo $item['image_path'] ? (strpos($item['image_path'], 'uploads/') === 0 ? '../' . $item['image_path'] : $item['image_path']) : '../assets/images/empty.png'; ?>" alt="<?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?>" class="camera-thumb" onerror="this.src='../assets/images/empty.png'">
                                    <div class="item-header">
                                        <h4><?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?></h4>
                                        <span class="condition excellent"><?php echo ucfirst($item['condition']); ?></span>
                                    </div>
                                    <div class="item-details">
                                        <p class="specs"><?php echo $item['megapixels']; ?>MP • <?php echo htmlspecialchars($item['sensor']); ?></p>
                                        <?php if ($item['inclusions']): ?>
                                            <p class="specs"><strong>Includes:</strong> <?php echo htmlspecialchars($item['inclusions']); ?></p>
                                        <?php endif; ?>
                                        <?php if ($item['known_issues']): ?>
                                            <p class="specs"><strong>Issues:</strong> <?php echo htmlspecialchars($item['known_issues']); ?></p>
                                        <?php endif; ?>
                                        <div class="prices">
                                            <span class="original">Original: ₱<?php echo number_format($item['original_price'], 2); ?></span>
                                            <span class="asking">Asking: ₱<?php echo number_format($item['asking_price'], 2); ?></span>
                                        </div>
                                        <div class="seller-info">
                                            <strong>Seller:</strong> <?php echo htmlspecialchars($item['FullName']); ?><br>
                                            <strong>Email:</strong> <?php echo htmlspecialchars($item['Email']); ?>
                                        </div>
                                    </div>
                                    <button class="btn-action btn-success" onclick="addToListings(<?php echo htmlspecialchars(json_encode($item)); ?>)">Add to Listings</button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-state">
                                <p>No purchased items yet</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Listed Content -->
                    <div class="purchase-content" data-purchase-content="listed">
                        <?php if (!empty($listed_items)): ?>
                            <div class="inventory-table">
                                <div class="table-header">
                                    <div class="col">Camera</div>
                                    <div class="col">Original Price</div>
                                    <div class="col">Selling Price</div>
                                    <div class="col">Days Listed</div>
                                    <div class="col">Status</div>
                                </div>
                                <div class="table-body">
                                    <?php foreach ($listed_items as $item): ?>
                                        <div class="table-row">
                                            <div class="col">
                                                <img src="<?php echo $item['image_path'] ? (strpos($item['image_path'], 'uploads/') === 0 ? '../' . $item['image_path'] : $item['image_path']) : '../assets/images/empty.png'; ?>" alt="<?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?>" class="camera-thumb" onerror="this.src='../assets/images/empty.png'">
                                                <?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?>
                                            </div>
                                            <div class="col">₱<?php echo number_format($item['original_price'], 2); ?></div>
                                            <div class="col price">₱<?php echo number_format($item['selling_price'], 2); ?></div>
                                            <div class="col"><?php echo (int)$item['days_listed']; ?> day<?php echo $item['days_listed'] !== '1' ? 's' : ''; ?></div>
                                            <div class="col"><span class="status in-stock">Listed</span></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">
                                <p>No listed items from purchases yet</p>
                            </div>
                        <?php endif; ?>
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
                <button class="btn-reject" onclick="rejectCurrentItem()">Reject</button>
                <button class="btn-approve" onclick="approveCurrentItem()">Approve & Purchase</button>
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

.btn-success {
    background-color: #34c759 !important;
    color: white !important;
    margin-left: 5px;
}
.btn-success:hover {
    background-color: #30b050 !important;
}

/* Review Offer Modal */
.modal {
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

.modal.active {
    display: flex;
}

.modal-content {
    background-color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    position: relative;
    max-width: 600px;
    width: 90%;
}

.modal-content.large {
    max-width: 800px;
}

.modal-content .close {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 28px;
    font-weight: bold;
    color: #999;
    cursor: pointer;
}

.modal-content .close:hover {
    color: #000;
}

/* Offer Modal end of css */

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


