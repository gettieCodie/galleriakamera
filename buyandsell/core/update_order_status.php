<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$order_id = $_POST['order_id'] ?? null;
$new_status = $_POST['status'] ?? null;

if (!$order_id || !$new_status) {
    echo json_encode(['status' => 'error', 'message' => 'Missing order_id or status']);
    exit;
}

// Validate status
$valid_statuses = ['Pending', 'Processing', 'Shipped', 'Completed', 'Cancelled'];
if (!in_array($new_status, $valid_statuses)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid status']);
    exit;
}

include 'db_connect.php';

try {
    $sql = "UPDATE orders SET Status = ? WHERE OrderID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("si", $new_status, $order_id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'ok', 'message' => 'Order status updated']);
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?>
