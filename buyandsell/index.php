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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    
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

    <h2 class="section-title">Featured Products</h2>

    <div class="products-grid" id="bestSellerGrid">

        <!-- PRODUCT CARD -->
        <div class="product-card">
            <div class="img-wrap">
                <img src="assets/images/xt100.jpg" alt="Fujifilm XT100">
                <button class="wishlist-btn">♡</button>
            </div>

            <h3>Fujifilm XT100</h3>

            <div class="price-section">
                <p class="price">₱28,500</p>
                <p class="savings">Save ₱5,000</p>
            </div>

            <p class="original-price">Brand New Price: <s>₱33,500</s></p>
        </div>


        <div class="product-card">
            <div class="img-wrap">
                <img src="assets/images/xa5.jpg" alt="Fujifilm XA5">
                <button class="wishlist-btn">♡</button>
            </div>

            <h3>Fujifilm XA5</h3>

            <div class="price-section">
                <p class="price">₱26,000</p>
                <p class="savings">Save ₱4,000</p>
            </div>

            <p class="original-price">Brand New Price: <s>₱30,000</s></p>
        </div>


        <div class="product-card">
            <div class="img-wrap">
                <img src="assets/images/m100.jpg" alt="Canon M100">
                <button class="wishlist-btn">♡</button>
            </div>

            <h3>Canon EOS M100</h3>

            <div class="price-section">
                <p class="price">₱24,000</p>
                <p class="savings">Save ₱3,500</p>
            </div>

            <p class="original-price">Brand New Price: <s>₱27,500</s></p>
        </div>


        <div class="product-card">
            <div class="img-wrap">
                <img src="assets/images/a6000.jpg" alt="Sony A6000">
                <button class="wishlist-btn">♡</button>
            </div>

            <h3>Sony A6000</h3>

            <div class="price-section">
                <p class="price">₱25,000</p>
                <p class="savings">Save ₱5,000</p>
            </div>

            <p class="original-price">Brand New Price: <s>₱30,000</s></p>
        </div>


        <!-- HIDDEN CARDS -->
        <div class="product-card more-item">
            <div class="img-wrap">
                <img src="assets/images/a6400.jpg" alt="Sony A6400">
                <button class="wishlist-btn">♡</button>
            </div>

            <h3>Sony A6400</h3>

            <div class="price-section">
                <p class="price">₱45,000</p>
                <p class="savings">Save ₱7,000</p>
            </div>

            <p class="original-price">Brand New Price: <s>₱52,000</s></p>
        </div>


        <div class="product-card more-item">
            <div class="img-wrap">
                <img src="assets/images/sve10.jpg" alt="Sony ZV-E10">
                <button class="wishlist-btn">♡</button>
            </div>

            <h3>Sony ZV-E10</h3>

            <div class="price-section">
                <p class="price">₱38,000</p>
                <p class="savings">Save ₱4,000</p>
            </div>

            <p class="original-price">Brand New Price: <s>₱42,000</s></p>
        </div>


        <div class="product-card more-item">
            <div class="img-wrap">
                <img src="assets/images/xt30.webp" alt="Fujifilm XT30 II">
                <button class="wishlist-btn">♡</button>
            </div>

            <h3>Fujifilm XT30 II</h3>

            <div class="price-section">
                <p class="price">₱56,000</p>
                <p class="savings">Save ₱6,000</p>
            </div>

            <p class="original-price">Brand New Price: <s>₱62,000</s></p>
        </div>

        <div class="product-card more-item">
            <div class="img-wrap">
                <img src="assets/images/m50 ii.webp" alt="Canon M50 II">
                <button class="wishlist-btn">♡</button>
            </div>

            <h3>Canon M50 II</h3>

            <div class="price-section">
                <p class="price">₱38,000</p>
                <p class="savings">Save ₱5,000</p>
            </div>

            <p class="original-price">Brand New Price: <s>₱43,000</s></p>
        </div>

    </div>

    <!-- Expand Button -->
    <button id="toggleMoreBtn" class="toggle-btn">
        Show More ▼
    </button>

    <!-- CTA (Hidden until expanded) -->
    <div class="cta-box" id="ctaBox">
        <p>Want to purchase these cameras?</p>
        <a href="register.php" class="cta-btn">Create an Account</a>
    </div>

</section>


    <!-- testimonial -->
        <section class="testimonial-section">
        <div class="testi-header">
            <h2 class="section-title">Transact with a local trusted community </h2>
        </div>
        
        <!-- Slider main container -->
        <div class="swiper mySwiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="rating">
                            <svg class="star-icon" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z" fill="currentColor"/>
                            </svg>
                            <span class="rating-value">4.9</span>
                        </div>
                        <p class="testimonial-text">
                            "This service has completely transformed how I manage my projects. The intuitive interface and powerful features save me hours every week."
                        </p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Sarah Johnson" class="author-avatar">
                            <div class="author-info">
                                <h5>Sarah Johnson</h5>
                                <span>Project Manager</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="rating">
                            <svg class="star-icon" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z" fill="currentColor"/>
                            </svg>
                            <span class="rating-value">4.8</span>
                        </div>
                        <p class="testimonial-text">
                            "I've tried many similar tools, but this one stands out for its simplicity and effectiveness. The customer support is exceptional too."
                        </p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Michael Chen" class="author-avatar">
                            <div class="author-info">
                                <h5>Michael Chen</h5>
                                <span>UX Designer</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="rating">
                            <svg class="star-icon" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z" fill="currentColor"/>
                            </svg>
                            <span class="rating-value">5.0</span>
                        </div>
                        <p class="testimonial-text">
                            "As a small business owner, this tool has been a game-changer. It's helped us streamline operations and improve team collaboration significantly."
                        </p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Jessica Williams" class="author-avatar">
                            <div class="author-info">
                                <h5>Jessica Williams</h5>
                                <span>Business Owner</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="rating">
                            <svg class="star-icon" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z" fill="currentColor"/>
                            </svg>
                            <span class="rating-value">4.7</span>
                        </div>
                        <p class="testimonial-text">
                            "The analytics features provide insights I didn't even know I needed. It's helped our team make data-driven decisions with confidence."
                        </p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="David Rodriguez" class="author-avatar">
                            <div class="author-info">
                                <h5>David Rodriguez</h5>
                                <span>Marketing Director</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="swiper-slide">
                    <div class="testimonial-card">
                        <div class="rating">
                            <svg class="star-icon" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z" fill="currentColor"/>
                            </svg>
                            <span class="rating-value">4.9</span>
                        </div>
                        <p class="testimonial-text">
                            "Implementation was seamless and the learning curve was minimal. Our team was productive within days of switching to this platform."
                        </p>
                        <div class="author">
                            <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Amanda Thompson" class="author-avatar">
                            <div class="author-info">
                                <h5>Amanda Thompson</h5>
                                <span>Team Lead</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <!-- Pagination -->
        <div class="swiper-pagination"></div>
        </div>

    </section>

<?php include 'includes/footer.php'; ?>

<script src="https://use.fontawesome.com/1744f3f671.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>

    
