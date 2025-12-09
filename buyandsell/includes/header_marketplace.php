<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link rel="stylesheet" href="assets/css/marketplace.css">
    <link rel="stylesheet" href="assets/css/wishlist_cart.css">
    <link rel="stylesheet" href="assets/css/toast.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

</head>
<body>
    <!-- Navigation Bar -->
    <header class="navbar">
        <div class="container">
            <!-- Logo Section -->
            <a href="marketplace.php" class="logo">
                <img src="assets/images/logo.svg" alt="Logo">
            </a>

            <!-- Price Range Filter -->
            <div class="price-range-filter">
                <div class="filter-group">
                    <div class="price-input-wrapper">
                        <span class="currency">₱</span>
                        <input type="number" id="minPrice" placeholder="min" min="0" step="1000">
                    </div>
                </div>
                <div class="filter-separator">—</div>
                <div class="filter-group">

                    <div class="price-input-wrapper">
                        <span class="currency">₱</span>
                        <input type="number" id="maxPrice" placeholder="max" min="0" step="1000">
                    </div>
                </div>
                <button class="filter-apply-btn" onclick="applyPriceFilter()">Filter</button>
            </div>

            <!-- Navigation Links (right side) -->
            <nav class="nav-links">
                <ul>
                    <li><a href="dashboard_user.php" class="dashboard-link">
                        <img src="assets/images/dashboard.png" alt="Dashboard Icon">
                        My Dashboard
                    </a></li>
                    <li><a href="index.php" class="logout-btn"><img src="assets/images/logout.png" alt="Logout Icon">   Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

