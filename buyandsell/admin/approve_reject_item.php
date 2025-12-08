<?php
session_start();
header('Content-Type: application/json');

// Check if admin is logged in
if (!isset($_SESSION['admin_role']) || $_SESSION['admin_role'] !== 'admin') {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

include '../core/db_connect.php';

$action = $_POST['action'] ?? null;
$listing_id = $_POST['listing_id'] ?? null;

if (!$action || !$listing_id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
    exit;
}

try {
    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE user_listings SET status = 'approved' WHERE user_listing_id = ?");
        $stmt->bind_param("i", $listing_id);
        $stmt->execute();
        
        echo json_encode(['status' => 'success', 'message' => 'Item approved successfully']);
    } else if ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE user_listings SET status = 'rejected' WHERE user_listing_id = ?");
        $stmt->bind_param("i", $listing_id);
        $stmt->execute();
        
        echo json_encode(['status' => 'success', 'message' => 'Item rejected successfully']);
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
    
    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$conn->close();
?>
