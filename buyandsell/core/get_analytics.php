<?php
session_start();
require_once "db_connect.php";

header('Content-Type: application/json; charset=utf-8');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    die(json_encode(["status" => "error", "message" => "Not authorized"]));
}

try {
    $analytics = [];

    // 1. Monthly Revenue & Profit (Last 6 months)
    $sql = "SELECT 
        DATE_FORMAT(o.OrderDate, '%b') as month,
        SUM(o.TotalAmount) as revenue
    FROM orders o
    WHERE o.OrderDate >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY YEAR(o.OrderDate), MONTH(o.OrderDate)
    ORDER BY o.OrderDate ASC";
    
    $result = $conn->query($sql);
    if (!$result) {
        error_log("Monthly revenue query failed: " . $conn->error);
    }
    
    $monthlyData = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $revenue = floatval($row['revenue']) ?: 0;
            $monthlyData[] = [
                'month' => $row['month'],
                'revenue' => $revenue,
                'profit' => $revenue * 0.25 // 25% profit margin estimate
            ];
        }
    }
    // Pad to 6 months if less
    while (count($monthlyData) < 6) {
        array_unshift($monthlyData, ['month' => '', 'revenue' => 0, 'profit' => 0]);
    }
    $analytics['monthly_revenue_profit'] = array_slice($monthlyData, -6);

    // 2. Monthly Orders & Items Sold (Last 1 month)
    $sql = "SELECT 
        COUNT(DISTINCT o.OrderID) as total_orders,
        SUM(COALESCE(oi.Quantity, 1)) as total_items
    FROM orders o
    LEFT JOIN orderitems oi ON o.OrderID = oi.OrderID
    WHERE o.OrderDate >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    
    $result = $conn->query($sql);
    if (!$result) {
        error_log("Monthly orders query failed: " . $conn->error);
    }
    
    $row = $result ? $result->fetch_assoc() : null;
    $analytics['monthly_orders_items'] = [
        'orders' => $row ? intval($row['total_orders']) ?: 0 : 0,
        'items' => $row ? intval($row['total_items']) ?: 0 : 0
    ];

    // 2b. Order Status Distribution
    $sql = "SELECT 
        Status,
        COUNT(*) as count
    FROM orders
    GROUP BY Status";
    
    $result = $conn->query($sql);
    if (!$result) {
        error_log("Order status query failed: " . $conn->error);
    }
    
    $orderStatusCounts = [
        'Pending' => 0,
        'Processing' => 0,
        'Shipped' => 0,
        'Completed' => 0,
        'Cancelled' => 0
    ];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $status = $row['Status'];
            if (isset($orderStatusCounts[$status])) {
                $orderStatusCounts[$status] = intval($row['count']);
            }
        }
    }
    $analytics['order_status_distribution'] = $orderStatusCounts;

    // 3. Weekly Activity (Last 7 days - Completed Orders Only)
    $sql = "SELECT 
        COUNT(DISTINCT o.OrderID) as orders_count,
        COUNT(oi.OrderItemID) as items_count
    FROM orders o
    LEFT JOIN orderitems oi ON o.OrderID = oi.OrderID
    WHERE o.OrderDate >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    AND (o.Status = 'Completed' OR o.Status = 'completed')";
    
    $result = $conn->query($sql);
    if (!$result) {
        error_log("Weekly activity query failed: " . $conn->error);
    }
    
    $row = $result ? $result->fetch_assoc() : null;
    $ordersThisWeek = $row ? intval($row['orders_count']) ?: 0 : 0;
    $itemsThisWeek = $row ? intval($row['items_count']) ?: 0 : 0;
    $analytics['weekly_activity'] = [
        'completed_orders' => $ordersThisWeek,
        'items_sold' => $itemsThisWeek
    ];

    // 4. Top Selling Cameras
    $sql = "SELECT 
        CONCAT(l.brand, ' ', l.model) as camera_name,
        COUNT(oi.ListingID) as total_sold
    FROM listings l
    LEFT JOIN orderitems oi ON l.listing_id = oi.ListingID
    LEFT JOIN orders o ON oi.OrderID = o.OrderID
    WHERE o.Status = 'Completed' OR o.Status = 'completed'
    GROUP BY l.listing_id, l.brand, l.model
    HAVING total_sold > 0
    ORDER BY total_sold DESC
    LIMIT 5";
    
    $result = $conn->query($sql);
    if (!$result) {
        error_log("Top cameras query failed: " . $conn->error);
    }
    
    $topCameras = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if ($row['camera_name']) {
                $topCameras[] = [
                    'name' => $row['camera_name'],
                    'sold' => intval($row['total_sold']) ?: 0
                ];
            }
        }
    }
    $analytics['top_selling_cameras'] = $topCameras;

    // 5. Inventory by Brand
    $sql = "SELECT 
        l.brand,
        COUNT(*) as count
    FROM listings l
    GROUP BY l.brand
    ORDER BY count DESC";
    
    $result = $conn->query($sql);
    if (!$result) {
        error_log("Brand inventory query failed: " . $conn->error);
    }
    
    $brandInventory = [];
    $totalInventory = 0;
    $brands = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if ($row['brand']) {
                $totalInventory += intval($row['count']);
                $brands[] = [
                    'brand' => $row['brand'],
                    'count' => intval($row['count'])
                ];
            }
        }
    }
    
    // Calculate percentages
    foreach ($brands as $brand) {
        $percentage = $totalInventory > 0 ? round(($brand['count'] / $totalInventory) * 100) : 0;
        $brandInventory[] = [
            'brand' => $brand['brand'],
            'percentage' => $percentage,
            'count' => $brand['count']
        ];
    }
    $analytics['inventory_by_brand'] = $brandInventory;

    // 6. Top Viewed Cameras (Based on listings count)
    // 6. Top Viewed Cameras (Based on purchase count)
    $sql = "SELECT 
        CONCAT(l.brand, ' ', l.model) as camera_name,
        COUNT(oi.ListingID) as purchase_count
    FROM listings l
    LEFT JOIN orderitems oi ON l.listing_id = oi.ListingID
    GROUP BY l.listing_id, l.brand, l.model
    HAVING purchase_count > 0
    ORDER BY purchase_count DESC
    LIMIT 5";
    
    $result = $conn->query($sql);
    $topViewed = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if ($row['camera_name']) {
                $topViewed[] = [
                    'name' => $row['camera_name'],
                    'views' => intval($row['purchase_count']) * 100 // Scale up for display
                ];
            }
        }
    }
    $analytics['top_viewed_cameras'] = $topViewed;

    // 7. Monthly Items Sold (removed Top Search Terms - replaced with line chart)
    $sql = "SELECT 
        DATE_TRUNC(o.OrderDate, MONTH) as month_date,
        MONTH(o.OrderDate) as month_num,
        YEAR(o.OrderDate) as year_num,
        COUNT(oi.OrderItemID) as items_count
    FROM orders o
    LEFT JOIN orderitems oi ON o.OrderID = oi.OrderID
    WHERE o.Status = 'Completed' OR o.Status = 'completed'
    GROUP BY YEAR(o.OrderDate), MONTH(o.OrderDate)
    ORDER BY year_num ASC, month_num ASC";
    
    // Handle different MySQL versions - use YEAR/MONTH grouping
    $sql = "SELECT 
        MONTH(o.OrderDate) as month_num,
        YEAR(o.OrderDate) as year_num,
        DATE_FORMAT(o.OrderDate, '%b') as month_name,
        COUNT(oi.OrderItemID) as items_count
    FROM orders o
    LEFT JOIN orderitems oi ON o.OrderID = oi.OrderID
    WHERE (o.Status = 'Completed' OR o.Status = 'completed')
    GROUP BY YEAR(o.OrderDate), MONTH(o.OrderDate)
    ORDER BY year_num ASC, month_num ASC
    LIMIT 12";
    
    $result = $conn->query($sql);
    $monthlyItemsSold = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $monthlyItemsSold[] = [
                'month' => $row['month_name'] . ' ' . $row['year_num'],
                'short_month' => $row['month_name'],
                'items' => intval($row['items_count'])
            ];
        }
    }
    $analytics['monthly_items_sold'] = $monthlyItemsSold;

    // 8. Payment Method Distribution
    $sql = "SELECT 
        PaymentMethod,
        COUNT(*) as count
    FROM orders
    WHERE Status = 'Completed' OR Status = 'completed'
    GROUP BY PaymentMethod
    ORDER BY count DESC";
    
    $result = $conn->query($sql);
    $paymentMethods = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $paymentMethod = $row['PaymentMethod'] ?: 'Unknown';
            $normalizedMethod = 'Other';
            
            // Normalize payment method names - keep specific e-wallet types
            if (strtolower($paymentMethod) === 'cod') {
                $normalizedMethod = 'COD';
            } else if (stripos($paymentMethod, 'paymaya') !== false || stripos($paymentMethod, 'maya') !== false) {
                $normalizedMethod = 'PayMaya';
            } else if (stripos($paymentMethod, 'gcash') !== false) {
                $normalizedMethod = 'GCash';
            } else if (stripos($paymentMethod, 'maribank') !== false) {
                $normalizedMethod = 'Maribank';
            }
            
            // Aggregate counts by normalized method
            $found = false;
            foreach ($paymentMethods as &$pm) {
                if ($pm['method'] === $normalizedMethod) {
                    $pm['count'] += intval($row['count']);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $paymentMethods[] = [
                    'method' => $normalizedMethod,
                    'count' => intval($row['count'])
                ];
            }
        }
    }
    $analytics['payment_methods'] = $paymentMethods;

    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "analytics" => $analytics
    ]);

} catch (Exception $e) {
    error_log("Analytics error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
?>
