<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$listing_id = $_POST['listing_id'] ?? null;
$quantity = $_POST['quantity'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$listing_id || !$quantity || $quantity < 1) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid listing_id or quantity']);
    exit;
}

include 'db_connect.php';

try {
    // Check if item exists in cart
    $checkStmt = $conn->prepare("SELECT * FROM Cart WHERE CustomerID = ? AND ListingID = ?");
    $checkStmt->bind_param("ii", $user_id, $listing_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Item not in cart']);
        $checkStmt->close();
        exit;
    }
    
    $checkStmt->close();
    
    // Update quantity
    $updateStmt = $conn->prepare("UPDATE Cart SET Quantity = ? WHERE CustomerID = ? AND ListingID = ?");
    $updateStmt->bind_param("iii", $quantity, $user_id, $listing_id);
    
    if ($updateStmt->execute()) {
        echo json_encode(['status' => 'ok', 'message' => 'Quantity updated']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update quantity']);
    }
    
    $updateStmt->close();
    $conn->close();
    
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>

