<?php 
include "db_connect.php";

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT * FROM Customers WHERE VerifyToken = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "Invalid verification link.";
    exit;
}

$user = $result->fetch_assoc();
$stmt = $conn->prepare("UPDATE Customers SET IsVerified = 1, VerifyToken = NULL WHERE CustomerID = ?");
$stmt->bind_param("i", $user['CustomerID']);
$stmt->execute();

echo "<h2>Email verified successfully!</h2>";
echo "<a href='../login.php'>Click here to log in</a>";

?>