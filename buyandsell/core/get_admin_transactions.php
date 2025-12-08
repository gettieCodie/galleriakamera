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
    // Get limit from query parameter (default 20)
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 20;
    $limit = min($limit, 1000); // Max 1000 to prevent abuse
    
    // Fetch all transactions (orders and listing purchases)
    // For now, we'll get order data as transactions
    $sql = "SELECT 
                o.OrderID as transaction_id,
                'Purchased' as type,
                GROUP_CONCAT(DISTINCT CONCAT(l.brand, ' ', l.model) SEPARATOR ', ') as camera_name,
                o.TotalAmount as amount,
                o.OrderDate as date,
                o.Status as status,
                c.FullName as customer_name
            FROM orders o
            LEFT JOIN Customers c ON o.CustomerID = c.CustomerID
            LEFT JOIN orderitems oi ON o.OrderID = oi.OrderID
            LEFT JOIN listings l ON oi.ListingID = l.listing_id
            GROUP BY o.OrderID
            ORDER BY o.OrderDate DESC
            LIMIT " . $limit;
    
    $result = $conn->query($sql);
    
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    
    $transactions = [];
    while ($row = $result->fetch_assoc()) {
        $transactions[] = [
            'transaction_id' => '#TXN-' . str_pad($row['transaction_id'], 4, '0', STR_PAD_LEFT),
            'type' => $row['type'],
            'camera_name' => $row['camera_name'] ?: 'N/A',
            'amount' => $row['amount'],
            'date' => $row['date'],
            'status' => $row['status'] ?: 'Pending',
            'customer_name' => $row['customer_name']
        ];
    }
    
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "transactions" => $transactions
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>
