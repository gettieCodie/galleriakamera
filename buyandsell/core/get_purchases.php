<?php
session_start();
require_once "db_connect.php";

header('Content-Type: application/json; charset=utf-8');

$customerID = $_SESSION['user_id'] ?? null;

if (!$customerID) {
    http_response_code(401);
    die(json_encode(["status" => "error", "message" => "User not logged in"]));
}

try {
    $sqlOrders = "SELECT 
                    o.OrderID,
                    o.OrderDate,
                    o.TotalAmount,
                    o.PaymentMethod,
                    o.Status,
                    s.FirstName,
                    s.LastName,
                    COUNT(oi.OrderItemID) as ItemCount
                  FROM orders o
                  LEFT JOIN shippingaddress s ON o.OrderID = s.OrderID
                  LEFT JOIN orderitems oi ON o.OrderID = oi.OrderID
                  WHERE o.CustomerID = ?
                  GROUP BY o.OrderID
                  ORDER BY o.OrderDate DESC";
    
    $stmtOrders = $conn->prepare($sqlOrders);
    if (!$stmtOrders) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmtOrders->bind_param("i", $customerID);
    
    if (!$stmtOrders->execute()) {
        throw new Exception("Execute failed: " . $stmtOrders->error);
    }
    
    $result = $stmtOrders->get_result();
    $orders = [];
    
    while ($row = $result->fetch_assoc()) {
        $orders[] = [
            'order_id' => $row['OrderID'],
            'date' => $row['OrderDate'],
            'total' => $row['TotalAmount'],
            'payment_method' => $row['PaymentMethod'],
            'status' => $row['Status'] ?? 'Pending',
            'customer_name' => $row['FirstName'] . ' ' . $row['LastName'],
            'items_count' => $row['ItemCount']
        ];
    }
    
    $stmtOrders->close();
    
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "orders" => $orders
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