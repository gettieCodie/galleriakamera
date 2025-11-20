<?php
header('Content-Type: application/json');
include 'db_connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get all listings with their first image
    $stmt = $pdo->prepare("
        SELECT 
            l.listing_id,
            l.brand,
            l.model,
            l.description,
            l.megapixels,
            l.sensor,
            l.condition,
            l.original_price,
            l.selling_price,
            l.created_at,
            li.image_path
        FROM listings l
        LEFT JOIN listing_images li ON l.listing_id = li.listing_id
        WHERE li.image_id = (
            SELECT MIN(image_id) 
            FROM listing_images 
            WHERE listing_id = l.listing_id
        )
        ORDER BY l.created_at DESC
    ");
    
    $stmt->execute();
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If no listings found
    if (empty($listings)) {
        echo json_encode([]);
        exit;
    }
    
    echo json_encode($listings);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>