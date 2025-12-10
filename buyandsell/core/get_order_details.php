<?php
session_start();
require_once "db_connect.php";

header('Content-Type: application/json; charset=utf-8');

$customerID = $_SESSION['user_id'] ?? null;
$isAdmin = isset($_SESSION['admin_id']);
$orderID = $_GET['order_id'] ?? null;

// Allow access for logged-in users or admins
if (!$customerID && !$isAdmin) {
    http_response_code(401);
    die(json_encode(["status" => "error", "message" => "User not logged in"]));
}

if (!$orderID) {
    http_response_code(400);
    die(json_encode(["status" => "error", "message" => "Order ID required"]));
}

try {
    // Get order details - admins can see any order, users can only see their own
    if ($isAdmin) {
        // Admin: can view any order
        $sqlOrder = "SELECT 
                        o.OrderID,
                        o.OrderDate,
                        o.TotalAmount,
                        o.PaymentMethod,
                        o.Status,
                        o.Email,
                        s.FirstName,
                        s.LastName,
                        s.Mobile,
                        s.AddressLine1,
                        s.AddressLine2,
                        s.City,
                        s.Region,
                        s.PostalCode
                     FROM orders o
                     LEFT JOIN shippingaddress s ON o.OrderID = s.OrderID
                     WHERE o.OrderID = ?
                     LIMIT 1";
        
        $stmtOrder = $conn->prepare($sqlOrder);
        if (!$stmtOrder) {
            throw new Exception("Order prepare failed: " . $conn->error);
        }
        
        $stmtOrder->bind_param("i", $orderID);
    } else {
        // User: can only view their own orders
        $sqlOrder = "SELECT 
                        o.OrderID,
                        o.OrderDate,
                        o.TotalAmount,
                        o.PaymentMethod,
                        o.Status,
                        o.Email,
                        s.FirstName,
                        s.LastName,
                        s.Mobile,
                        s.AddressLine1,
                        s.AddressLine2,
                        s.City,
                        s.Region,
                        s.PostalCode
                     FROM orders o
                     LEFT JOIN shippingaddress s ON o.OrderID = s.OrderID
                     WHERE o.OrderID = ? AND o.CustomerID = ?
                     LIMIT 1";
        
        $stmtOrder = $conn->prepare($sqlOrder);
        if (!$stmtOrder) {
            throw new Exception("Order prepare failed: " . $conn->error);
        }
        
        $stmtOrder->bind_param("ii", $orderID, $customerID);
    }
    
    if (!$stmtOrder->execute()) {
        throw new Exception("Order execute failed: " . $stmtOrder->error);
    }
    
    $orderResult = $stmtOrder->get_result();
    
    if ($orderResult->num_rows === 0) {
        http_response_code(404);
        die(json_encode(["status" => "error", "message" => "Order not found"]));
    }
    
    $order = $orderResult->fetch_assoc();
    $stmtOrder->close();
    
    // Get order items
    $sqlItems = "SELECT 
                    ProductName,
                    Variant,
                    Quantity,
                    Price
                 FROM orderitems
                 WHERE OrderID = ?";
    
    $stmtItems = $conn->prepare($sqlItems);
    if (!$stmtItems) {
        throw new Exception("Items prepare failed: " . $conn->error);
    }
    
    $stmtItems->bind_param("i", $orderID);
    
    if (!$stmtItems->execute()) {
        throw new Exception("Items execute failed: " . $stmtItems->error);
    }
    
    $itemsResult = $stmtItems->get_result();
    $items = [];
    
    while ($item = $itemsResult->fetch_assoc()) {
        $items[] = [
            'name' => $item['ProductName'],
            'variant' => $item['Variant'] ?? 'N/A',
            'price' => floatval($item['Price']),
            'qty' => intval($item['Quantity'])
        ];
    }
    
    $stmtItems->close();
    
    // Prepare response
    $response = [
        'status' => 'success',
        'order' => [
            'orderID' => $order['OrderID'],
            'date' => $order['OrderDate'],
            'customerName' => $order['FirstName'] . ' ' . $order['LastName'],
            'email' => $order['Email'],
            'mobile' => $order['Mobile'],
            'address' => trim($order['AddressLine1'] . ' ' . ($order['AddressLine2'] ?? '')),
            'city' => $order['City'],
            'region' => $order['Region'],
            'postalCode' => $order['PostalCode'],
            'paymentMethod' => $order['PaymentMethod'],
            'status' => $order['Status'] ?? 'Pending',
            'total' => floatval($order['TotalAmount']),
            'items' => $items
        ]
    ];
    
    http_response_code(200);
    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>