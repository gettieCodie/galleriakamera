<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

include 'db_connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $customer_id = $_SESSION['user_id'];
    
    // Get pending count
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user_listings WHERE CustomerID = ? AND status = 'pending'");
    $stmt->execute([$customer_id]);
    $pending = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    // Get total listed (approved) count
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM user_listings WHERE CustomerID = ? AND status = 'approved'");
    $stmt->execute([$customer_id]);
    $approved = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'pending_review' => $pending,
        'total_listed' => $approved
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
