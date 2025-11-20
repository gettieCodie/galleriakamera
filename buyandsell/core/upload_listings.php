<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set JSON header
header('Content-Type: application/json');

// TEMPORARY: Skip admin check for testing
// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     http_response_code(403);
//     echo json_encode(['success' => false, 'errors' => ['Access denied. Admin privileges required.']]);
//     exit;
// }

// Database configuration (XAMPP default)
include 'db_connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'errors' => ['Database connection failed: ' . $e->getMessage()]]);
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Log the request for debugging
    error_log("=== FORM SUBMISSION RECEIVED ===");
    error_log("POST data: " . print_r($_POST, true));
    error_log("FILES data: " . print_r($_FILES, true));
    
    // Get form data
    $brand = trim($_POST['brand'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $megapixels = intval($_POST['megapixels'] ?? 0);
    $sensor = trim($_POST['sensor'] ?? '');
    $condition = trim($_POST['condition'] ?? '');
    $original_price = floatval($_POST['original_price'] ?? 0);
    $selling_price = floatval($_POST['selling_price'] ?? 0);

    // Basic validation
    $errors = [];

    if (empty($brand)) $errors[] = "Brand is required";
    if (empty($model)) $errors[] = "Model is required";
    if (empty($description)) $errors[] = "Description is required";
    if ($megapixels <= 0) $errors[] = "Valid megapixels value is required";
    if (empty($sensor)) $errors[] = "Sensor type is required";
    if (!in_array($condition, ['New', 'Used'])) $errors[] = "Invalid condition value";
    if ($original_price <= 0) $errors[] = "Valid original price is required";
    if ($selling_price <= 0) $errors[] = "Valid selling price is required";

    // Validate images
    if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        $errors[] = "At least one image is required";
    } else {
        // Check file upload errors
        foreach ($_FILES['images']['error'] as $error) {
            if ($error !== UPLOAD_ERR_OK) {
                $errors[] = "File upload error: " . $error;
                break;
            }
        }
    }

    // If there are errors, return them
    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    try {
        $pdo->beginTransaction();

        // Insert into listings table
        $stmt = $pdo->prepare("
            INSERT INTO listings (brand, model, description, megapixels, sensor, `condition`, original_price, selling_price) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $brand, $model, $description, $megapixels, $sensor, $condition, $original_price, $selling_price
        ]);

        $listing_id = $pdo->lastInsertId();
        error_log("Listing inserted with ID: " . $listing_id);

        // Create uploads/products directory if it doesn't exist
        $uploadDir = __DIR__ . '/../uploads/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
            error_log("Created upload directory: " . $uploadDir);
        }

        // Check if directory is writable
        if (!is_writable($uploadDir)) {
            throw new Exception("Upload directory is not writable: " . $uploadDir);
        }

        // Process and upload images
        $uploadedCount = 0;
        foreach ($_FILES['images']['name'] as $index => $name) {
            if ($_FILES['images']['error'][$index] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['images']['tmp_name'][$index];
                
                // Generate unique filename
                $newFilename = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9-_\.]/', '', $name);
                $uploadPath = $uploadDir . $newFilename;

                error_log("Moving file: $tmpName to $uploadPath");
                
                // Move uploaded file
                if (move_uploaded_file($tmpName, $uploadPath)) {
                    $imagePath = 'uploads/products/' . $newFilename;
                    
                    $imgStmt = $pdo->prepare("INSERT INTO listing_images (listing_id, image_path) VALUES (?, ?)");
                    $imgStmt->execute([$listing_id, $imagePath]);
                    
                    $uploadedCount++;
                    error_log("Successfully uploaded: " . $imagePath);
                } else {
                    $uploadError = error_get_last();
                    throw new Exception("Failed to move uploaded file: " . $name . " - " . $uploadError['message']);
                }
            }
        }

        $pdo->commit();

        echo json_encode([
            'success' => true, 
            'message' => 'Listing added successfully!',
            'listing_id' => $listing_id,
            'uploaded_images' => $uploadedCount
        ]);

    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Error in transaction: " . $e->getMessage());
        
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'errors' => ['Server error: ' . $e->getMessage()]
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'errors' => ['Method not allowed']]);
}
?>