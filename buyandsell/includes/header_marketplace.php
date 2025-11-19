<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
    <link rel="stylesheet" href="assets/css/marketplace.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
    <!-- Navigation Bar -->
    <header class="navbar">
        <div class="container">
            <!-- Logo Section -->
            <a href="#" class="logo">
                <img src="assets/images/logo.svg" alt="Logo">
            </a>

            <!-- Camera Brand Menu (center) -->
            <div class="camera-brands">
                <div class="brand-item">
                    <span>Fujifilm</span>
                    <ul class="camera-models">
                        <li><a href="#">Fujifilm X-T4</a></li>
                        <li><a href="#">Fujifilm X100V</a></li>
                        <li><a href="#">Fujifilm GFX 100</a></li>
                    </ul>
                </div>
                <div class="brand-item">
                    <span>Sony</span>
                    <ul class="camera-models">
                        <li><a href="#">Sony A7 III</a></li>
                        <li><a href="#">Sony A9</a></li>
                        <li><a href="#">Sony Alpha 1</a></li>
                    </ul>
                </div>
                <div class="brand-item">
                    <span>Canon</span>
                    <ul class="camera-models">
                        <li><a href="#">Canon EOS R5</a></li>
                        <li><a href="#">Canon EOS 5D Mark IV</a></li>
                        <li><a href="#">Canon EOS Rebel T7</a></li>
                    </ul>
                </div>
            </div>

            <!-- Navigation Links (right side) -->
            <nav class="nav-links">
                <ul>
                    
                    <div class="nav-links-icons">
                        <i class="fa-solid fa-magnifying-glass" id="search-toggle"></i>
                        <i class="fa-regular fa-heart" onclick="window.location.href='wishlist.php'"></i>
                        <i class="fa-solid fa-bag-shopping" onclick="window.location.href='cart.php'"></i>
                    </div>
                    <li><a href="../dashboard.php">My Dashboard</a></li>
                    <li><a href="../logout.php" class="logout-btn">Logout</a></li>
                </ul>
            </nav>
        </div>s
    </header>
</body>
</html>
