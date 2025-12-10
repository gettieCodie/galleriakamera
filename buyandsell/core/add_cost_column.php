<?php
include 'db_connect.php';

// Add cost_price column if it doesn't exist
$sql = "ALTER TABLE listings ADD COLUMN cost_price DECIMAL(10,2) DEFAULT 0 AFTER original_price";

if ($conn->query($sql) === TRUE) {
    echo "Cost column added successfully!";
} else {
    // Check if column already exists
    if (strpos($conn->error, "Duplicate column name") !== false) {
        echo "Cost column already exists.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
