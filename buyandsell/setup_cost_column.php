<?php
include 'core/db_connect.php';

// Check if cost_price column exists
$sql = "SHOW COLUMNS FROM listings LIKE 'cost_price'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Column doesn't exist, add it
    $alter_sql = "ALTER TABLE listings ADD COLUMN cost_price DECIMAL(10,2) DEFAULT 0 AFTER original_price";
    
    if ($conn->query($alter_sql) === TRUE) {
        echo "✓ Cost price column added successfully!";
    } else {
        echo "✗ Error adding column: " . $conn->error;
    }
} else {
    echo "✓ Cost price column already exists!";
}

$conn->close();
?>
