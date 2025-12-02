<?php
session_start();
include "db_connect.php";

header('Content-Type: application/json');

// Receive form data
$data = json_decode(file_get_contents("php://input"), true);

// Map form fields
$firstName = trim($data['first_name'] ?? '');
$lastName = trim($data['last_name'] ?? '');
$email = trim($data['email'] ?? '');
$mobile = trim($data['mobile_number'] ?? '');
$altMobile = !empty($data['alternate_number']) ? trim($data['alternate_number']) : null;
$address1 = trim($data['address_line_1'] ?? '');
$address2 = !empty($data['address_line_2']) ? trim($data['address_line_2']) : null;
$barangay = trim($data['barangay'] ?? '');
$city = trim($data['city'] ?? '');
$region = trim($data['region'] ?? '');
$postalCode = trim($data['postal_code'] ?? '');
$landmark = !empty($data['landmark']) ? trim($data['landmark']) : null;

$billingFirstName = trim($data['billing_first_name'] ?? '');
$billingLastName = trim($data['billing_last_name'] ?? '');
$billingEmail = trim($data['billing_email'] ?? '');
$billingMobile = trim($data['billing_mobile_number'] ?? '');
$billingAltMobile = !empty($data['billing_alternate_number']) ? trim($data['billing_alternate_number']) : null;
$billingAddress1 = trim($data['billing_address_line_1'] ?? '');
$billingAddress2 = !empty($data['billing_address_line_2']) ? trim($data['billing_address_line_2']) : null;
$billingBarangay = trim($data['billing_barangay'] ?? '');
$billingCity = trim($data['billing_city'] ?? '');
$billingRegion = trim($data['billing_region'] ?? '');
$billingPostalCode = trim($data['billing_postal_code'] ?? '');
$tin = !empty($data['tin']) ? trim($data['tin']) : null;
$businessName = !empty($data['business_name']) ? trim($data['business_name']) : null;
$businessStyle = !empty($data['business_style']) ? trim($data['business_style']) : null;

$totalAmount = floatval($data['total_amount'] ?? 0);
$paymentMethod = trim($data['payment_method'] ?? 'COD');
$customerID = $_SESSION['user_id'] ?? 0; // Assuming user is logged in

$conn->begin_transaction();

try {
    $sqlOrder = "INSERT INTO orders (CustomerID, Email, TotalAmount, PaymentMethod) VALUES (?, ?, ?, ?)";
    $stmtOrder = $conn->prepare($sqlOrder);
    if (!$stmtOrder) {
        throw new Exception("Order prepare failed: " . $conn->error);
    }
    
    $stmtOrder->bind_param("isds", $customerID, $email, $totalAmount, $paymentMethod);
    
    if (!$stmtOrder->execute()) {
        throw new Exception("Order insert failed: " . $stmtOrder->error);
    }
    
    $orderID = $stmtOrder->insert_id;
    $_SESSION['order_id'] = $orderID;
    $stmtOrder->close();

    $sqlAddress = "INSERT INTO shippingaddress 
        (OrderID, Email, FirstName, LastName, Mobile, AlternateMobile, AddressLine1, AddressLine2, Barangay, City, Region, PostalCode, Landmark) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtAddress = $conn->prepare($sqlAddress);
    if (!$stmtAddress) {
        throw new Exception("Shipping prepare failed: " . $conn->error);
    }

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

    if (!$stmtAddress->execute()) {
        throw new Exception("Shipping insert failed: " . $stmtAddress->error);
    }
    $stmtAddress->close();

    $sqlBilling = "INSERT INTO billingaddress 
        (OrderID, FirstName, LastName, Mobile, AlternateMobile, AddressLine1, AddressLine2, Barangay, City, Region, PostalCode, Email, TIN, BusinessName, BusinessStyle) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtBilling = $conn->prepare($sqlBilling);
    if (!$stmtBilling) {
        throw new Exception("Billing prepare failed: " . $conn->error);
    }

    $stmtBilling->bind_param(
        "issssssssssssss",
        $orderID,
        $billingFirstName,
        $billingLastName,
        $billingMobile,
        $billingAltMobile,
        $billingAddress1,
        $billingAddress2,
        $billingBarangay,
        $billingCity,
        $billingRegion,
        $billingPostalCode,
        $billingEmail,
        $tin,
        $businessName,
        $businessStyle
    );

    if (!$stmtBilling->execute()) {
        throw new Exception("Billing insert failed: " . $stmtBilling->error);
    }
    $stmtBilling->close();

    $conn->commit();
    
    http_response_code(200);
    echo json_encode([
        "status" => "success", 
        "message" => "Order saved successfully",
        "order_id" => $orderID
    ]);

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode([
        "status" => "error", 
        "message" => $e->getMessage()
    ]);
}

$conn->close();
?>