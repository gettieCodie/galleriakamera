<?php
session_start();
require_once "db_connect.php";

header('Content-Type: application/json; charset=utf-8');

$customerID = $_SESSION['user_id'] ?? null;

if (!$customerID) {
    http_response_code(401);
    die(json_encode(["status" => "error", "message" => "User not logged in"]));
}

try {
    // Get total listings count
    $sqlListed = "SELECT COUNT(*) as total_listed FROM listings WHERE seller_id = ?";
    $stmtListed = $conn->prepare($sqlListed);
    $stmtListed->bind_param("i", $customerID);
    $stmtListed->execute();
    $resultListed = $stmtListed->get_result();
    $rowListed = $resultListed->fetch_assoc();
    $totalListed = $rowListed['total_listed'] ?? 0;
    $stmtListed->close();
    
    // Get pending review count
    $sqlPending = "SELECT COUNT(*) as pending_review FROM listings WHERE seller_id = ? AND status = 'pending'";
    $stmtPending = $conn->prepare($sqlPending);
    $stmtPending->bind_param("i", $customerID);
    $stmtPending->execute();
    $resultPending = $stmtPending->get_result();
    $rowPending = $resultPending->fetch_assoc();
    $pendingReview = $rowPending['pending_review'] ?? 0;
    $stmtPending->close();
    
    // Get total purchases count
    $sqlPurchases = "SELECT COUNT(*) as total_purchases FROM orders WHERE CustomerID = ?";
    $stmtPurchases = $conn->prepare($sqlPurchases);
    $stmtPurchases->bind_param("i", $customerID);
    $stmtPurchases->execute();
    $resultPurchases = $stmtPurchases->get_result();
    $rowPurchases = $resultPurchases->fetch_assoc();
    $totalPurchases = $rowPurchases['total_purchases'] ?? 0;
    $stmtPurchases->close();
    
    // Get wishlist count
    $sqlWishlist = "SELECT COUNT(*) as wishlist_count FROM wishlist WHERE CustomerID = ?";
    $stmtWishlist = $conn->prepare($sqlWishlist);
    $stmtWishlist->bind_param("i", $customerID);
    $stmtWishlist->execute();
    $resultWishlist = $stmtWishlist->get_result();
    $rowWishlist = $resultWishlist->fetch_assoc();
    $wishlistCount = $rowWishlist['wishlist_count'] ?? 0;
    $stmtWishlist->close();
    
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "kpis" => [
            "total_listed" => (int)$totalListed,
            "pending_review" => (int)$pendingReview,
            "total_purchases" => (int)$totalPurchases,
            "wishlist_count" => (int)$wishlistCount
        ]
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>
