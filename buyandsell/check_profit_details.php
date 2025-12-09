<?php
include 'core/db_connect.php';

echo "=== Items in Completed Orders ===\n\n";

$sql = "SELECT 
    oi.OrderItemID,
    oi.ProductName,
    oi.Quantity,
    oi.Price as selling_price,
    l.original_price,
    (oi.Price - l.original_price) as profit_per_unit,
    (oi.Quantity * (oi.Price - l.original_price)) as total_profit
FROM orderitems oi
JOIN listings l ON oi.ListingID = l.listing_id
JOIN orders o ON oi.OrderID = o.OrderID
WHERE o.Status = 'completed' OR o.Status = 'Completed'
ORDER BY o.OrderDate DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Product: " . $row['ProductName'] . "\n";
        echo "  Quantity: " . $row['Quantity'] . "\n";
        echo "  Selling Price: ₱" . number_format($row['selling_price'], 2) . "\n";
        echo "  Original Price: ₱" . number_format($row['original_price'], 2) . "\n";
        echo "  Profit per Unit: ₱" . number_format($row['profit_per_unit'], 2) . "\n";
        echo "  Total Profit: ₱" . number_format($row['total_profit'], 2) . "\n\n";
    }
}

$conn->close();
?>
