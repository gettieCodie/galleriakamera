<?php
include('core/db_connect.php');

echo "=== Order Items in Database ===\n";
$result = $conn->query('SELECT * FROM orderitems');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row, JSON_PRETTY_PRINT) . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== Listings Table Sample ===\n";
$result = $conn->query('SELECT listing_id, brand, model FROM listings LIMIT 3');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row, JSON_PRETTY_PRINT) . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== Current Top Selling Cameras Query ===\n";
$sql = "SELECT 
    CONCAT(l.brand, ' ', l.model) as camera_name,
    COUNT(oi.ListingID) as total_sold
FROM listings l
LEFT JOIN orderitems oi ON l.listing_id = oi.ListingID
GROUP BY l.listing_id, l.brand, l.model
HAVING total_sold > 0
ORDER BY total_sold DESC
LIMIT 5";

$result = $conn->query($sql);
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row, JSON_PRETTY_PRINT) . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== Check OrderItems vs Listings Connection ===\n";
$sql = "SELECT oi.ListingID, oi.ProductName, l.listing_id, l.brand, l.model 
        FROM orderitems oi
        LEFT JOIN listings l ON oi.ListingID = l.listing_id";
$result = $conn->query($sql);
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row, JSON_PRETTY_PRINT) . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}
?>
