<?php
session_start();
include 'includes/header_dashboard_admin.php';
?>

<div class="admin-dashboard-wrapper">
    <div class="admin-dashboard-container">
        <div class="admin-header">
            <h1 class="admin-title">Add New Listing</h1>
            <p class="admin-subtitle">Add a camera listing to your inventory</p>
        </div>

        <button class="action-btn primary" id="openListingModal">
            <i class="fas fa-plus"></i>
            <span>Add New Listing</span>
        </button>
    </div>
</div>

<?php include 'includes/admin_addlisting.php'; ?>
<script src="assets/js/admin_dashboard.js"></script>
<?php include 'includes/footer.php'; ?>