<!-- Search + Actions Section -->
<div class="search-actions-wrapper">
  <div class="search-actions-container">

    <!-- Search Bar -->
    <div class="search-bar-container">
      <img src="assets/images/search-interface-symbol.png" class="search-icon" alt="Search Icon">
      <input id="searchInput" type="text" placeholder="Search cameras, models, brands..." />
      <button id="searchClearBtn" class="search-clear" title="Clear" aria-label="Clear search">✕</button>
    </div>

    <!-- Action Bar -->
    <div class="actions-group">

    <button class="action-btn cart-btn" onclick="window.location.href='cart.php'">
        <img src="assets/images/shopping-bag.png" class="icon-img" alt="Cart">
        <span id="cart-count" class="badge">0</span>
    </button>

    <button class="action-btn wishlist-btn" onclick="window.location.href='wishlist.php'">
        <img src="assets/images/wishlist.png" class="icon-img" alt="Wishlist">
        <span id="wishlist-count" class="badge">0</span>
    </button>
    </div>

    
  </div>
</div>
