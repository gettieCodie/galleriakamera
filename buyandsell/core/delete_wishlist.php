<?php 
session_start();
include "db_connect.php";
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>'error','msg'=>'not_logged_in']);
    exit;
}
$customer_id = (int) $_SESSION['user_id'];
$listing_id = (int) ($_POST['listing_id'] ?? 0);

$stmt = $conn->prepare("DELETE FROM Wishlist WHERE CustomerID = ? AND ListingID = ?");
$stmt->bind_param("ii", $customer_id, $listing_id);
$stmt->execute();

echo json_encode(['status'=>'ok']);
?>