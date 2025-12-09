<?php
include 'core/db_connect.php';

echo "=== Listings Table Schema ===\n";
$result = $conn->query('SHOW COLUMNS FROM Listings');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
}

echo "\n=== Sample Listing ===\n";
$result = $conn->query('SELECT * FROM Listings LIMIT 1');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row, JSON_PRETTY_PRINT) . "\n";
    }
}

$conn->close();
?>
