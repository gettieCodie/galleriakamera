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
    
    $user_id = $_SESSION['user_id'];
    $status = isset($_GET['status']) ? $_GET['status'] : 'all';
    
    $sql = "
        SELECT 
            ul.user_listing_id,
            ul.brand,
            ul.model,
            ul.megapixels,
            ul.sensor,
            ul.condition,
            ul.original_price,
            ul.asking_price,
            ul.status,
            ul.created_at,
            uli.image_path
        FROM user_listings ul
        LEFT JOIN user_listing_images uli ON ul.user_listing_id = uli.user_listing_id
        WHERE ul.CustomerID = :CustomerID
    ";
    
    if ($status !== 'all') {
        $sql .= " AND ul.status = :status";
    }
    
    $sql .= " ORDER BY ul.created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    
    $params = [':CustomerID' => $_SESSION['user_id']];
    if ($status !== 'all') {
        $params[':status'] = $status;
    }
    
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($results)) {
        echo json_encode([]);
        exit;
    }
    
    // Group by user_listing_id to get first image
    $listings = [];
    foreach ($results as $row) {
        $id = $row['user_listing_id'];
        if (!isset($listings[$id])) {
            $listings[$id] = [
                'user_listing_id' => $row['user_listing_id'],
                'brand' => $row['brand'],
                'model' => $row['model'],
                'megapixels' => $row['megapixels'],
                'sensor' => $row['sensor'],
                'condition' => $row['condition'],
                'original_price' => $row['original_price'],
                'asking_price' => $row['asking_price'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'image_path' => $row['image_path']
            ];
        }
    }
    
    echo json_encode(array_values($listings));
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
