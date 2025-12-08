<?php
include('db_connect.php');

echo "=== Testing Top Selling Cameras Query (COMPLETED ORDERS ONLY) ===\n";
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
if ($result) {
    echo "Rows returned: " . $result->num_rows . "\n\n";
    while($row = $result->fetch_assoc()) {
        echo json_encode($row, JSON_PRETTY_PRINT) . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== All orders check ===\n";
$result = $conn->query("SELECT COUNT(*) as total FROM orders");
$row = $result->fetch_assoc();
echo "Total orders: " . $row['total'] . "\n";

$result = $conn->query("SELECT COUNT(*) as total FROM orders WHERE Status = 'Completed'");
$row = $result->fetch_assoc();
echo "Completed orders: " . $row['total'] . "\n";
?>
