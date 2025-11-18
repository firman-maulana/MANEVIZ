@extends('layouts.app')

@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Base responsive container */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Hero Section */
    .hero {
        height: 100vh;
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('image/bannerfiks.jpeg');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        padding-left: 80px;
    }

    .hero-content {
        max-width: 600px;
        color: white;
        z-index: 2;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 20px;
        letter-spacing: -2px;
        margin-left: -30px;
    }

    .hero-content .highlight {
        color: #ffffff;
        font-weight: 900;
    }

    /* style back - Carousel Container */
    .styleback {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-left: 20px;
        padding-right: 20px;
        position: relative;
    }

    /* Carousel Wrapper */
    .carousel-wrapper {
        position: relative;
        width: 100%;
        overflow: hidden;
        margin-top: 63px;
        max-height: 400px;
    }

    .carousel-container {
        display: flex;
        transition: transform 0.5s ease-in-out;
        width: 100%;
    }

    .carousel-slide {
        min-width: 100%;
        flex-shrink: 0;
        padding: 0 20px;
    }

    .carousel-slide img {
        width: 100%;
        height: 400px;
        display: block;
        border-radius: 10px;
        object-fit: cover;
        object-position: center;
    }

    /* Carousel Navigation Buttons */
    .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.2);
        width: 48px;
        height: 48px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 10;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        opacity: 0.8;
    }

    .carousel-nav:hover {
        background: rgba(0, 0, 0, 0.8);
        border-color: rgba(255, 255, 255, 0.4);
        opacity: 1;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.4);
    }

    .carousel-nav:active {
        transform: translateY(-50%) scale(0.95);
    }

    .carousel-nav.prev {
        left: 20px;
    }

    .carousel-nav.next {
        right: 20px;
    }

    .carousel-nav svg {
        width: 20px;
        height: 20px;
        color: #ffffff;
        stroke-width: 2.5;
    }

    .carousel-nav.prev:hover svg {
        transform: translateX(-2px);
    }

    .carousel-nav.next:hover svg {
        transform: translateX(2px);
    }

    /* Carousel Indicators (Dots) */
    .carousel-indicators {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
        padding: 0 20px;
    }

    .carousel-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.2);
        border: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0;
    }

    .carousel-dot:hover {
        background: rgba(0, 0, 0, 0.4);
        transform: scale(1.2);
    }

    .carousel-dot.active {
        background: #000;
        width: 32px;
        border-radius: 4px;
    }

    .fashion {
        margin-top: 25px;
        color: black;
        text-align: left;
        padding-left: 20px;
        font-weight: 500;
    }

    .styleback h3 {
        color: black;
        text-align: left;
        padding-left: 20px;
        font-weight: 600;
    }

    .styleback hr {
        width: 97%;
        height: 2px;
        background-color: #B9ACAA;
        margin: 20px auto;
    }

    .latest h2 {
        color: black;
        text-align: left;
        padding-left: 20px;
        font-weight: 600;
        margin-bottom: 30px;
        margin-top: 13px;
    }

    .mostculture h2 {
        color: black;
        text-align: left;
        padding-left: 20px;
        font-weight: 600;
    }

    /* Product Grid Horizontal Scroll - Desktop Default */
    .product-grid-horizontal {
        display: flex;
        gap: 70px;
        overflow-x: auto;
        padding: 20px;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 40px;
    }

    .product-grid-horizontal::-webkit-scrollbar {
        height: 8px;
    }

    .product-grid-horizontal::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }

    /* Product card - Desktop default */
    .product-card {
        flex: 0 0 auto;
        width: 265px;
        height: 350px;
        background-color: transparent;
        border-radius: 20px;
        overflow: visible;
        cursor: pointer;
        border: none;
        position: relative;
        text-decoration: none;
        display: block;
        scroll-snap-align: start;
    }

    .product-image {
        width: 100%;
        height: 350px;
        background-color: #f8f9fa;
        display: block;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        border-radius: 20px;
    }

    .product-image img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: center !important;
        border-radius: 20px;
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
        max-width: none !important;
        max-height: none !important;
        min-width: 100% !important;
        min-height: 100% !important;
    }

    .product-info {
        position: absolute;
        bottom: 15px;
        left: 15px;
        right: 15px;
        padding: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transform: translateY(0);
    }

    .product-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .product-details {
        flex: 1;
    }

    .product-info h4 {
        color: #000;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 3px;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .product-info p {
        color: #666;
        font-size: 12px;
        font-weight: 500;
        margin: 0;
    }

    .product-arrow {
        background: rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-left: 8px;
        flex-shrink: 0;
    }

    .product-arrow svg {
        width: 12px;
        height: 12px;
        color: #333;
    }

    /* Badges - Desktop default */
    .sale-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        z-index: 2;
        text-transform: uppercase;
    }

    .bestseller-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #3698d9;
        color: #000;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        z-index: 2;
        text-transform: uppercase;
    }

    /* Product pricing with original price */
    .product-pricing {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .product-price-original {
        color: #999;
        font-size: 8px;
        font-weight: 400;
        text-decoration: line-through;
    }

    .product-name {
        color: #000;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 3px;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Sales count */
    .product-sales {
        color: #28a745;
        font-size: 10px;
        font-weight: 500;
        margin: 2px 0 0 0;
    }

    /* Rating stars */
    .product-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 3px;
    }

    .rating-stars {
        color: #ffc107;
        font-size: 12px;
        line-height: 1;
    }

    .rating-value {
        color: #666;
        font-size: 10px;
        font-weight: 400;
    }

    .color-info {
        font-size: 14px !important;
        color: #95a5a6 !important;
        margin-bottom: 12px !important;
        font-weight: 400 !important;
    }

    .price {
        color: #dc3545 !important;
        font-weight: 700 !important;
        font-size: 15px !important;
        margin-top: 8px !important;
        letter-spacing: -0.5px;
    }

    /* Banner */
    .banner2 {
        margin-bottom: 80px;
        max-width: 100%;
        height: auto;
        margin-top: 40px;
        padding: 0 20px;
    }

    /* Placeholder untuk gambar */
    .placeholder-image {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 14px;
        text-align: center;
        border-radius: 20px;
        font-weight: 500;
        object-fit: cover;
    }

    /* No products message */
    .no-products {
        text-align: center;
        padding: 40px 20px;
        color: #666;
    }

    .no-products h3 {
        margin-bottom: 15px;
        color: #333;
    }

    .no-products p {
        font-size: 14px;
    }

    /* Mobile Responsive - 2 cards per row */
    @media (max-width: 768px) {
        .hero {
            padding-left: 20px;
            height: 60vh;
            min-height: 400px;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            margin-left: 0;
        }

        .styleback {
            padding-left: 15px;
            padding-right: 15px;
        }

        .carousel-wrapper {
            margin-top: 40px;
            max-height: 250px;
        }

        .carousel-slide img {
            height: 250px;
        }

        .carousel-slide {
            padding: 0 15px;
        }

        .carousel-nav {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.6);
        }

        .carousel-nav svg {
            width: 18px;
            height: 18px;
        }

        .carousel-nav.prev {
            left: 10px;
        }

        .carousel-nav.next {
            right: 10px;
        }

        .carousel-indicators {
            padding: 0 15px;
        }

        .fashion {
            padding-left: 15px;
        }

        .styleback h3 {
            padding-left: 15px;
        }

        .latest h2,
        .mostculture h2 {
            padding-left: 15px;
        }

        .product-grid-horizontal {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            overflow: visible;
            padding: 0;
        }

        .product-card {
            width: 100%;
            height: auto;
            aspect-ratio: 3/4;
        }

        .product-image {
            height: 100%;
        }

        .product-info {
            bottom: 8px;
            left: 8px;
            right: 8px;
            padding: 8px;
        }

        .product-info h4 {
            font-size: 12px;
        }

        .product-info p {
            font-size: 10px;
        }

        .product-arrow {
            width: 24px;
            height: 24px;
        }

        .sale-badge,
        .bestseller-badge {
            top: 8px;
            padding: 3px 6px;
            font-size: 9px;
        }

        .sale-badge {
            left: 8px;
        }

        .bestseller-badge {
            right: 8px;
        }

        .product-name {
            font-size: 12px;
        }

        .product-price-original {
            font-size: 9px;
        }

        .product-sales {
            font-size: 9px;
        }

        .rating-stars {
            font-size: 10px;
        }

        .rating-value {
            font-size: 9px;
        }

        .no-products {
            grid-column: 1 / -1;
        }

        .banner2 {
            padding: 0 15px;
        }
    }

    @media (max-width: 480px) {
        .hero-content h1 {
            font-size: 2rem;
        }

        .product-grid-horizontal {
            gap: 12px;
        }

        .product-info {
            bottom: 6px;
            left: 6px;
            right: 6px;
            padding: 6px;
        }

        .product-info h4 {
            font-size: 11px;
        }

        .product-info p {
            font-size: 9px;
        }

        .product-arrow {
            width: 20px;
            height: 20px;
        }

        .product-arrow svg {
            width: 8px;
            height: 8px;
        }

        .sale-badge,
        .bestseller-badge {
            top: 6px;
            padding: 2px 5px;
            font-size: 8px;
        }

        .carousel-nav {
            width: 36px;
            height: 36px;
            background: rgba(0, 0, 0, 0.6);
        }

        .carousel-nav svg {
            width: 16px;
            height: 16px;
        }

        .carousel-nav.prev {
            left: 8px;
        }

        .carousel-nav.next {
            right: 8px;
        }

        .carousel-wrapper {
            max-height: 200px;
        }

        .carousel-slide img {
            height: 200px;
        }
    }


    /* ============================================
   BERANDA.BLADE.PHP - DISCOUNT STYLES
   ============================================ */

    /* Discount Badge with Pulse Animation */
    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .sale-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #dc3545;
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        z-index: 2;
        text-transform: uppercase;
    }

    /* Enhanced gradient badge for active discounts */
    .sale-badge[style*="gradient"] {
        animation: pulse 2s infinite;
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
    }

    /* Product Pricing with Discount */
    .product-pricing {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .product-price-original {
        color: #999;
        font-size: 8px;
        font-weight: 400;
        text-decoration: line-through;
    }

    .product-price {
        color: #666 !important;
        font-weight: 400 !important;
        font-size: 12px;
    }

    /* Discounted price styling */
    .product-price[style*="dc3545"] {
        color: #dc3545 !important;
        font-weight: 600 !important;
    }

    /* Savings Display */
    .product-savings {
        color: #28a745;
        font-size: 10px;
        font-weight: 500;
        margin: 2px 0 0 0;
    }

    /* Mobile Responsive - Beranda */
    @media (max-width: 768px) {
        .sale-badge {
            top: 8px;
            left: 8px;
            padding: 3px 6px;
            font-size: 9px;
        }

        .product-price-original {
            font-size: 9px;
        }

        .product-savings {
            font-size: 9px;
        }
    }

    @media (max-width: 480px) {
        .sale-badge {
            top: 6px;
            left: 6px;
            padding: 2px 5px;
            font-size: 8px;
        }

        .product-price-original {
            font-size: 8px;
        }

        .product-savings {
            font-size: 8px;
        }
    }


    /* Compact Timer Styles for Product Cards */
    .product-card .discount-timer-container {
        margin-top: 6px;
        padding: 6px 8px;
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
        border: 1px solid #ffc107;
        border-radius: 6px;
    }

    .product-card .discount-timer-display {
        gap: 6px;
    }

    .product-card .timer-icon {
        width: 14px;
        height: 14px;
    }

    .product-card .timer-label {
        font-size: 8px;
        margin-bottom: 3px;
    }

    .product-card .timer-countdown {
        gap: 2px;
    }

    .product-card .time-block {
        padding: 2px 4px;
        min-width: 24px;
    }

    .product-card .time-value {
        font-size: 11px;
    }

    .product-card .time-unit {
        font-size: 6px;
        margin-top: 1px;
    }

    .product-card .time-separator {
        font-size: 11px;
    }

    /* Hide timer on very small cards */
    @media (max-width: 480px) {
        .product-card .timer-label {
            display: none;
        }

        .product-card .time-unit {
            font-size: 5px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="hero-content">
        <h1>
            Built For The<br>
            <span class="highlight">Grind</span>, Styled By<br>
            <span class="highlight">Chaos</span>
        </h1>
    </div>
</section>

<!-- styleback with Carousel -->
<section class="styleback">
    <!-- Carousel Wrapper -->
    <div class="carousel-wrapper">
        <div class="carousel-container" id="carouselContainer">
            <!-- Slide 1 -->
            <div class="carousel-slide">
                <img src="image/styleback.png" alt="Style Back Image 1">
            </div>
            <!-- Slide 2 - Add more images as needed -->
            <div class="carousel-slide">
                <img src="image/styleback.png" alt="Style Back Image 2">
            </div>
            <!-- Slide 3 -->
            <div class="carousel-slide">
                <img src="image/styleback.png" alt="Style Back Image 3">
            </div>
        </div>

        <!-- Navigation Buttons -->
        <button class="carousel-nav prev" id="prevBtn" aria-label="Previous slide">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </button>
        <button class="carousel-nav next" id="nextBtn" aria-label="Next slide">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 18l6-6-6-6" />
            </svg>
        </button>
    </div>

    <!-- Carousel Indicators (Dots) -->
    <div class="carousel-indicators" id="carouselIndicators">
        <!-- Dots will be generated by JavaScript -->
    </div>

    <div class="fashion">
        <h4>Fashion</h4>
    </div>
    <h3>Built for The Grind, Styled by Chaos</h3>
    <hr>

    <div class="latest">
        <h2>The Latest</h2>
    </div>

    <div class="container">
        <div class="product-grid-horizontal">
            @if($latestProducts->count() > 0)
            @foreach($latestProducts as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                <div class="product-image">
                    @if($product->primaryImage)
                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                        alt="{{ $product->primaryImage->alt_text ?: $product->name }}">
                    @elseif($product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                        alt="{{ $product->name }}">
                    @else
                    <img src="{{ asset('images/no-image.png') }}"
                        onerror="this.onerror=null;this.src='https://via.placeholder.com/300x300?text=No+Image';"
                        alt="No Image">
                    @endif

                    <!-- 🔥 NEW: Discount Badge (replaces or combines with sale badge) -->
                    @if($product->hasActiveDiscount())
                    <div class="sale-badge" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); animation: pulse 2s infinite;">
                        {{ $product->getDiscountLabel() }}
                    </div>
                    @elseif($product->is_on_sale)
                    <div class="sale-badge">Sale</div>
                    @endif

                    <!-- Just In Badge for latest products -->
                    <div class="bestseller-badge">Just In</div>
                </div>
                <div class="product-info">
                    <div class="product-content">
                        <div class="product-details">
                            <h4 class="product-name">{{ $product->name }}</h4>
                            <div class="product-pricing">
                                @if($product->hasActiveDiscount() || $product->is_on_sale)
                                <!-- Show original price struck through -->
                                <span class="product-price-original">
                                    IDR {{ number_format($product->getOriginalPrice(), 0, ',', '.') }}
                                </span>
                                <!-- Show discounted price in red -->
                                <span class="product-price" style="color: #dc3545 !important; font-weight: 600 !important;">
                                    IDR {{ number_format($product->final_price, 0, ',', '.') }}
                                </span>
                                @if($product->hasActiveDiscount())
                                <span class="product-savings" style="color: #28a745; font-size: 9px; font-weight: 500;">
                                    Save IDR {{ number_format($product->getDiscountAmount(), 0, ',', '.') }}
                                </span>
                                @endif
                                @else
                                <span class="product-price" style="color: #666 !important; font-weight: 400 !important;">
                                    IDR {{ number_format($product->final_price, 0, ',', '.') }}
                                </span>
                                @endif
                            </div>

                            @if($product->hasActiveDiscount() && $product->discount_end_date)
                            <div style="margin-top: 6px; font-size: 10px;">
                                <x-discount-timer :product="$product" />
                            </div>
                            @endif

                            <!-- Sales count (if available) -->
                            @if($product->total_penjualan > 0)
                            <p class="product-sales">{{ $product->total_penjualan }} sold</p>
                            @endif

                            <!-- Rating (if available) -->
                            @if($product->rating_rata > 0)
                            <div class="product-rating">
                                <span class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <=floor($product->rating_rata))
                                        ★
                                        @elseif($i - 0.5 <= $product->rating_rata)
                                            ☆
                                            @else
                                            ☆
                                            @endif
                                            @endfor
                                </span>
                                <span class="rating-value">({{ number_format($product->rating_rata, 1) }})</span>
                            </div>
                            @endif
                        </div>
                        <div class="product-arrow">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14m-7-7 7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            @else
            <div class="no-products">
                <h3>No Latest Products</h3>
                <p>There are no products available at the moment. Check back later!</p>
            </div>
            @endif
        </div>
    </div>

    <div class="mostculture">
        <h2>Most Culture</h2>
    </div>
    <img src="image/banner.png" class="banner2" alt="Banner Image">
</section>

<!-- Timeless Choice -->
<section class="timeless">

</section>

<script>
    // Carousel functionality
    (function() {
        const carouselContainer = document.getElementById('carouselContainer');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const indicatorsContainer = document.getElementById('carouselIndicators');

        const slides = carouselContainer.querySelectorAll('.carousel-slide');
        const totalSlides = slides.length;
        let currentSlide = 0;
        let autoPlayInterval;

        // Create indicators (dots)
        function createIndicators() {
            for (let i = 0; i < totalSlides; i++) {
                const dot = document.createElement('button');
                dot.classList.add('carousel-dot');
                dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => goToSlide(i));
                indicatorsContainer.appendChild(dot);
            }
        }

        // Update slide position
        function updateSlidePosition() {
            const offset = -currentSlide * 100;
            carouselContainer.style.transform = `translateX(${offset}%)`;

            // Update indicators
            const dots = indicatorsContainer.querySelectorAll('.carousel-dot');
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        // Go to specific slide
        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            updateSlidePosition();
            resetAutoPlay();
        }

        // Next slide
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlidePosition();
        }

        // Previous slide
        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlidePosition();
        }

        // Auto play
        function startAutoPlay() {
            autoPlayInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
        }

        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }

        function resetAutoPlay() {
            stopAutoPlay();
            startAutoPlay();
        }

        // Event listeners
        prevBtn.addEventListener('click', () => {
            prevSlide();
            resetAutoPlay();
        });

        nextBtn.addEventListener('click', () => {
            nextSlide();
            resetAutoPlay();
        });

        // Touch/swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        carouselContainer.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            stopAutoPlay();
        });

        carouselContainer.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            startAutoPlay();
        });

        function handleSwipe() {
            const swipeThreshold = 50;
            if (touchStartX - touchEndX > swipeThreshold) {
                nextSlide();
            } else if (touchEndX - touchStartX > swipeThreshold) {
                prevSlide();
            }
        }

        // Pause autoplay on hover (desktop)
        carouselContainer.addEventListener('mouseenter', stopAutoPlay);
        carouselContainer.addEventListener('mouseleave', startAutoPlay);

        // Initialize
        createIndicators();
        startAutoPlay();
    })();

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (navbar && window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else if (navbar) {
            navbar.classList.remove('scrolled');
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Product card click handler (optional - cards already have proper links)
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function(e) {
            // Let the default link behavior handle navigation
            console.log('Product clicked:', this.querySelector('h4').textContent);
        });
    });
</script>
@endsection