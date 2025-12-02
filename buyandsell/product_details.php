<!-- Product Details Modal -->
<div id="productModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white rounded-lg max-w-5xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Close Button -->
        <div class="sticky top-0 bg-white border-b flex justify-end p-4">
            <button onclick="closeProductModal()" class="text-gray-500 hover:text-gray-700 text-2xl">✕</button>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images Section -->
                <div class="slider-box w-full h-full max-lg:mx-auto">
                    <div class="swiper main-slide-carousel swiper-container relative mb-6">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="block">
                                    <img id="mainImage" src="" alt="Product image" class="w-full rounded-2xl object-cover">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-for-slider mt-4" id="thumbnailContainer">
                        <div class="swiper-wrapper"></div>
                    </div>
                </div>
                
                <!-- Product Details Section -->
                <div class="flex justify-center items-start">
                    <div class="pro-detail w-full space-y-6">
                        <!-- Product Title and Wishlist -->
                        <div class="flex items-start justify-between gap-6">
                            <div class="text">
                                <h2 id="productTitle" class="font-bold text-3xl leading-10 text-gray-900 mb-2"></h2>
                                <p id="productBrand" class="font-normal text-base text-gray-500"></p>
                            </div>
                            <button onclick="toggleWishlistModal()" class="group transition-all duration-500 p-0.5 shrink-0">
                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle class="fill-indigo-50 transition-all duration-500 group-hover:fill-indigo-100"
                                        cx="30" cy="30" r="30" fill="" />
                                    <path class="stroke-indigo-600 transition-all duration-500 group-hover:stroke-indigo-700"
                                        d="M21.4709 31.3196L30.0282 39.7501L38.96 30.9506M30.0035 22.0789C32.4787 19.6404 36.5008 19.6404 38.976 22.0789C41.4512 24.5254 41.4512 28.4799 38.9842 30.9265M29.9956 22.0789C27.5205 19.6404 23.4983 19.6404 21.0231 22.0789C18.548 24.5174 18.548 28.4799 21.0231 30.9184M21.0231 30.9184L21.0441 30.939M21.0231 30.9184L21.4628 31.3115"
                                        stroke="" stroke-width="1.6" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        <!-- Price and Rating -->
                        <div class="flex flex-col min-[400px]:flex-row min-[400px]:items-center gap-y-3">
                            <div class="flex items-center">
                                <h5 id="productPrice" class="font-semibold text-2xl leading-9 text-gray-900">₱0.00</h5>
                                <span id="discount" class="ml-3 font-semibold text-lg text-indigo-600"></span>
                            </div>
                        </div>
                        
                        <!-- Specifications Section -->
                        <div class="specifications">
                            <h3 class="font-medium text-lg text-gray-900 mb-3">Product Details</h3>
                            <ul id="productSpecs" class="space-y-2">
                            </ul>
                        </div>
                        
                        <!-- Add to Cart Button -->
                        <button onclick="addToCartModal()"
                            class="group py-4 px-5 rounded-full bg-indigo-50 text-indigo-600 font-semibold text-lg w-full flex items-center justify-center gap-2 shadow-sm shadow-transparent transition-all duration-500 hover:shadow-indigo-300 hover:bg-indigo-100">
                            <svg class="stroke-indigo-600 transition-all duration-500 group-hover:stroke-indigo-600"
                                width="22" height="22" viewBox="0 0 22 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.7394 17.875C10.7394 18.6344 10.1062 19.25 9.32511 19.25C8.54402 19.25 7.91083 18.6344 7.91083 17.875M16.3965 17.875C16.3965 18.6344 15.7633 19.25 14.9823 19.25C14.2012 19.25 13.568 18.6344 13.568 17.875M4.1394 5.5L5.46568 12.5908C5.73339 14.0221 5.86724 14.7377 6.37649 15.1605C6.88573 15.5833 7.61377 15.5833 9.06984 15.5833H15.2379C16.6941 15.5833 17.4222 15.5833 17.9314 15.1605C18.4407 14.7376 18.5745 14.0219 18.8421 12.5906L19.3564 9.84059C19.7324 7.82973 19.9203 6.8243 19.3705 6.16215C18.8207 5.5 17.7979 5.5 15.7522 5.5H4.1394ZM4.1394 5.5L3.66797 2.75"
                                    stroke="" stroke-width="1.6" stroke-linecap="round" />
                            </svg>
                            Add to cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
let currentModalProduct = null;

function openProductModal(product) {
    currentModalProduct = product;
    
    // Update product details
    document.getElementById('productTitle').textContent = `${product.brand} ${product.model}`;
    document.getElementById('productBrand').textContent = product.brand;
    document.getElementById('productPrice').textContent = `₱${parseFloat(product.selling_price).toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    
    // Set main image
    document.getElementById('mainImage').src = product.image_path || 'assets/images/empty.png';
    
    // Generate specs
    const specsHTML = `
        <li class="flex items-start">
            <span class="text-indigo-600 mr-2">•</span>
            <span class="font-normal text-base text-gray-700">${product.megapixels}MP Sensor</span>
        </li>
        <li class="flex items-start">
            <span class="text-indigo-600 mr-2">•</span>
            <span class="font-normal text-base text-gray-700">${product.sensor}</span>
        </li>
        <li class="flex items-start">
            <span class="text-indigo-600 mr-2">•</span>
            <span class="font-normal text-base text-gray-700">Condition: ${product.condition}</span>
        </li>
        <li class="flex items-start">
            <span class="text-indigo-600 mr-2">•</span>
            <span class="font-normal text-base text-gray-700">${product.description}</span>
        </li>
    `;
    document.getElementById('productSpecs').innerHTML = specsHTML;
    
    // Show modal
    const modal = document.getElementById('productModal');
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeProductModal() {
    const modal = document.getElementById('productModal');
    modal.style.display = 'none';
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
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

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('productModal');
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeProductModal();
        }
    });
});
</script>