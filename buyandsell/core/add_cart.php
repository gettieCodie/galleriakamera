<?php
session_start();
include "db_connect.php";
header('Content-Type: application/json');

// Dump session and POST data for debugging
$response = [
    'session' => $_SESSION,
    'post' => $_POST
];

// Check if logged in
if(!isset($_SESSION['user_id'])){
    $response['status'] = 'error';
    $response['msg'] = 'not_logged_in';
    echo json_encode($response);
    exit;
}

$customer_id = (int) $_SESSION['user_id'];
$listing_id = (int) ($_POST['listing_id'] ?? 0);

if(!$listing_id){
    $response['status'] = 'error';
    $response['msg'] = 'invalid_listing';
    echo json_encode($response);
    exit;
}

// Try to insert into DB
$stmt = $conn->prepare("INSERT INTO Cart (CustomerID, ListingID, Quantity) VALUES (?, ?, 1)
                        ON DUPLICATE KEY UPDATE Quantity = Quantity + 1");
$stmt->bind_param("ii", $customer_id, $listing_id);

if($stmt->execute()){
    $response['status'] = 'ok';
} else {
    $response['status'] = 'error';
    $response['msg'] = 'db_error';
}

echo json_encode($response);
?>
