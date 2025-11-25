<?php 
session_start();
include 'includes/header_marketplace.php'; 
include 'includes/search_filter.php';
?>

<div class="cart-wrapper">
  <div class="cart-container">
    <!-- Header -->
    <div class="page-header">
      <h1>Shopping Cart</h1>
      <p class="subtitle">Review your items before checkout</p>
    </div>

    <!-- Products Grid -->
    <div id="cart-grid" class="products-grid"></div>
    
    <!-- Cart Summary -->
    <div id="cart-summary" class="cart-summary" style="display: none;">
      <div class="summary-content">
        <h3>Order Summary</h3>
        <div class="summary-row">
          <span>Subtotal:</span>
          <span id="subtotal">₱0.00</span>
        </div>
        <div class="summary-row">
          <span>Shipping:</span>
          <span>FREE</span>
        </div>
        <div class="summary-row total">
          <span>Total:</span>
          <span id="total">₱0.00</span>
        </div>
        <button onclick="window.location.href='checkout/checkout_user.php'">Proceed to Checkout</button>
      </div>
    </div>
    
    <!-- Empty State -->
    <div id="empty-cart" class="empty-state" style="display: none;">
      <img src="assets/images/empty.png" alt="Empty cart" class="empty-icon">
      <h2>Your cart is empty</h2>
      <p>Add some cameras to your cart to get started!</p>
      <button onclick="window.location.href='marketplace.php'" class="btn-primary">Browse Marketplace</button>
    </div>
  </div>
</div>

<!-- JS -->
<script src="assets/js/cart.js"></script>
<script src="assets/js/search.js" defer></script>

</body>
</html>