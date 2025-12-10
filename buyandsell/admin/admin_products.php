<?php 
session_start();
include '../includes/header_dashboard_admin.php';
include '../core/db_connect.php';

// Fetch ALL listings from database
$listings = [];
try {
    $sql = "SELECT 
        l.listing_id,
        l.brand,
        l.model,
        l.selling_price,
        l.original_price,
        l.created_at,
        (SELECT image_path FROM listing_images WHERE listing_id = l.listing_id LIMIT 1) as image_path,
        DATEDIFF(NOW(), l.created_at) as days_listed
    FROM listings l
    ORDER BY l.created_at DESC";
    
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $listings[] = $row;
        }
    }
} catch (Exception $e) {
    error_log("Error fetching listings: " . $e->getMessage());
}
?>

<div class="admin-dashboard-wrapper">
    <div class="admin-dashboard-container">
        
        <!-- Page Header -->
        <div class="admin-header">
            <h1 class="admin-title">All Products</h1>
            <p class="admin-subtitle">Complete inventory of all listings</p>
        </div>

        <!-- Back Button -->
        <div style="margin-bottom: 20px;">
            <button class="btn-view-all back-btn-dashboard" onclick="window.location.href='admin_dashboard.php'">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </button>
        </div>

        <!-- Full Inventory Table -->
        <div class="inventory-section">
            <div class="section-header">
                <h3 class="section-title">All Listings (<?php echo count($listings); ?> total)</h3>
            </div>
            <div class="inventory-table">
                <div class="table-header">
                    <div class="col">Camera</div>
                    <div class="col">Status</div>
                    <div class="col">Days Listed</div>
                    <div class="col">Price</div>
                    <div class="col">Original</div>
                    <div class="col">Actions</div>
                </div>
                <div class="table-body">
                    <?php if (!empty($listings)): ?>
                        <?php foreach ($listings as $item): ?>
                            <div class="table-row">
                                <div class="col camera-info">
                                    <img src="<?php echo $item['image_path'] ? (strpos($item['image_path'], 'uploads/') === 0 ? '../' . $item['image_path'] : $item['image_path']) : '../assets/images/empty.png'; ?>" alt="<?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?>" class="camera-thumb" onerror="this.src='../assets/images/empty.png'">
                                    <div>
                                        <h4><?php echo htmlspecialchars($item['brand']); ?> <?php echo htmlspecialchars($item['model']); ?></h4>
                                        <p>Listed: <?php echo date('M d, Y', strtotime($item['created_at'])); ?></p>
                                    </div>
                                </div>
                                <div class="col"><span class="status in-stock">Listed</span></div>
                                <div class="col"><?php echo (int)$item['days_listed']; ?> day<?php echo $item['days_listed'] !== '1' ? 's' : ''; ?></div>
                                <div class="col price">₱<?php echo number_format((float)$item['selling_price'], 2); ?></div>
                                <div class="col">₱<?php echo number_format((float)$item['original_price'], 2); ?></div>
                                <div class="col">
                                    <button class="btn-action view-more" data-id="<?php echo $item['listing_id']; ?>" onclick="editListing(<?php echo $item['listing_id']; ?>)">Edit</button>
                                    <button class="btn-action btn-delete" data-id="<?php echo $item['listing_id']; ?>" onclick="deleteListing(<?php echo $item['listing_id']; ?>, '<?php echo htmlspecialchars($item['brand'] . ' ' . $item['model']); ?>')">Remove</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="table-row">
                            <div class="col" style="grid-column: 1/-1; text-align: center; padding: 30px; color: #999;">
                                <p>No listings yet. Add a new listing to get started.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
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

.btn-delete {
    background-color: #ff3b30 !important;
    color: white !important;
    margin-left: 5px;
}
.btn-delete:hover {
    background-color: #e63321 !important;
}

/* Delete Confirmation Modal */
.delete-modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    justify-content: center;
    align-items: center;
}

.delete-modal-content {
    background-color: #fff;
    padding: 30px;
    border-radius: 12px;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.delete-modal-content h2 {
    margin: 0 0 10px 0;
    color: #333;
    font-size: 20px;
}

.delete-modal-content p {
    color: #666;
    margin: 0 0 20px 0;
}

.delete-modal-content .modal-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.delete-modal-content .btn-confirm {
    background-color: #ff3b30;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}

.delete-modal-content .btn-confirm:hover {
    background-color: #e63321;
}

.delete-modal-content .btn-cancel {
    background-color: #e5e7eb;
    color: #333;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
}

.delete-modal-content .btn-cancel:hover {
    background-color: #d1d5db;
}
</style>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="delete-modal">
    <div class="delete-modal-content">
        <h2>Delete Listing?</h2>
        <p>Are you sure you want to delete <strong id="deleteItemName"></strong>? This action cannot be undone.</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn-confirm" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
let deleteListingId = null;

// editListing function - simply redirect to edit page
function editListing(listingId) {
    window.location.href = 'edit_listing_simple.php?id=' + listingId;
}

function deleteListing(listingId, itemName) {
    deleteListingId = listingId;
    document.getElementById('deleteItemName').textContent = itemName;
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    deleteListingId = null;
}

function confirmDelete() {
    if (!deleteListingId) return;
    
    fetch('../core/delete_listing.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            listing_id: deleteListingId
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Listing deleted successfully!');
            location.reload();
        } else {
            alert('Error deleting listing: ' + (data.message || 'Unknown error'));
            console.log('Delete response:', data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    });
    
    closeDeleteModal();
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
</script>

<?php include '../includes/admin_footer.php'; ?>
