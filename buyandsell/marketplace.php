<?php 
session_start();
include 'includes/header_marketplace.php'; 
include 'includes/search_filter.php';
?>

<div class="marketplace-wrapper">
  <div class="marketplace-container">

    <!-- Product Grid -->
    <div id="product-list" class="product-list"></div>

    <!-- No Listings Notice -->
    <div id="no-listings" class="no-listings">
      <img src="assets/images/empty-box.png" alt="No listings" class="no-listings-icon">
      <h2>No products listed yet</h2>
      <p>Products will appear here once an admin posts a listing.</p>
    </div>

  </div>
</div>

<!-- JS -->
<script type="module" src="assets/js/marketplace.js"></script>
