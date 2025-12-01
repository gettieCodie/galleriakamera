<?php
session_start();
include "db_connect.php";
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode([]);
    exit;
}

$customer_id = (int) $_SESSION['user_id'];

$sql = "SELECT 
    l.listing_id,
    l.brand,
    l.model,
    l.condition,
    l.selling_price,
    l.original_price,
    l.description,
    l.megapixels,
    l.sensor,
    (SELECT image_path FROM listing_images WHERE listing_id = l.listing_id LIMIT 1) as image_path,
    w.DateAdded
FROM Wishlist w
JOIN listings l ON w.ListingID = l.listing_id
WHERE w.CustomerID = ?
ORDER BY w.DateAdded DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while($row = $result->fetch_assoc()){
    $items[] = $row;
}

echo json_encode($items);
?>