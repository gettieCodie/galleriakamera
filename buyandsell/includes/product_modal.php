<!-- Product Details Modal - Premium Design -->
<div id="productModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto" style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full" style="max-width: 900px; height: 600px;">
        <!-- Close Button -->
        <button onclick="closeProductModal()" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors z-10">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-8 p-8 h-full">
            <!-- Product Gallery Section -->
            <div class="flex flex-col gap-4">
                <!-- Main Image Square Frame -->
                <div class="relative bg-gray-50 rounded-xl overflow-hidden aspect-square">
                    <div class="swiper modal-main-carousel w-full h-full">
                        <div class="swiper-wrapper h-full">
                            <div class="swiper-slide bg-gray-100 flex items-center justify-center h-full">
                                <img id="mainImage" src="" alt="Product" class="w-full h-full object-contain p-4">
                            </div>
                        </div>
                        <div class="swiper-button-prev modal-nav-prev"></div>
                        <div class="swiper-button-next modal-nav-next"></div>
                    </div>
                </div>
                
                <!-- Thumbnail Gallery -->
                <div class="flex gap-3 overflow-x-auto pb-2">
                    <div id="thumbnailGallery" class="flex gap-3">
                        <!-- Thumbnails populated by JS -->
                    </div>
                </div>
            </div>
            
            <!-- Product Details Section -->
            <div class="flex flex-col justify-between space-y-4 py-4 overflow-y-auto pr-4">
                <!-- Header -->
                <div>
                    <!-- Brand Badge -->
                    <span id="productBrand" class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-full mb-2"></span>
                    
                    <!-- Title -->
                    <h1 id="productTitle" class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3 leading-tight line-clamp-2"></h1>
                    
                    <!-- Price Section -->
                    <div class="flex items-baseline gap-3 mb-4">
                        <span id="productPrice" class="text-2xl font-bold text-gray-900">₱0.00</span>
                        <span id="originalPrice" class="text-sm text-gray-500 line-through">₱0.00</span>
                        <span id="discount" class="text-sm font-semibold text-red-500 bg-red-50 px-2 py-1 rounded"></span>
                    </div>
                    
                    <!-- Divider -->
                    <div class="h-px bg-gray-200 mb-4"></div>
                </div>

                <!-- Product Specifications -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-900 uppercase tracking-wide mb-3">Details</h3>
                    <ul id="productSpecs" class="space-y-2">
                        <!-- Specs populated by JS -->
                    </ul>
                </div>

                <!-- Condition Badge -->
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium text-gray-600">Condition:</span>
                    <span id="conditionBadge" class="px-3 py-1 rounded-full font-semibold text-xs"></span>
                </div>

                <!-- Description -->
                <p id="productDescription" class="text-gray-600 text-xs leading-relaxed line-clamp-3"></p>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-2">
                    <!-- Wishlist Button -->
                    <button onclick="toggleWishlistModal()" class="flex-shrink-0 w-11 h-11 rounded-lg border-2 border-gray-200 hover:border-red-500 hover:bg-red-50 transition-all flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                    
                    <!-- Add to Cart Button -->
                    <button onclick="addToCartModal()" class="flex-1 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Add to Cart
                    </button>
                </div>

                <!-- Checkout Button -->
                <button onclick="goToCheckout()" class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold py-2.5 px-4 rounded-lg transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Buy Now
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Modal Swiper Styles */
.modal-main-carousel .swiper-button-prev,
.modal-main-carousel .swiper-button-next {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    color: #4f46e5;
    font-weight: bold;
    transition: all 0.3s;
}

.modal-main-carousel .swiper-button-prev:hover,
.modal-main-carousel .swiper-button-next:hover {
    background: rgba(255, 255, 255, 1);
    color: #4338ca;
}

.modal-main-carousel .swiper-button-prev::after,
.modal-main-carousel .swiper-button-next::after {
    font-size: 18px;
}

/* Square Frame for Images */
.aspect-square {
    aspect-ratio: 1 / 1;
}

/* Thumbnail Gallery */
#thumbnailGallery .modal-thumbnail {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
    border-radius: 8px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s;
    overflow: hidden;
    background: #f3f4f6;
}

#thumbnailGallery .modal-thumbnail:hover {
    border-color: #4f46e5;
}

#thumbnailGallery .modal-thumbnail.active {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

#thumbnailGallery .modal-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Fix Swiper dimensions */
.modal-main-carousel {
    width: 100%;
    height: 100%;
}

.modal-main-carousel .swiper-wrapper {
    height: 100%;
}

.modal-main-carousel .swiper-slide {
    height: 100%;
}
</style>

<script>
let currentModalProduct = null;
let modalCarousel = null;

