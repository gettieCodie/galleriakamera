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

   // 4️⃣ Copy cart items to orderitems table
    // Query to get all necessary info - adjust column names based on your listings table
    $sqlGetCart = "SELECT c.ListingID, c.Quantity, 
                        CONCAT(l.brand, ' ', l.model) AS ProductName,
                        l.selling_price AS Price
                   FROM cart c
                   INNER JOIN listings l ON c.ListingID = l.listing_id
                   WHERE c.CustomerID = ?";
    $stmtGetCart = $conn->prepare($sqlGetCart);
    if (!$stmtGetCart) {
        throw new Exception("Get cart prepare failed: " . $conn->error);
    }
    
    $stmtGetCart->bind_param("i", $customerID);
    
    if (!$stmtGetCart->execute()) {
        throw new Exception("Get cart failed: " . $stmtGetCart->error);
    }
    
    $cartResult = $stmtGetCart->get_result();
    $stmtGetCart->close();
    
    // Insert each cart item into orderitems
    if ($cartResult->num_rows > 0) {
        $sqlInsertItem = "INSERT INTO orderitems (OrderID, ListingID, ProductName, Variant, Quantity, Price) 
                          VALUES (?, ?, ?, ?, ?, ?)";
        $stmtInsertItem = $conn->prepare($sqlInsertItem);
        if (!$stmtInsertItem) {
            throw new Exception("Insert order item prepare failed: " . $conn->error);
        }
        
        while ($item = $cartResult->fetch_assoc()) {
            $listingID = $item['ListingID'];
            $quantity = $item['Quantity'];
            
            // Try different possible column names for ProductName
            $productName = $item['ProductName'] ?? $item['Name'] ?? $item['Title'] ?? 'Unknown Product';
            
            // Try different possible column names for Price
            $price = $item['Price'] ?? $item['selling_price'] ?? $item['ListingPrice'] ?? 0;
            
            // Variant is always null since cart doesn't have it
            $variant = null;
            
            $stmtInsertItem->bind_param(
                "iissid",
                $orderID,
                $listingID,
                $productName,
                $variant,
                $quantity,
                $price
            );
            
            if (!$stmtInsertItem->execute()) {
                throw new Exception("Insert order item failed: " . $stmtInsertItem->error);
            }
        }
        $stmtInsertItem->close();
    }

    // 5️⃣ Clear the cart after successful order
    $sqlClearCart = "DELETE FROM cart WHERE CustomerID = ?";
    $stmtClearCart = $conn->prepare($sqlClearCart);
    if (!$stmtClearCart) {
        throw new Exception("Clear cart prepare failed: " . $conn->error);
    }
    
    $stmtClearCart->bind_param("i", $customerID);
    
    if (!$stmtClearCart->execute()) {
        throw new Exception("Clear cart failed: " . $stmtClearCart->error);
    }
    
    $cartItemsCleared = $stmtClearCart->affected_rows;
    $stmtClearCart->close();

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