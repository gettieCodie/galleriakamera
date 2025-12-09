<?php
include 'core/db_connect.php';

// Check all completed orders
$sql = "SELECT OrderID, TotalAmount, Status, OrderDate FROM orders WHERE Status = 'completed' ORDER BY OrderDate DESC LIMIT 10";
$result = $conn->query($sql);

echo "=== COMPLETED ORDERS ===\n";
$total = 0;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Order ID: " . $row['OrderID'] . " | Amount: ₱" . number_format($row['TotalAmount'], 2) . " | Status: " . $row['Status'] . " | Date: " . $row['OrderDate'] . "\n";
        $total += $row['TotalAmount'];
    }
}
echo "Total: ₱" . number_format($total, 2) . "\n\n";

// Check all orders (any status)
echo "=== ALL ORDERS (ANY STATUS) ===\n";
$sql = "SELECT OrderID, TotalAmount, Status, OrderDate FROM orders ORDER BY OrderDate DESC LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Order ID: " . $row['OrderID'] . " | Amount: ₱" . number_format($row['TotalAmount'], 2) . " | Status: " . $row['Status'] . " | Date: " . $row['OrderDate'] . "\n";
    }
}

$conn->close();
?>
