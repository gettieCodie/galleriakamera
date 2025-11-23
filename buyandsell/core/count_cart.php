<?php
session_start();
include "db_connect.php";
header('Content-Type: application/json');

$customer_id = $_SESSION['user_id'] ?? 0;
$stmt = $conn->prepare("SELECT COALESCE(SUM(Quantity),0) AS total FROM Cart WHERE CustomerID = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
echo json_encode(['count' => (int)($res['total'] ?? 0)]);
?>