@extends('layouts.app')

@section('content')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* style back */
        .styleback {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-left: 20px;
            padding-right: 20px;
        }

        .styleback img {
            max-width: 100%;
            height: auto;
            margin-top: 63px;
            padding: 0 20px;
        }

        .styleback h4 {
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

        /* timeless */
        .timeless {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding-left: 20px;
            padding-right: 20px;
        }

        .styleback h2 {
            color: black;
            text-align: left;
            padding-left: 20px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Product Grid Horizontal Scroll - Updated to match allProduk design */
        .product-grid-horizontal {
            display: flex;
            gap: 60px;
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

        /* Updated product card to match allProduk.blade design */
        .product-card {
            flex: 0 0 auto;
            width: 280px;
            background-color: transparent;
            border-radius: 20px;
            overflow: visible;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            position: relative;
            text-decoration: none;
            display: block;
            scroll-snap-align: start;
        }

        .product-card:hover {
            transform: translateY(-5px);
            text-decoration: none;
        }

        .product-image {
            width: 100%;
            height: 350px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            border-radius: 20px;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.3s ease;
            border-radius: 20px;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
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
            transition: all 0.3s ease;
        }

        .product-card:hover .product-info {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
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
            transition: all 0.3s ease;
            margin-left: 8px;
            flex-shrink: 0;
        }

        .product-arrow:hover {
            background: rgba(0, 0, 0, 0.1);
            transform: translateX(3px);
        }

        .product-arrow svg {
            width: 12px;
            height: 12px;
            color: #333;
        }

        /* Remove old product card styles that are no longer used */
        .product-card-latest {
            display: none;
        }

        .product-bg {
            display: none;
        }

        .product-info-latest {
            display: none;
        }

        .arrow-btn {
            display: none;
        }

        /* Old styles kept for backward compatibility but hidden */
        .product-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 10;
        }

        .product-badge.bestseller {
            background: #ff6b35;
            color: white;
        }

        .product-badge.sustainable {
            background: #2ecc71;
            color: white;
        }

        .product-badge.just-in {
            background: #3498db;
            color: white;
        }

        .color-info {
            font-size: 14px !important;
            color: #95a5a6 !important;
            margin-bottom: 12px !important;
            font-weight: 400 !important;
        }

        .price {
            color: #27ae60 !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            margin-top: 8px !important;
            letter-spacing: -0.5px;
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
            border-radius: 10px;
            font-weight: 500;
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
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            letter-spacing: -2px;
            margin-left: -30px;
        }

        .hero-content .highlight {
            color: #ffffff;
            font-weight: 900;
        }

        /* Banner */
        .banner2 {
            margin-bottom: 80px;
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

        /* Badges */
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
            background-color: #ffc107;
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
            font-size: 10px;
            font-weight: 400;
            text-decoration: line-through;
            margin: 0;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-grid-horizontal {
                gap: 20px;
                padding: 15px;
            }
            
            .product-card {
                width: 240px;
            }
            
            .product-image {
                height: 280px;
            }
            
            .product-info {
                bottom: 10px;
                left: 10px;
                right: 10px;
                padding: 8px;
            }
            
            .product-info h4 {
                font-size: 13px;
            }
            
            .product-info p {
                font-size: 11px;
            }
            
            .product-arrow {
                width: 26px;
                height: 26px;
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
                font-size: 13px;
            }

            .product-price-original {
                font-size: 9px;
            }

            .product-sales {
                font-size: 9px;
            }

            .rating-stars {
                font-size: 11px;
            }

            .rating-value {
                font-size: 9px;
            }
        }

        @media (max-width: 576px) {
            .product-card {
                width: 220px;
            }
            
            .product-image {
                height: 240px;
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
                top: 6px;
                padding: 2px 5px;
                font-size: 8px;
            }

            .sale-badge {
                left: 6px;
            }

            .bestseller-badge {
                right: 6px;
            }

            .product-name {
                font-size: 12px;
            }

            .product-price-original {
                font-size: 8px;
            }

            .product-sales {
                font-size: 8px;
            }

            .rating-stars {
                font-size: 10px;
            }

            .rating-value {
                font-size: 8px;
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

    <!-- styleback -->
    <section class="styleback">
        <img src="image/styleback.png">
        <h4>Fashion</h4>
        <h3>Built for The Grind, Styled by Chaos</h3>
        <hr>

        <h2>The Latest</h2>

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

                                <!-- Sale Badge (if product is on sale) -->
                                @if($product->is_on_sale)
                                    <div class="sale-badge">
                                        Sale
                                    </div>
                                @endif

                                <!-- Just In Badge for latest products -->
                                <div class="bestseller-badge" style="background-color: #3498db;">
                                    Just In
                                </div>
                            </div>
                            <div class="product-info">
                                <div class="product-content">
                                    <div class="product-details">
                                        <h4 class="product-name">{{ $product->name }}</h4>
                                        <div class="product-pricing">
                                            @if($product->is_on_sale)
                                                <span class="product-price-original">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
                                                <span class="product-price">IDR {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                                            @else
                                                <span class="product-price">IDR {{ number_format($product->final_price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>

                                        <!-- Sales count (if available) -->
                                        @if($product->total_penjualan > 0)
                                            <p class="product-sales">{{ $product->total_penjualan }} sold</p>
                                        @endif

                                        <!-- Rating (if available) -->
                                        @if($product->rating_rata > 0)
                                            <div class="product-rating">
                                                <span class="rating-stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($product->rating_rata))
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

        <h2>Most Culture</h2>
        <img src="image/banner.png" class="banner2">
    </section>

    <!-- Timeless Choice -->
    <section class="timeless">

    </section>

    <script>
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