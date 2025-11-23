<?php 
session_start();
$user_id = 1; // Mock user ID
include 'includes/header_dashboard_user.php';
?>

<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <!-- Page Header -->
        <!-- <div class="dashboard-header">
            <h1 class="dashboard-title">User Dashboard</h1>
            <p class="dashboard-subtitle">Manage your camera listings, purchases, and more</p>
        </div> -->

        <!-- KPI Cards Section -->
        <section class="kpi-section">
            <!-- <h2 class="section-title">Overview</h2> -->
            <div class="kpi-grid">
                <!-- Total Listed -->
                <div class="kpi-card" data-kpi="total_listed">
                    <div class="kpi-icon">
                        <img src="assets/images/more.png" alt="Listed">
                    </div>
                    <div class="kpi-content">
                        <h3 class="kpi-value" id="total-listed">0</h3>
                        <p class="kpi-label">Total Listed</p>
                    </div>
                </div>

                <!-- Pending Review -->
                <div class="kpi-card" data-kpi="pending_review">
                    <div class="kpi-icon">
                        <img src="assets/images/clock.png" alt="Pending">
                    </div>
                    <div class="kpi-content">
                        <h3 class="kpi-value" id="pending-review">0</h3>
                        <p class="kpi-label">Pending Review</p>
                    </div>
                </div>

                <!-- Purchases -->
                <div class="kpi-card" data-kpi="purchases">
                    <div class="kpi-icon">
                        <img src="assets/images/purchase.png" alt="Purchases">
                    </div>
                    <div class="kpi-content">
                        <h3 class="kpi-value" id="total-purchases">0</h3>
                        <p class="kpi-label">Purchases</p>
                    </div>
                </div>

                <!-- Wishlist -->
                <div class="kpi-card" data-kpi="wishlist">
                    <div class="kpi-icon">
                        <img src="assets/images/wish.png" alt="Wishlist">
                    </div>
                    <div class="kpi-content">
                        <h3 class="kpi-value" id="wishlist-count">0</h3>
                        <p class="kpi-label">Wishlist Items</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- My Selling Items Section -->
        
            <section class="selling-section">
                <div class="section-header">
                    <h2 class="section-title">My Selling Items</h2>
                    <button class="btn-primary" id="sellItemBtn"><i class="fa-solid fa-plus"></i>Sell an Item</button>
                </div>
                <p class="section-subtitle">Track your listed cameras and their status</p>
                
        <div class = "selling-grid">
                <!-- Status Tabs -->
                <div class="status-tabs">
                    <button class="status-tab active" data-status="all">All</button>
                    <button class="status-tab" data-status="pending">Pending</button>
                    <button class="status-tab" data-status="approved">Approved</button>
                    <button class="status-tab" data-status="sold">Sold</button>
                </div>

                <!-- Selling Items List -->
                <div class="items-list" id="selling-items-list">
                    <!-- Items will be loaded here by JavaScript -->
                    <div class="empty-state">
                        <img src="assets/images/empty-listings.png" alt="No listings" class="empty-icon">
                        <h3>No items listed yet</h3>
                        <p>Start selling your cameras by clicking "Sell an Item"</p>
                    </div>
                </div>
            </div>

            <!-- My Purchases Section -->
            <section class="purchases-section">
                <h2 class="section-title">My Purchases</h2>
                <p class="section-subtitle">Track your orders and delivery status</p>
                
                <div class="purchases-list" id="purchases-list">
                    <!-- Purchases will be loaded here -->
                    <div class="empty-state">
                        <img src="assets/images/empty.png" alt="Empty wishlist" class="empty-icon">
                        <h3>No purchases yet</h3>
                        <p>Your purchase history will appear here</p>
                    </div>
                </div>
            </section>

            

            <!-- Camera Wishlist Section -->
            <section class="wishlist-section">
                <h2 class="section-title">Camera Wishlist</h2>
                <p class="section-subtitle">Your saved cameras</p>
                
                <div class="wishlist-grid" id="wishlist-items">
                    <!-- Wishlist items will be loaded here -->
                    <div class="empty-state">
                        <img src="assets/images/empty.png" alt="Empty wishlist" class="empty-icon">
                        <h3>Wishlist is empty</h3>
                        <p>Save cameras you're interested in from the marketplace</p>
                    </div>
                </div>
            </section>

            <!-- Reviews Section -->
            <section class="reviews-section">
                <h2 class="section-title">Reviews</h2>
                <p class="section-subtitle">Your product reviews and ratings</p>
                
                <div class="reviews-list" id="reviews-list">
                    <!-- Reviews will be loaded here -->
                    <div class="empty-state">
                        <img src="assets/images/empty.png" alt="Empty wishlist" class="empty-icon">
                        <h3>No reviews yet</h3>
                        <p>Your reviews will appear here after purchasing items</p>
                    </div>
                </div>
            </section>
        </section>
    </div>
</div>



<!-- Sell Item Modal -->
<div id="sellItemModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Sell Your Camera</h2>
        <form id="sellItemForm" class="sell-item-form">
            <div class="form-grid">
                <!-- Basic Information -->
                <div class="form-group">
                    <label for="brand">Brand *</label>
                    <input type="text" id="brand" name="brand" required>
                </div>
                
                <div class="form-group">
                    <label for="model">Model *</label>
                    <input type="text" id="model" name="model" required>
                </div>
                
                <div class="form-group">
                    <label for="condition">Condition *</label>
                    <select id="condition" name="condition" required>
                        <option value="">Select Condition</option>
                        <option value="new">New</option>
                        <option value="used">Used - Like New</option>
                        <option value="good">Used - Good</option>
                        <option value="fair">Used - Fair</option>
                    </select>
                </div>
                
                <div class="form-group full-width">
                    <label for="issues">Known Issues</label>
                    <textarea id="issues" name="issues" placeholder="Describe any issues or problems with the camera..."></textarea>
                </div>

                <!-- Specifications -->
                <div class="form-group">
                    <label for="megapixels">Megapixels *</label>
                    <input type="number" id="megapixels" name="megapixels" required>
                </div>
                
                <div class="form-group">
                    <label for="sensor">Sensor Type *</label>
                    <input type="text" id="sensor" name="sensor" required>
                </div>
                
                <div class="form-group full-width">
                    <label for="inclusions">What's Included</label>
                    <textarea id="inclusions" name="inclusions" placeholder="Lens, battery, charger, memory card, box, manuals, etc..."></textarea>
                </div>

                <!-- Purchase & Pricing -->
                <div class="form-group">
                    <label for="purchase_date">Date of Purchase</label>
                    <input type="date" id="purchase_date" name="purchase_date">
                </div>
                
                <div class="form-group full-width">
                    <label for="reason">Reason for Selling *</label>
                    <textarea id="reason" name="reason" required placeholder="Why are you selling this camera?"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="original_price">Original Price (₱) *</label>
                    <input type="number" id="original_price" name="original_price" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="asking_price">Asking Price (₱) *</label>
                    <input type="number" id="asking_price" name="asking_price" step="0.01" required>
                </div>

                <!-- Image Upload -->
                <div class="form-group full-width">
                    <label for="camera_images">Upload Images (Max 6 images)</label>
                    <input type="file" id="camera_images" name="camera_images[]" multiple accept="image/*">
                    <small>Upload clear photos of your camera from different angles</small>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn-secondary" id="cancelSellBtn">Cancel</button>
                <button type="submit" class="btn-primary">Submit for Review</button>
            </div>
        </form>
    </div>
</div>

<script src="assets/js/dashboard_user.js"></script>