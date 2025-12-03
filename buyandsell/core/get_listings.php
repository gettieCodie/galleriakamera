<?php
header('Content-Type: application/json');
include 'db_connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if specific listing_id is requested
    $listing_id = isset($_GET['listing_id']) ? (int)$_GET['listing_id'] : null;
    
    if ($listing_id) {
        // Get specific listing with ALL its images
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
            WHERE l.listing_id = :listing_id
            ORDER BY li.image_id ASC
        ");
        
        $stmt->execute([':listing_id' => $listing_id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($results)) {
            echo json_encode(['error' => 'Listing not found']);
            exit;
        }
        
        // Extract first row for product info, and all images
        $product = $results[0];
        $images = array_map(function($row) { return $row['image_path']; }, $results);
        
        // Remove nulls from images array
        $images = array_filter($images);
        
        echo json_encode([
            'listing_id' => $product['listing_id'],
            'brand' => $product['brand'],
            'model' => $product['model'],
            'description' => $product['description'],
            'megapixels' => $product['megapixels'],
            'sensor' => $product['sensor'],
            'condition' => $product['condition'],
            'original_price' => $product['original_price'],
            'selling_price' => $product['selling_price'],
            'images' => array_values($images)
        ]);
        exit;
    }
    
    // Get all listings with their first image (original behavior)
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