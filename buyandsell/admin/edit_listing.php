<?php 
session_start();
include '../includes/header_dashboard_admin.php';
include '../core/db_connect.php';

// Show success message if redirected after update
$success_message = '';
if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
}

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

<div class="admin-dashboard-wrapper">
    <div class="admin-dashboard-container">
        <div class="admin-header">
            <h1 class="admin-title">Edit Listing</h1>
            <p class="admin-subtitle"><?php echo htmlspecialchars($listing['brand'] . ' ' . $listing['model']); ?></p>
        </div>

        <div style="margin-bottom: 20px;">
            <button class="btn-view-all back-btn-dashboard" onclick="window.location.href='admin_products.php'">
                <i class="fas fa-arrow-left"></i> Back
            </button>
        </div>

        <?php if ($success_message): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_message); ?>
        </div>
        <?php endif; ?>

        <div style="max-width: 800px; margin: 0 auto;">
            <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <form id="editForm" method="POST" action="../core/update_listing.php">
                    <input type="hidden" name="listing_id" value="<?php echo $listing_id; ?>">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Brand</label>
                            <input type="text" name="brand" value="<?php echo htmlspecialchars($listing['brand'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Model</label>
                            <input type="text" name="model" value="<?php echo htmlspecialchars($listing['model'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Description</label>
                        <textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-family: inherit; box-sizing: border-box;"><?php echo htmlspecialchars($listing['description'] ?? ''); ?></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Megapixels</label>
                            <input type="text" name="megapixels" value="<?php echo htmlspecialchars($listing['megapixels'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Sensor</label>
                            <input type="text" name="sensor" value="<?php echo htmlspecialchars($listing['sensor'] ?? ''); ?>" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Condition</label>
                            <select name="condition" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                                <option value="">Select Condition</option>
                                <option value="New" <?php echo ($listing['condition'] === 'New') ? 'selected' : ''; ?>>New</option>
                                <option value="Used" <?php echo ($listing['condition'] === 'Used') ? 'selected' : ''; ?>>Used</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 8px;">Original Price</label>
                            <input type="number" name="original_price" value="<?php echo htmlspecialchars($listing['original_price'] ?? ''); ?>" step="0.01" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                        </div>
                    </div>

                    <div style="margin-bottom: 30px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px;">Selling Price</label>
                        <input type="number" name="selling_price" value="<?php echo htmlspecialchars($listing['selling_price'] ?? ''); ?>" step="0.01" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
                    </div>

                    <div style="display: flex; gap: 12px; justify-content: flex-end;">
                        <button type="button" onclick="window.location.href='admin_products.php'" style="padding: 10px 20px; background: #f0f0f0; color: #333; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Cancel</button>
                        <button type="submit" style="padding: 10px 24px; background: #111; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.back-btn-dashboard {
    background: transparent;
    color: #111;
    padding: 10px 20px;
    border: 1px solid #111;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-btn-dashboard:hover {
    background: #111;
    color: white;
}
</style>

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

