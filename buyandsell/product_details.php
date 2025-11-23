<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gallery - Fixed Layout</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .nav-for-slider .swiper-slide {
            width: auto !important;
            cursor: pointer;
            flex-shrink: 0;
        }
        .swiper-wrapper {
            display: flex;
            align-items: center;
        }
        .nav-for-slider .swiper-slide img {
            border: 2px solid transparent;
            border-radius: 10px;
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .nav-for-slider .swiper-slide-thumb-active img {
            border-color: rgb(79 70 229);
        }
        .nav-for-slider {
            padding: 0 10px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <section class="py-12 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Product Images Section -->
                <div class="slider-box w-full h-full max-lg:mx-auto">
                    <div class="swiper main-slide-carousel swiper-container relative mb-6">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="block">
                                    <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-BLACK.jpg"
                                        alt="Summer Travel Bag image" class="w-full rounded-2xl object-cover">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="block">
                                    <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-18-55-BLK-B.jpg"
                                        alt="Summer Travel Bag image" class="w-full rounded-2xl object-cover">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="block">
                                    <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-18-55-BLK-C-600x600.jpg"
                                        alt="Summer Travel Bag image" class="w-full rounded-2xl object-cover">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="block">
                                    <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-18-55-BLK-D-600x600.jpg"
                                        alt="Summer Travel Bag image" class="w-full rounded-2xl object-cover">
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="block">
                                    <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-18-55-BLK-F-600x600.jpg"
                                        alt="Summer Travel Bag image" class="w-full rounded-2xl object-cover">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-for-slider mt-4">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide thumbs-slide">
                                <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-BLACK.jpg"
                                    alt="Summer Travel Bag image"
                                    class="cursor-pointer rounded-xl transition-all duration-500 object-cover">
                            </div>
                            <div class="swiper-slide thumbs-slide">
                                <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-18-55-BLK-B.jpg"
                                    alt="Summer Travel Bag image"
                                    class="cursor-pointer rounded-xl transition-all duration-500 border hover:border-indigo-600 object-cover">
                            </div>
                            <div class="swiper-slide thumbs-slide">
                                <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-18-55-BLK-C-600x600.jpg"
                                    alt="Summer Travel Bag image"
                                    class="cursor-pointer rounded-xl transition-all duration-500 border hover:border-indigo-600 object-cover">
                            </div>
                            <div class="swiper-slide thumbs-slide">
                                <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-18-55-BLK-D-600x600.jpg"
                                    alt="Summer Travel Bag image"
                                    class="cursor-pointer rounded-xl transition-all duration-500 border hover:border-indigo-600 object-cover">
                            </div>
                            <div class="swiper-slide thumbs-slide">
                                <img src="https://storage.googleapis.com/prg-photo-shop-bucket/2023/10/XT5-18-55-BLK-F-600x600.jpg"
                                    alt="Summer Travel Bag image"
                                    class="cursor-pointer rounded-xl transition-all duration-500 border hover:border-indigo-600 object-cover">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Details Section -->
                <div class="flex justify-center items-start">
                    <div class="pro-detail w-full lg:pl-8 xl:pl-12 max-lg:mt-8 space-y-6">
                        <!-- Product Title and Wishlist -->
                        <div class="flex items-start justify-between gap-6">
                            <div class="text">
                                <h2 class="font-bold text-3xl leading-10 text-gray-900 mb-2">FUJIFILM X-T5 Mirrorless Camera with 18-55mm Lens- Black</h2>
                                <p class="font-normal text-base text-gray-500">FUJIFILM</p>
                            </div>
                            <button class="group transition-all duration-500 p-0.5 shrink-0">
                                <svg width="60" height="60" viewBox="0 0 60 60" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle
                                        class="fill-indigo-50 transition-all duration-500 group-hover:fill-indigo-100"
                                        cx="30" cy="30" r="30" fill="" />
                                    <path
                                        class="stroke-indigo-600 transition-all duration-500 group-hover:stroke-indigo-700"
                                        d="M21.4709 31.3196L30.0282 39.7501L38.96 30.9506M30.0035 22.0789C32.4787 19.6404 36.5008 19.6404 38.976 22.0789C41.4512 24.5254 41.4512 28.4799 38.9842 30.9265M29.9956 22.0789C27.5205 19.6404 23.4983 19.6404 21.0231 22.0789C18.548 24.5174 18.548 28.4799 21.0231 30.9184M21.0231 30.9184L21.0441 30.939M21.0231 30.9184L21.4628 31.3115"
                                        stroke="" stroke-width="1.6" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        <!-- Price and Rating -->
                        <div class="flex flex-col min-[400px]:flex-row min-[400px]:items-center gap-y-3">
                            <div class="flex items-center">
                                <h5 class="font-semibold text-2xl leading-9 text-gray-900">₱134,990.00</h5>
                                <span class="ml-3 font-semibold text-lg text-indigo-600">30% off</span>
                            </div>
                            <svg class="mx-5 max-[400px]:hidden" xmlns="http://www.w3.org/2000/svg" width="2"
                                height="36" viewBox="0 0 2 36" fill="none">
                                <path d="M1 0V36" stroke="#E5E7EB" />
                            </svg>
                            <button class="flex items-center gap-1 rounded-lg bg-amber-400 py-1.5 px-2.5 w-max">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_12657_16865)">
                                        <path
                                            d="M8.10326 2.26718C8.47008 1.52393 9.52992 1.52394 9.89674 2.26718L11.4124 5.33818C11.558 5.63332 11.8396 5.83789 12.1653 5.88522L15.5543 6.37768C16.3746 6.49686 16.7021 7.50483 16.1086 8.08337L13.6562 10.4738C13.4205 10.7035 13.313 11.0345 13.3686 11.3589L13.9475 14.7343C14.0877 15.5512 13.2302 16.1742 12.4966 15.7885L9.46534 14.1948C9.17402 14.0417 8.82598 14.0417 8.53466 14.1948L5.5034 15.7885C4.76978 16.1742 3.91235 15.5512 4.05246 14.7343L4.63137 11.3589C4.68701 11.0345 4.57946 10.7035 4.34378 10.4738L1.89144 8.08337C1.29792 7.50483 1.62543 6.49686 2.44565 6.37768L5.8347 5.88522C6.16041 5.83789 6.44197 5.63332 6.58764 5.33818L8.10326 2.26718Z"
                                            fill="white" />
                                        <g clip-path="url(#clip1_12657_16865)">
                                            <path
                                                d="M8.10326 2.26718C8.47008 1.52393 9.52992 1.52394 9.89674 2.26718L11.4124 5.33818C11.558 5.63332 11.8396 5.83789 12.1653 5.88522L15.5543 6.37768C16.3746 6.49686 16.7021 7.50483 16.1086 8.08337L13.6562 10.4738C13.4205 10.7035 13.313 11.0345 13.3686 11.3589L13.9475 14.7343C14.0877 15.5512 13.2302 16.1742 12.4966 15.7885L9.46534 14.1948C9.17402 14.0417 8.82598 14.0417 8.53466 14.1948L5.5034 15.7885C4.76978 16.1742 3.91235 15.5512 4.05246 14.7343L4.63137 11.3589C4.68701 11.0345 4.57946 10.7035 4.34378 10.4738L1.89144 8.08337C1.29792 7.50483 1.62543 6.49686 2.44565 6.37768L5.8347 5.88522C6.16041 5.83789 6.44197 5.63332 6.58764 5.33818L8.10326 2.26718Z"
                                                fill="white" />
                                        </g>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_12657_16865">
                                            <rect width="18" height="18" fill="white" />
                                        </clipPath>
                                        <clipPath id="clip1_12657_16865">
                                            <rect width="18" height="18" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <span class="text-base font-medium text-white">4.8</span>
                            </button>
                        </div>
                        
                        <!-- Specifications Section -->
                        <div class="specifications">
                            <h3 class="font-medium text-lg text-gray-900 mb-3">Product Highlights</h3>
                            <ul class="space-y-2">
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">Available in Black or Silver</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">40MP APS-C X-Trans CMOS 5 HR BSI Sensor</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">4K 120p, 6.2K 30p, FHD 240p 10-Bit Video</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">7-Stop In-Body Image Stabilization</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">425-Point Intelligent Hybrid AF System</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">3.69m-Dot OLED Electronic Viewfinder</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">3" 1.84m-Dot Tilting Touchscreen LCD</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">20 fps E. Shutter, 15 fps Mech. Shutter</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">160MP Pixel Shift Multi-Shot</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">Bluetooth and Wi-Fi Connectivity</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-indigo-600 mr-2">•</span>
                                    <span class="font-normal text-base text-gray-700">ProRes & Blackmagic RAW via HDMI</span>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Add to Cart Button -->
                        <button
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
                        
                        <!-- Buy Now Button -->
                        <button
                            class="text-center w-full px-5 py-4 rounded-[100px] bg-indigo-600 flex items-center justify-center font-semibold text-lg text-white shadow-sm shadow-transparent transition-all duration-500 hover:bg-indigo-700 hover:shadow-indigo-300">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Initialize Swiper after DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize thumbnail slider
            var swiper_thumbs = new Swiper(".nav-for-slider", {
                loop: false,
                spaceBetween: 10,
                slidesPerView: 'auto',
                freeMode: true,
                watchSlidesProgress: true,
                centeredSlides: false,
                slideToClickedSlide: true
            });
            
            // Initialize main slider with thumbs
            var swiper = new Swiper(".main-slide-carousel", {
                loop: false,
                spaceBetween: 10,
                thumbs: {
                    swiper: swiper_thumbs,
                },
            });
            
            // Add click event to thumbnail images
            document.querySelectorAll('.nav-for-slider .swiper-slide').forEach((slide, index) => {
                slide.addEventListener('click', function() {
                    swiper.slideTo(index);
                });
            });
        });
    </script>
</body>
</html>