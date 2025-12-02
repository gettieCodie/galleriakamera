<?php
session_start();
include "db_connect.php";

// Receive form data
$data = json_decode(file_get_contents("php://input"), true);

// Map form fields
$firstName     = $data['first_name'] ?? '';
$lastName      = $data['last_name'] ?? '';
$email         = $data['email'] ?? '';
$mobile        = $data['mobile_number'] ?? '';
$altMobile     = $data['alternate_number'] ?? null;
$address1      = $data['address_line_1'] ?? '';
$address2      = $data['address_line_2'] ?? null;
$barangay      = $data['barangay'] ?? '';
$city          = $data['city'] ?? '';
$region        = $data['region'] ?? '';
$postalCode    = $data['postal_code'] ?? '';
$landmark      = $data['landmark'] ?? null;

// Optional: total amount and payment method from frontend
$totalAmount = $data['total_amount'] ?? 0;
$paymentMethod = $data['payment_method'] ?? 'COD';
$customerID = $_SESSION['user_id'] ?? 0; // Assuming user is logged in

$sqlOrder = "INSERT INTO orders (CustomerID, Email, TotalAmount, PaymentMethod) VALUES (?, ?, ?, ?)";
$stmtOrder = $conn->prepare($sqlOrder);
if (!$stmtOrder) {
    echo json_encode(["status" => "error", "message" => "Order prepare failed: " . $conn->error]);
    exit;
}
$stmtOrder->bind_param("isds", $customerID, $email, $totalAmount, $paymentMethod);

if ($stmtOrder->execute()) {
    $orderID = $stmtOrder->insert_id;
    $_SESSION['order_id'] = $orderID;

    // 2️⃣ Insert into shippingaddress table
    $sqlAddress = "INSERT INTO shippingaddress 
        (OrderID, Email, FirstName, LastName, Mobile, AlternateMobile, AddressLine1, AddressLine2, Barangay, City, Region, PostalCode, Landmark) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtAddress = $conn->prepare($sqlAddress);
    if (!$stmtAddress) {
        echo json_encode(["status" => "error", "message" => "Shipping prepare failed: " . $conn->error]);
        exit;
    }

    // Ensure all non-nullable fields have a value
    $altMobile  = $altMobile ?: null;
    $address2   = $address2 ?: null;
    $landmark   = $landmark ?: null;

    $stmtAddress->bind_param(
        "issssssssssss",
        $orderID,
        $email,
        $firstName,
        $lastName,
        $mobile,
        $altMobile,
        $address1,
        $address2,
        $barangay,
        $city,
        $region,
        $postalCode,
        $landmark
    );

    if ($stmtAddress->execute()) {
        echo json_encode(["status" => "success", "message" => "Order and shipping saved!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Shipping error: " . $stmtAddress->error]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Order error: " . $stmtOrder->error]);
}

?>