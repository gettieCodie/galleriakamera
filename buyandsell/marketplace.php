<?php 
session_start();
include 'includes/header_marketplace.php'; 
include 'includes/announcement.php';
include 'includes/search_filter.php';
include 'includes/product_modal.php';
include 'gk-chat-service/chat-widget.php';
?>

<div class="marketplace-wrapper">
  <div class="marketplace-container">

    <!-- Product Grid -->
    <div id="product-list" class="product-list"></div>

    <!-- No Listings Notice -->
    <div id="no-listings" class="no-listings">
      <img src="assets/images/empty.png" alt="No listings" class="no-listings-icon">
      <h2>No products listed yet</h2>
      <p>Products will appear here once an admin posts a listing.</p>
    </div>

  </div>
</div>

<!-- JS -->
<script src="assets/js/toast.js"></script>
<script src="assets/js/marketplace.js"></script>
<script src="assets/js/search.js" defer></script>
<!-- Bootstrap JS for Carousel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<!-- Price Filter Initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    
    if (minPriceInput && maxPriceInput) {
        minPriceInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                window.applyPriceFilter();
            }
        });
        
        maxPriceInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                window.applyPriceFilter();
            }
        });
    }
});
</script>

<?php include 'includes/marketplace_footer.php'; ?>
