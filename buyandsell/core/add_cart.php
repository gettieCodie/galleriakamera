<?php
session_start();
include "db_connect.php";
header('Content-Type: application/json');

// Check if logged in
if(!isset($_SESSION['user_id'])){
    echo json_encode(['status' => 'error', 'msg' => 'not_logged_in']);
    exit;
}

$customer_id = (int) $_SESSION['user_id'];
$listing_id = (int) ($_POST['listing_id'] ?? 0);

if(!$listing_id){
    echo json_encode(['status' => 'error', 'msg' => 'invalid_listing']);
    exit;
}

// Try to insert into DB
$stmt = $conn->prepare("INSERT INTO Cart (CustomerID, ListingID, Quantity) VALUES (?, ?, 1)
                        ON DUPLICATE KEY UPDATE Quantity = Quantity + 1");
$stmt->bind_param("ii", $customer_id, $listing_id);

if($stmt->execute()){
    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'error', 'msg' => 'db_error']);
}
?>
