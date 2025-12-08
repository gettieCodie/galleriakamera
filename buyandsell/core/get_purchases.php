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
<<<<<<< HEAD
                    c.FullName,
                    COUNT(oi.OrderItemID) as ItemCount
=======
                    s.FirstName,
                    s.LastName,
                    COUNT(DISTINCT oi.OrderItemID) as ItemCount
>>>>>>> 221ca9adc21723cf92af9bb9c7f65c0432423ea8
                  FROM orders o
                  LEFT JOIN Customers c ON o.CustomerID = c.CustomerID
                  LEFT JOIN orderitems oi ON o.OrderID = oi.OrderID
                  WHERE o.CustomerID = ?
                  GROUP BY o.OrderID, s.FirstName, s.LastName, o.OrderDate, o.TotalAmount, o.PaymentMethod, o.Status
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
            'customer_name' => $row['FullName'],
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