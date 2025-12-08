<?php
include 'core/db_connect.php';

echo "=== Orders Table ===\n";
$result = $conn->query('SHOW COLUMNS FROM Orders');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== OrderItems Table ===\n";
$result = $conn->query('SHOW COLUMNS FROM OrderItems');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== Sample Orders Query ===\n";
$result = $conn->query('SELECT * FROM Orders LIMIT 1');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo json_encode($row, JSON_PRETTY_PRINT) . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

$conn->close();
?>