function openProductModal(product) {
    currentModalProduct = product;
    
    // Update product details
    document.getElementById('productTitle').textContent = `${product.brand} ${product.model}`;
    document.getElementById('productBrand').textContent = product.brand;
    
    const sellingPrice = parseFloat(product.selling_price);
    const originalPrice = parseFloat(product.original_price);
    const savings = originalPrice - sellingPrice;
    const discountPercent = Math.round((savings / originalPrice) * 100);
    
    document.getElementById('productPrice').textContent = `₱${sellingPrice.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    document.getElementById('originalPrice').textContent = `₱${originalPrice.toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    document.getElementById('discount').textContent = `${discountPercent}% OFF`;
    document.getElementById('productDescription').textContent = product.description;
    
    // Condition badge styling
    const conditionBadge = document.getElementById('conditionBadge');
    if (product.condition.toLowerCase() === 'new') {
        conditionBadge.textContent = '✓ Like New';
        conditionBadge.className = 'px-3 py-1 rounded-full font-semibold text-xs bg-green-100 text-green-700';
    } else {
        conditionBadge.textContent = '✓ Used';
        conditionBadge.className = 'px-3 py-1 rounded-full font-semibold text-xs bg-blue-100 text-blue-700';
    }
    
    // Set main image
    document.getElementById('mainImage').src = product.image_path || 'assets/images/empty.png';
    
    // Generate specs
    const specsHTML = `
        <li class="flex items-start gap-2">
            <span class="text-indigo-600 text-lg leading-none mt-0.5 flex-shrink-0">◆</span>
            <span class="text-gray-700 text-xs">${product.megapixels}MP ${product.sensor}</span>
        </li>
        <li class="flex items-start gap-2">
            <span class="text-indigo-600 text-lg leading-none mt-0.5 flex-shrink-0">◆</span>
            <span class="text-gray-700 text-xs">Professional Equipment</span>
        </li>
        <li class="flex items-start gap-2">
            <span class="text-indigo-600 text-lg leading-none mt-0.5 flex-shrink-0">◆</span>
            <span class="text-gray-700 text-xs">Verified Seller</span>
        </li>
        <li class="flex items-start gap-2">
            <span class="text-indigo-600 text-lg leading-none mt-0.5 flex-shrink-0">◆</span>
            <span class="text-gray-700 text-xs">Quality Guaranteed</span>
        </li>
    `;
    document.getElementById('productSpecs').innerHTML = specsHTML;
    
    // Create thumbnail gallery (using main image for now)
    const thumbGallery = document.getElementById('thumbnailGallery');
    thumbGallery.innerHTML = '';
    
    const thumbDiv = document.createElement('div');
    thumbDiv.className = 'modal-thumbnail active';
    const thumbImg = document.createElement('img');
    thumbImg.src = product.image_path || 'assets/images/empty.png';
    thumbImg.alt = 'Product thumbnail';
    thumbDiv.appendChild(thumbImg);
    thumbGallery.appendChild(thumbDiv);
    
    // Show modal
    const modal = document.getElementById('productModal');
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Initialize Swiper
    setTimeout(() => {
        if (modalCarousel) {
            modalCarousel.destroy();
        }
        
        modalCarousel = new Swiper('.modal-main-carousel', {
            loop: false,
            navigation: {
                nextEl: '.modal-nav-next',
                prevEl: '.modal-nav-prev',
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            }
        });
    }, 100);
}

function closeProductModal() {
    const modal = document.getElementById('productModal');
    modal.style.display = 'none';
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    
    if (modalCarousel) {
        modalCarousel.destroy();
        modalCarousel = null;
    }
}

function toggleWishlistModal() {
    if (currentModalProduct) {
        addToWishlist(currentModalProduct.listing_id);
    }
}

function addToCartModal() {
    if (currentModalProduct) {
        addToCart(currentModalProduct.listing_id);
    }
}

function goToCheckout() {
    // First add to cart, then redirect to checkout
    if (currentModalProduct) {
        // Use async/await to wait for cart addition
        (async function() {
            try {
                // Add to cart and wait for response
                const formData = new FormData();
                formData.append("listing_id", currentModalProduct.listing_id);

                const res = await fetch("core/add_cart.php", {
                    method: "POST",
                    body: formData,
                    credentials: "same-origin"
                });

                const data = await res.json();

                if (data.status === "ok") {
                    // Item added successfully, now redirect
                    window.location.href = 'checkout/checkout_user.php';
                } else {
                    Toast.error("Failed to add to cart");
                }
            } catch (error) {
                console.error("Error:", error);
                Toast.error("An error occurred");
            }
        })();
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('productModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeProductModal();
            }
        });
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeProductModal();
    }
});
</script>
