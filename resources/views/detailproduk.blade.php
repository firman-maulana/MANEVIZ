@extends('layouts.app2')

@section('content')
<style>
    /* Reset dan Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .detail-container {
        background-color: #ffffff;
        min-height: 100vh;
        font-family: 'Inter', 'Arial', sans-serif;
        padding: 20px 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Breadcrumb */
    .breadcrumb {
        margin-bottom: 20px;
        font-size: 14px;
        color: #666;
    }

    .breadcrumb a {
        color: #666;
        text-decoration: none;
        margin-right: 8px;
    }

    .breadcrumb a:hover {
        color: #000;
    }

    .breadcrumb span {
        margin: 0 8px;
        color: #999;
    }

    /* Main Product Section */
    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        margin-bottom: 60px;
    }

    /* Product Images */
    .product-images {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .main-image {
        width: 100%;
        height: 500px;
        background-color: #f5f5f5;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumbnail-images {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .thumbnail {
        flex: 0 0 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .thumbnail.active {
        border-color: #000;
    }

    .thumbnail:hover {
        border-color: #666;
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .more-images {
        flex: 0 0 80px;
        height: 80px;
        border-radius: 8px;
        background-color: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        font-size: 12px;
        color: #666;
        font-weight: 500;
    }

    .more-images:hover {
        border-color: #666;
        background-color: #ebebeb;
    }

    /* Product Info */
    .product-info {
        padding-top: 20px;
    }

    .brand-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #000;
        color: #fff;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 16px;
    }

    .brand-logo {
        width: 16px;
        height: 16px;
        background-color: #fff;
        border-radius: 50%;
    }

    .product-title {
        font-size: 32px;
        font-weight: 600;
        color: #000;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .star {
        color: #ffc107;
        font-size: 16px;
    }

    .star.empty {
        color: #e9ecef;
    }

    .rating-text {
        font-size: 14px;
        color: #666;
    }

    .product-price {
        font-size: 36px;
        font-weight: 700;
        color: #000;
        margin-bottom: 30px;
    }

    /* Product Options */
    .product-options {
        margin-bottom: 30px;
    }

    .option-group {
        margin-bottom: 24px;
    }

    .option-label {
        font-size: 16px;
        font-weight: 600;
        color: #000;
        margin-bottom: 12px;
        display: block;
    }

    .color-options {
        display: flex;
        gap: 12px;
        margin-bottom: 8px;
    }

    .color-option {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
    }

    .color-option.active {
        border-color: #000;
    }

    .color-option:hover {
        transform: scale(1.05);
    }

    .color-option.white {
        background-color: #fff;
        border: 2px solid #e9ecef;
    }

    .color-option.gray {
        background-color: #6c757d;
    }

    .color-option.black {
        background-color: #000;
    }

    .color-name {
        font-size: 14px;
        color: #666;
        margin-top: 8px;
    }

    .size-options {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .size-option {
        padding: 12px 20px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background-color: #fff;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        color: #000;
        transition: all 0.3s ease;
        min-width: 50px;
        text-align: center;
    }

    .size-option:hover {
        border-color: #000;
    }

    .size-option.active {
        background-color: #000;
        color: #fff;
        border-color: #000;
    }

    .size-guide {
        font-size: 14px;
        color: #666;
        text-decoration: underline;
        cursor: pointer;
        margin-top: 8px;
        display: inline-block;
    }

    .size-guide:hover {
        color: #000;
    }

    /* Action Buttons */
    .product-actions {
        display: flex;
        gap: 16px;
        margin-bottom: 30px;
    }

    .btn-add-cart {
        flex: 1;
        background-color: #000;
        color: #fff;
        border: none;
        padding: 16px 24px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-add-cart:hover {
        background-color: #333;
    }

    .btn-wishlist {
        width: 56px;
        height: 56px;
        border: 2px solid #e9ecef;
        background-color: #fff;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-wishlist:hover {
        border-color: #000;
        background-color: #f8f9fa;
    }

    .btn-wishlist.active {
        background-color: #000;
        border-color: #000;
        color: #fff;
    }

    /* Product Features */
    .product-features {
        border-top: 1px solid #e9ecef;
        padding-top: 20px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    .feature-icon {
        width: 20px;
        height: 20px;
        color: #666;
    }

    .feature-text {
        font-size: 14px;
        color: #666;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .product-detail {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .main-image {
            height: 400px;
        }

        .product-title {
            font-size: 24px;
        }

        .product-price {
            font-size: 28px;
        }

        .product-actions {
            flex-direction: column;
        }

        .btn-wishlist {
            width: 100%;
            height: 56px;
        }

        .size-options {
            gap: 8px;
        }

        .size-option {
            padding: 10px 16px;
            min-width: 45px;
        }
    }

    /* Loading Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-detail {
        animation: fadeInUp 0.6s ease forwards;
    }
</style>

<div class="detail-container">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span>/</span>
            <a href="{{ url('/allproduk') }}">Products</a>
            <span>/</span>
            <span>{{ $product['category'] ?? 'Product' }}</span>
            <span>/</span>
            <span>{{ $product['name'] ?? 'Product Detail' }}</span>
        </nav>

        <!-- Product Detail -->
        <div class="product-detail">
            <!-- Product Images -->
            <div class="product-images">
                <div class="main-image">
                    <img id="mainImage" src="{{ $product['main_image'] ?? 'storage/image/produk1.jpg' }}" alt="{{ $product['name'] ?? 'Product' }}">
                </div>
                
                <div class="thumbnail-images">
                    @if(isset($product['images']) && is_array($product['images']))
                        @foreach($product['images'] as $index => $image)
                            <div class="thumbnail {{ $index === 0 ? 'active' : '' }}" onclick="changeMainImage('{{ $image }}', this)">
                                <img src="{{ $image }}" alt="Product view {{ $index + 1 }}">
                            </div>
                        @endforeach
                    @else
                        <div class="thumbnail active" onclick="changeMainImage('storage/image/produk1.jpg', this)">
                            <img src="storage/image/produk1.jpg" alt="Product view 1">
                        </div>
                        <div class="thumbnail" onclick="changeMainImage('storage/image/produk2.jpg', this)">
                            <img src="storage/image/produk2.jpg" alt="Product view 2">
                        </div>
                        <div class="thumbnail" onclick="changeMainImage('storage/image/produk3.jpg', this)">
                            <img src="storage/image/produk3.jpg" alt="Product view 3">
                        </div>
                    @endif
                    @if(isset($product['total_images']) && $product['total_images'] > 4)
                        <div class="more-images">
                            +{{ $product['total_images'] - 3 }} more
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <!-- Brand Badge -->
                <div class="brand-badge">
                    <div class="brand-logo"></div>
                    {{ $product['brand'] ?? 'Brand' }}
                </div>

                <!-- Product Title -->
                <h1 class="product-title">{{ $product['name'] ?? 'Product Name' }}</h1>

                <!-- Rating -->
                <div class="product-rating">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= ($product['rating'] ?? 4) ? '' : 'empty' }}">★</span>
                        @endfor
                    </div>
                    <span class="rating-text">{{ $product['review_count'] ?? '42' }} reviews</span>
                </div>

                <!-- Price -->
                <div class="product-price">{{ $product['price'] ?? 'IDR 199,000' }}</div>

                <!-- Product Options -->
                <div class="product-options">
                    <!-- Color Selection -->
                    <div class="option-group">
                        <label class="option-label">Color <span class="color-name" id="selectedColor">{{ $product['default_color'] ?? 'White' }}</span></label>
                        <div class="color-options">
                            @if(isset($product['colors']) && is_array($product['colors']))
                                @foreach($product['colors'] as $index => $color)
                                    <div class="color-option {{ strtolower($color['name']) }} {{ $index === 0 ? 'active' : '' }}" 
                                         onclick="selectColor('{{ $color['name'] }}', this)"
                                         style="background-color: {{ $color['hex'] ?? '#fff' }}"></div>
                                @endforeach
                            @else
                                <div class="color-option white active" onclick="selectColor('White', this)"></div>
                                <div class="color-option gray" onclick="selectColor('Gray', this)"></div>
                                <div class="color-option black" onclick="selectColor('Black', this)"></div>
                            @endif
                        </div>
                    </div>

                    <!-- Size Selection -->
                    <div class="option-group">
                        <label class="option-label">Size <span style="font-weight: 400; color: #666;">EU | Men</span></label>
                        <div class="size-options">
                            @if(isset($product['sizes']) && is_array($product['sizes']))
                                @foreach($product['sizes'] as $index => $size)
                                    <div class="size-option {{ $index === 2 ? 'active' : '' }}" onclick="selectSize('{{ $size }}', this)">
                                        {{ $size }}
                                    </div>
                                @endforeach
                            @else
                                <div class="size-option" onclick="selectSize('40.5', this)">40.5</div>
                                <div class="size-option" onclick="selectSize('41', this)">41</div>
                                <div class="size-option active" onclick="selectSize('42', this)">42</div>
                                <div class="size-option" onclick="selectSize('43', this)">43</div>
                                <div class="size-option" onclick="selectSize('43.5', this)">43.5</div>
                                <div class="size-option" onclick="selectSize('44', this)">44</div>
                                <div class="size-option" onclick="selectSize('44.5', this)">44.5</div>
                                <div class="size-option" onclick="selectSize('45', this)">45</div>
                                <div class="size-option" onclick="selectSize('46', this)">46</div>
                            @endif
                        </div>
                        <a href="#" class="size-guide">Size guide</a>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="product-actions">
                    <button class="btn-add-cart" onclick="addToCart()">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="m1 1 4 4 7 14 8-14 3-3"></path>
                        </svg>
                        Add to cart
                    </button>
                    <button class="btn-wishlist" onclick="toggleWishlist(this)">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Product Features -->
                <div class="product-features">
                    <div class="feature-item">
                        <svg class="feature-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 8V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v1m18 0-2 9H5l-2-9m18 0h-4.5"></path>
                        </svg>
                        <span class="feature-text">Free delivery on orders over $30.0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Change main image when thumbnail is clicked
    function changeMainImage(imageSrc, thumbnail) {
        document.getElementById('mainImage').src = imageSrc;
        
        // Remove active class from all thumbnails
        document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
        
        // Add active class to clicked thumbnail
        thumbnail.classList.add('active');
    }

    // Select color
    function selectColor(colorName, colorElement) {
        document.getElementById('selectedColor').textContent = colorName;
        
        // Remove active class from all color options
        document.querySelectorAll('.color-option').forEach(c => c.classList.remove('active'));
        
        // Add active class to selected color
        colorElement.classList.add('active');
    }

    // Select size
    function selectSize(size, sizeElement) {
        // Remove active class from all size options
        document.querySelectorAll('.size-option').forEach(s => s.classList.remove('active'));
        
        // Add active class to selected size
        sizeElement.classList.add('active');
    }

    // Toggle wishlist
    function toggleWishlist(button) {
        button.classList.toggle('active');
    }

    // Add to cart
    function addToCart() {
        const selectedColor = document.getElementById('selectedColor').textContent;
        const selectedSize = document.querySelector('.size-option.active')?.textContent;
        
        if (!selectedSize) {
            alert('Please select a size');
            return;
        }

        // Here you can add AJAX call to add product to cart
        console.log('Adding to cart:', {
            product: '{{ $product["name"] ?? "Product" }}',
            color: selectedColor,
            size: selectedSize,
            price: '{{ $product["price"] ?? "IDR 199,000" }}'
        });

        alert('Product added to cart!');
    }

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Set default selections if needed
        console.log('Product detail page loaded');
    });
</script>
@endsection