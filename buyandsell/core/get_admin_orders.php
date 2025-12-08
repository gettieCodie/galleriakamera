<?php
session_start();
header('Content-Type: application/json');

include 'db_connect.php';

try {
    $sql = "SELECT 
        o.OrderID as order_id,
        o.CustomerID,
        o.TotalAmount as total,
        o.OrderDate as order_date,
        o.Status as status,
        c.Email as customer_email,
        c.FullName as customer_name,
        sa.AddressLine1 as StreetAddress,
        sa.City,
        sa.PostalCode as ZipCode,
        sa.Region as State,
        GROUP_CONCAT(DISTINCT l.brand, ' ', l.model SEPARATOR ', ') as cameras,
        SUM(oi.Quantity) as total_items,
        COUNT(DISTINCT oi.ListingID) as item_count
    FROM orders o
    LEFT JOIN Customers c ON o.CustomerID = c.CustomerID
    LEFT JOIN shippingaddress sa ON o.OrderID = sa.OrderID
    LEFT JOIN orderitems oi ON o.OrderID = oi.OrderID
    LEFT JOIN listings l ON oi.ListingID = l.listing_id
    GROUP BY o.OrderID
    ORDER BY o.OrderDate DESC";
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    
    echo json_encode(['status' => 'ok', 'orders' => $orders]);
    
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?>
