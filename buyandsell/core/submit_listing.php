<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

include 'db_connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $user_id = $_SESSION['user_id'];
    
    // Get form data
    $brand = trim($_POST['brand'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $condition = trim($_POST['condition'] ?? '');
    $megapixels = intval($_POST['megapixels'] ?? 0);
    $sensor = trim($_POST['sensor'] ?? '');
    $inclusions = trim($_POST['inclusions'] ?? '');
    $issues = trim($_POST['issues'] ?? '');
    $purchase_date = $_POST['purchase_date'] ?? null;
    $reason = trim($_POST['reason'] ?? '');
    $original_price = floatval($_POST['original_price'] ?? 0);
    $asking_price = floatval($_POST['asking_price'] ?? 0);
    
    // Validation
    $errors = [];
    if (empty($brand)) $errors[] = "Brand is required";
    if (empty($model)) $errors[] = "Model is required";
    if (empty($condition)) $errors[] = "Condition is required";
    if ($megapixels <= 0) $errors[] = "Valid megapixels is required";
    if (empty($sensor)) $errors[] = "Sensor type is required";
    if ($original_price <= 0) $errors[] = "Valid original price is required";
    if ($asking_price <= 0) $errors[] = "Valid asking price is required";
    if (empty($reason)) $errors[] = "Reason for selling is required";
    
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'errors' => $errors]);
        exit;
    }
    
    // Check if images are uploaded
    if (!isset($_FILES['camera_images']) || empty($_FILES['camera_images']['name'][0])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'At least one image is required']);
        exit;
    }
    
    // Check file upload errors
    foreach ($_FILES['camera_images']['error'] as $error) {
        if ($error !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'File upload error']);
            exit;
        }
    }
    
    // Begin transaction
    $pdo->beginTransaction();
    
    // Insert into user_listings table
    $stmt = $pdo->prepare("
        INSERT INTO user_listings 
        (CustomerID, brand, model, `condition`, megapixels, sensor, inclusions, known_issues, purchase_date, reason_for_selling, original_price, asking_price, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    
    $stmt->execute([
        $_SESSION['user_id'], $brand, $model, $condition, $megapixels, $sensor, $inclusions, $issues, $purchase_date, $reason, $original_price, $asking_price, 'pending'
    ]);
    
    $listing_id = $pdo->lastInsertId();
    
    // Create upload directory if it doesn't exist
    $uploadDir = __DIR__ . '/../uploads/user-listings/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Process and upload images
    $uploadedCount = 0;
    foreach ($_FILES['camera_images']['name'] as $index => $name) {
        if ($_FILES['camera_images']['error'][$index] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['camera_images']['tmp_name'][$index];
            
            // Generate unique filename
            $newFilename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9-_\.]/', '', $name);
            $uploadPath = $uploadDir . $newFilename;
            
            if (move_uploaded_file($tmpName, $uploadPath)) {
                $imagePath = 'uploads/user-listings/' . $newFilename;
                
                $imgStmt = $pdo->prepare("INSERT INTO user_listing_images (user_listing_id, image_path) VALUES (?, ?)");
                $imgStmt->execute([$listing_id, $imagePath]);
                
                $uploadedCount++;
            }
        }
    }
    
    $pdo->commit();
    
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Listing submitted for review!',
        'listing_id' => $listing_id,
        'uploaded_images' => $uploadedCount
    ]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
