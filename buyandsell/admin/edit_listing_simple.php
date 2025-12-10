<?php 
session_start();
include '../core/db_connect.php';

$listing_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$listing_id) {
    header("Location: admin_products.php");
    exit;
}

// Fetch listing
$listing = null;
try {
    $sql = "SELECT * FROM listings WHERE listing_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $listing_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $listing = $result->fetch_assoc();
    
    if (!$listing) {
        header("Location: admin_products.php");
        exit;
    }
} catch (Exception $e) {
    error_log("Error fetching listing: " . $e->getMessage());
    header("Location: admin_products.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .header {
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #666;
            font-size: 14px;
        }
        
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: transparent;
            border: 1px solid #111;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            color: #111;
        }
        
        .back-btn:hover {
            background: #111;
            color: white;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        
        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #111;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
        }
        
        textarea {
            resize: vertical;
        }
        
        .button-group {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
        }
        
        button {
            padding: 10px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }
        
        .btn-cancel {
            background: #f0f0f0;
            color: #333;
        }
        
        .btn-cancel:hover {
            background: #e0e0e0;
        }
        
        .btn-submit {
            background: #111;
            color: white;
        }
        
        .btn-submit:hover {
            background: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="back-btn" onclick="window.location.href='admin_products.php'">← Back to Products</button>
        
        <div class="header">
            <h1>Edit Listing</h1>
            <p><?php echo htmlspecialchars($listing['brand'] . ' ' . $listing['model']); ?></p>
        </div>
        
        <form id="editForm">
            <input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($listing['brand'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($listing['model'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($listing['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="megapixels">Megapixels</label>
                    <input type="text" id="megapixels" name="megapixels" value="<?php echo htmlspecialchars($listing['megapixels'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="sensor">Sensor</label>
                    <input type="text" id="sensor" name="sensor" value="<?php echo htmlspecialchars($listing['sensor'] ?? ''); ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="condition">Condition</label>
                    <select id="condition" name="condition">
                        <option value="">Select Condition</option>
                        <option value="New" <?php echo ($listing['condition'] === 'New') ? 'selected' : ''; ?>>New</option>
                        <option value="Used" <?php echo ($listing['condition'] === 'Used') ? 'selected' : ''; ?>>Used</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="original_price">Original Price</label>
                    <input type="number" id="original_price" name="original_price" value="<?php echo htmlspecialchars($listing['original_price'] ?? ''); ?>" step="0.01">
                </div>
            </div>
            
            <div class="form-group">
                <label for="selling_price">Selling Price</label>
                <input type="number" id="selling_price" name="selling_price" value="<?php echo htmlspecialchars($listing['selling_price'] ?? ''); ?>" step="0.01">
            </div>
            
            <div class="button-group">
                <button type="button" class="btn-cancel" onclick="window.location.href='admin_products.php'">Cancel</button>
                <button type="submit" class="btn-submit">Save Changes</button>
            </div>
        </form>
    </div>
    
    <script>
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = document.getElementById('editForm');
        const formData = new FormData(form);
        
        fetch('../core/update_listing.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Show success notification
                const toast = document.createElement('div');
                toast.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #27ae60; color: white; padding: 16px 20px; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); z-index: 9999; font-weight: 600;';
                toast.textContent = '✓ ' + data.message;
                document.body.appendChild(toast);
                
                // Redirect after 1.5 seconds
                setTimeout(() => {
                    window.location.href = 'admin_products.php';
                }, 1500);
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving changes: ' + error.message);
        });
    });
    </script>
</body>
</html>
