<?php
include 'core/db_connect.php';

// Check order statuses
$sql = "SELECT DISTINCT Status FROM orders";
$result = $conn->query($sql);
echo "Order Statuses in database:\n";
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "  - '" . $row['Status'] . "'\n";
    }
}

// Count orders by status
$sql = "SELECT Status, COUNT(*) as count FROM orders GROUP BY Status";
$result = $conn->query($sql);
echo "\nOrders by status:\n";
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo "  {$row['Status']}: {$row['count']} orders\n";
    }
}

// Check profit calculation
$sql = "SELECT 
    COALESCE(SUM(oi.Quantity * (oi.Price - COALESCE(l.cost_price, 0))), 0) as profit,
    COUNT(*) as item_count,
    SUM(oi.Quantity) as total_qty
FROM orderitems oi
LEFT JOIN listings l ON oi.ListingID = l.listing_id
INNER JOIN orders o ON oi.OrderID = o.OrderID
WHERE LOWER(o.Status) = 'completed'";

$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    echo "\nProfit calculation (Completed orders only):\n";
    echo "  Profit: " . $row['profit'] . "\n";
    echo "  Items: " . $row['item_count'] . "\n";
    echo "  Total Qty: " . $row['total_qty'] . "\n";
}

$conn->close();
?>
