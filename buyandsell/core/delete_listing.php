<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

// Get the listing ID from request
$data = json_decode(file_get_contents('php://input'), true);
$listing_id = isset($data['listing_id']) ? (int)$data['listing_id'] : 0;

if ($listing_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid listing ID']);
    exit;
}

try {
    // Delete listing images first
    $deleteImagesSQL = "DELETE FROM listing_images WHERE listing_id = ?";
    $stmtImages = $conn->prepare($deleteImagesSQL);
    if (!$stmtImages) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmtImages->bind_param("i", $listing_id);
    if (!$stmtImages->execute()) {
        throw new Exception("Execute failed: " . $stmtImages->error);
    }
    $stmtImages->close();
    
    // Delete the listing
    $deleteListingSQL = "DELETE FROM listings WHERE listing_id = ?";
    $stmtListing = $conn->prepare($deleteListingSQL);
    if (!$stmtListing) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmtListing->bind_param("i", $listing_id);
    $result = $stmtListing->execute();
    if (!$result) {
        throw new Exception("Execute failed: " . $stmtListing->error);
    }
    
    $affected = $conn->affected_rows;
    $stmtListing->close();
    
    if ($affected > 0) {
        echo json_encode(['success' => true, 'message' => 'Listing deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Listing not found or already deleted']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    error_log("Delete listing error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?>
