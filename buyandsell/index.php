<?php 
session_start();
include 'includes/header_hero.php';
include 'includes/header_user.php';
// include 'gridsystem.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galleria Kamera - Premium Second Hand Cameras</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

</head>
<body>
    <!-- Tagline Section -->
    <section class="tagline-section">
        <img src="assets/images/landing.svg" class="background-image">
        <div class="tagline-content">
            <h2>Choose <strong><em>Second-Hand</em></strong>. Choose <strong><em>Smart</em></strong>.</h2>
            <p>Premium cameras with history, quality, and refined value.</p>
            <button class="cta-button">Shop New Collection <i class="fa-solid fa-square-arrow-up-right"></i></button>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="features-container">
            <!-- Main Heading -->
            <div class="features-header">
                <h1>When you shop with Galleria Kamera</h1>
            </div>

            <!-- Features Grid -->
            <div class="features-grid">
                <!-- Feature 1 -->
                <div class="feature-item">
                    <div class="feature-content">
                        <i class="fas fa-check-circle"></i>
                        <div class="feature-text">
                            <h3>Quality Checked Gear</h3>
                            <p>every camera is ready to shoot</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-item">
                    <div class="feature-content">
                        <i class="fas fa-tag"></i>
                        <div class="feature-text">
                            <h3>Best Value Pricing</h3>
                            <p>Premium cameras at fair prices</p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-item">
                    <div class="feature-content">
                        <i class="fas fa-shield-alt"></i>
                        <div class="feature-text">
                            <h3>Safe & Secure Transactions</h3>
                            <p>Trusted payment methods for smooth</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brands Section --> 
    <section class="brands-section">
        <div class="brands-container">
            <div class="brands-grid">
                <!-- Canon Card -->
                <div class="brand-card">
                    <div class="brand-header">
                        <span class="brand-badge">Legacy</span>
                    </div>
                    
                    <h3 class="brand-title">Reliable. Refined. Iconic.</h3>
                    <p class="brand-description">The choice for creators who demand consistency.</p>
                    <div class="brand-image">
                        <img src="assets/images/canon.svg" alt="Canon Cameras">
                    </div>
                    <div class="brand-footer">
                        <button class="brand-btn">Shop Canon's<img src = "assets/images/arrows.png"></button>
                    </div>
                </div>

                <!-- Fujifilm Card -->
                <div class="brand-card">
                    <div class="brand-header">
                        <span class="brand-badge">Color</span>
                    </div>
                    
                    <h3 class="brand-title">Color. Soul. Story.</h3>
                    <p class="brand-description">Where timeless tones meet creative expression.</p>
                    <div class="brand-image">
                        <img src="assets/images/fuji.svg" alt="Fujifilm Cameras">
                    </div>
                    <div class="brand-footer">
                        <button class="brand-btn">Shop Fujifilm's  <img src = "assets/images/arrows.png"></button>
                    </div>
                </div>

                <!-- Sony Card -->
                <div class="brand-card">
                    <div class="brand-header">
                        <span class="brand-badge">Precision</span>
                    </div>
                    
                    <h3 class="brand-title">Fast. Sharp. Unstoppable.</h3>
                    <p class="brand-description">Innovation that keeps up with your vision.</p>
                    <div class="brand-image">
                        <img src="assets/images/sony.svg" alt="Sony Cameras">
                    </div>
                    <div class="brand-footer">
                        <button class="brand-btn">Shop Sony's<img src = "assets/images/arrows.png"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Announcement Section -->
    <section class="announcement-section">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                <img src="assets/images/HOLIDAY.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="assets/images/PURPOSE.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="assets/images/SCAM.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                <img src="assets/images/WHY BUY.png" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Best Sellers Section -->
    <section class="best-sellers-section">
        <div class="trending-header">
            <h1>Trending Now</h1>
        </div>
        <div class="products-grid">
        <!--
        include 'includes/db_connect.php';
        
        $query = "SELECT p.*, SUM(o.quantity) as total_sold 
                FROM products p 
                LEFT JOIN orders o ON p.id = o.product_id 
                GROUP BY p.id 
                ORDER BY total_sold DESC 
                LIMIT 4";
        $result = mysqli_query($conn, $query); 
        
        if(mysqli_num_rows($result) > 0) {
            // WITH DATA - Real products
            while($product = mysqli_fetch_assoc($result)) {
        ?> -->
        <div class="product-card has-data">
            <div class="product-badge">Best Seller</div>
            <div class="product-image">
                <img src="assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" onerror="this.src='assets/images/placeholder.jpg'">
            </div>
            <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
            <p class="product-price">PHP <?php echo number_format($product['price'], 2); ?></p>
            <p class="units-sold"><?php echo ($product['total_sold'] ?: 0); ?> units sold</p>
            <button class="add-to-cart-btn" data-product-id="<?php echo $product['id']; ?>">
                Add to cart
            </button>
        </div>
        <!-- 
            }
        } else {
            // NO DATA - Placeholder products
            for($i = 1; $i <= 4; $i++) {
        ?> -->
        <div class="product-card no-data">
            <div class="product-badge placeholder-badge">Best Seller</div>
            <div class="product-image placeholder-image">
                <div class="image-placeholder">📷</div>
            </div>
            <h3 class="product-name placeholder-text">Camera Model <?php echo $i; ?></h3>
            <p class="product-price placeholder-text">PHP --,--</p>
            <p class="units-sold placeholder-text">-- units sold</p>
            <button class="add-to-cart-btn placeholder-btn" disabled>
                Add to cart
            </button>
        </div>
        <!-- 
            }
        }
        mysqli_close($conn);
        ?> -->
    </div>

    <div class="view-more-container">
        <button class="view-more-btn">View More</button>
    </div>

    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
