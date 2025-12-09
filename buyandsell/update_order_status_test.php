<?php
include 'core/db_connect.php';

// Update order 77 to Completed
$sql = "UPDATE orders SET Status = 'Completed' WHERE OrderID = 77";
if ($conn->query($sql) === TRUE) {
    echo "Order 77 updated to Completed status!<br>";
} else {
    echo "Error: " . $conn->error;
}

// Show updated orders
$sql = "SELECT OrderID, TotalAmount, Status FROM orders WHERE Status = 'Completed' ORDER BY OrderDate DESC";
$result = $conn->query($sql);

echo "<br>=== ALL COMPLETED ORDERS ===<br>";
$total = 0;
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Order ID: " . $row['OrderID'] . " | Amount: ₱" . number_format($row['TotalAmount'], 2) . "<br>";
        $total += $row['TotalAmount'];
    }
}
echo "<br><strong>Total Profit: ₱" . number_format($total, 2) . "</strong>";

$conn->close();
?>
