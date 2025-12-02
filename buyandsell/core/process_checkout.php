<?php
session_start();
include 'db_connect.php';

$cart_items = $_SESSION['cart'] ?? [];
if (!$cart_items) {
    die("Cart is empty");
}

$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['Price'] * $item['Quantity'];
}

$customer_id = $_SESSION['user_id'];
$email = $_POST['email'];
$payment_method = $_POST['payment_method'];

// Insert into orders
$stmt = $conn->prepare("INSERT INTO orders (CustomerID, Email, TotalAmount, PaymentMethod) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isds", $customer_id, $email, $total_amount, $payment_method);
$stmt->execute();
$order_id = $conn->insert_id;

// Insert into orderitems
$stmt = $conn->prepare("INSERT INTO orderitems (OrderID, ListingID, ProductName, Variant, Quantity, Price) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($cart_items as $item) {
    $stmt->bind_param("iissid", $order_id, $item['ListingID'], $item['ProductName'], $item['Variant'], $item['Quantity'], $item['Price']);
    $stmt->execute();
}

// Clear cart
unset($_SESSION['cart']);

header("Location: order_confirmation.php?order_id=$order_id");
exit;
?>
