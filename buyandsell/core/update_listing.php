<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['status' => 'error', 'message' => 'Method not allowed']));
}

$listing_id = (int)($_POST['listing_id'] ?? 0);
$brand = $_POST['brand'] ?? '';
$model = $_POST['model'] ?? '';
$description = $_POST['description'] ?? '';
$megapixels = $_POST['megapixels'] ?? '';
$sensor = $_POST['sensor'] ?? '';
$condition = $_POST['condition'] ?? '';
$original_price = (float)($_POST['original_price'] ?? 0);
$selling_price = (float)($_POST['selling_price'] ?? 0);

if (!$listing_id || !$brand || !$model) {
    http_response_code(400);
    die(json_encode(['status' => 'error', 'message' => 'Missing required fields']));
}

try {
    // Simple parameterized query - 9 question marks, 9 values
    // Note: 'condition' is escaped with backticks as it's a reserved keyword
    $sql = "UPDATE listings SET 
            brand = ?, 
            model = ?, 
            description = ?, 
            megapixels = ?, 
            sensor = ?, 
            `condition` = ?, 
            original_price = ?, 
            selling_price = ? 
            WHERE listing_id = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die(json_encode(['status' => 'error', 'message' => 'DB error: ' . $conn->error]));
    }
    
    // 6 strings + 2 decimals + 1 int = ssssssddi (9 types for 9 params)
    $success = $stmt->bind_param(
        'ssssssddi',
        $brand,
        $model,
        $description,
        $megapixels,
        $sensor,
        $condition,
        $original_price,
        $selling_price,
        $listing_id
    );
    
    if (!$success) {
        die(json_encode(['status' => 'error', 'message' => 'Bind error: ' . $stmt->error]));
    }
    
    if (!$stmt->execute()) {
        die(json_encode(['status' => 'error', 'message' => 'Execute error: ' . $stmt->error]));
    }
    
    http_response_code(200);
    echo json_encode(['status' => 'success', 'message' => 'Listing updated successfully!']);
    $stmt->close();
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Exception: ' . $e->getMessage()]);
}
