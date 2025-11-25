<?php 
session_start();
include 'includes/header_marketplace.php'; 
include 'includes/search_filter.php';
?>

<div class="wishlist-wrapper">
  <div class="wishlist-container">
    <!-- Header -->
    <div class="page-header">
      <h1>My Wishlist</h1>
      <p class="subtitle">Your favorite items saved for later</p>
    </div>

    <!-- Products Grid -->
    <div id="wishlist-grid" class="products-grid"></div>
    
    <!-- Empty State -->
    <div id="empty-wishlist" class="empty-state" style="display: none;">
      <img src="assets/images/empty.png" alt="Empty wishlist" class="empty-icon">
      <h2>Your wishlist is empty</h2>
      <p>Start adding your favorite cameras to your wishlist!</p>
      <button onclick="window.location.href='marketplace.php'" class="btn-primary">Browse Marketplace</button>
    </div>
  </div>
</div>

<!-- JS -->
<script src="assets/js/wishlist.js"></script>
<script src="assets/js/search.js" defer></script>

</body>
</html>