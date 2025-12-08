<?php
include 'core/db_connect.php';

echo "=== Checking orders table ===\n";
$result = $conn->query('SELECT COUNT(*) as count FROM orders');
$row = $result->fetch_assoc();
echo "Total orders: " . $row['count'] . "\n\n";

if ($row['count'] > 0) {
    echo "=== Sample orders ===\n";
    $result = $conn->query('SELECT OrderID, CustomerID, TotalAmount, OrderDate, Status FROM orders LIMIT 3');
    while($order = $result->fetch_assoc()) {
        echo json_encode($order, JSON_PRETTY_PRINT) . "\n";
    }
}

$conn->close();
?>
