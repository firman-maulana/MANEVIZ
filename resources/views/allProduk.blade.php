@extends('layouts.app2')

@section('content')
<style>
    /* Reset dan Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .allproduk-container {
        background-color: #ffffff;
        color: #fff;
        min-height: 100vh;
        font-family: 'Arial', sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Hero Section */
    .hero-section {
        padding: 80px 0;
        text-align: center;
    }

    .hero-title {
        font-size: 3.5rem;
        color: #000000;
        font-weight: bold;
        margin-bottom: 20px;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 3rem;
        color: #000000;
        font-weight: bold;
        margin-bottom: 40px;
        line-height: 1.2;
    }

    .btn-primary {
        background-color: #000000;
        color: #ffffff;
        padding: 15px 40px;
        border: none;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #333333;
        transform: translateY(-2px);
    }

    /* Section Styles */
    .section {
        padding: 60px 0;
    }

    .section-title {
        font-size: 2rem;
        color: #000000;
        font-weight: bold;
        margin-bottom: 40px;
    }

    /* Best Seller Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .product-card {
        background-color: transparent;
        border-radius: 20px;
        overflow: visible;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
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
        transition: transform 0.3s ease;
        border-radius: 20px;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-info {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
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
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        color: #000;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
        line-height: 1.3;
    }

    .product-price {
        color: #666;
        font-size: 14px;
        font-weight: 500;
    }

    .product-arrow {
        background: rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 15px;
    }

    .product-arrow:hover {
        background: rgba(0, 0, 0, 0.1);
        transform: translateX(3px);
    }

    .product-arrow svg {
        width: 16px;
        height: 16px;
        color: #333;
    }

    /* Outfit Grid */
    .outfit-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
        margin-top: 40px;
    }

    @media (max-width: 768px) {
        .outfit-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }

    .outfit-card {
        background-color: #ffffff;
        overflow: hidden;
    }

    .outfit-content {
        display: flex;
        align-items: center;
        gap: 0;
        height: 200px;
    }

    .outfit-left .outfit-content {
        flex-direction: row;
    }

    .outfit-right .outfit-content {
        flex-direction: row-reverse;
    }

    .outfit-image {
        flex: 0 0 40%;
        height: 100%;
        overflow: hidden;
        position: relative;
    }

    .outfit-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .outfit-text {
        flex: 1;
        padding: 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-bottom: 28px;
    }

    .outfit-title {
        font-size: 18px;
        font-weight: bold;
        color: #000000;
        margin-bottom: 130px;
        line-height: 1.4;
    }

    .outfit-date {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }

    @media (max-width: 768px) {
        .outfit-content {
            flex-direction: column !important;
            height: auto;
        }

        .outfit-image {
            flex: none;
            width: 100%;
            height: 200px;
        }

        .outfit-text {
            padding: 20px;
        }

        .outfit-title {
            font-size: 16px;
        }
    }

    /* Filter Buttons */
    .filter-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 50px;
    }

    .filter-btn {
        padding: 12px 30px;
        border: 2px solid #000000;
        background-color: transparent;
        color: #000000;
        border-radius: 50px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background-color: #000000;
        color: #ffffff;
    }

    /* Products Grid (Collections) */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .products-grid .product-card {
        background-color: transparent;
        border-radius: 20px;
        overflow: visible;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        position: relative;
    }

    .products-grid .product-card:hover {
        transform: translateY(-5px);
    }

    .products-grid .product-image {
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

    .products-grid .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
        border-radius: 20px;
    }

    .products-grid .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .products-grid .product-info {
        position: absolute;
        bottom: 20px;
        left: 20px;
        right: 20px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transform: translateY(0);
        transition: all 0.3s ease;
    }

    .products-grid .product-card:hover .product-info {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .products-grid .product-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .products-grid .product-details {
        flex: 1;
    }

    .products-grid .product-name {
        color: #000;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
        line-height: 1.3;
    }

    .products-grid .product-price {
        color: #666;
        font-size: 14px;
        font-weight: 500;
    }

    .products-grid .product-arrow {
        background: rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-left: 15px;
    }

    .products-grid .product-arrow:hover {
        background: rgba(0, 0, 0, 0.1);
        transform: translateX(3px);
    }

    .products-grid .product-arrow svg {
        width: 16px;
        height: 16px;
        color: #333;
    }

    /* See All Button */
    .see-all-container {
        text-align: center;
        margin-top: 40px;
    }

    .see-all-btn {
        color: #000000;
        font-size: 16px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .see-all-btn:hover {
        color: #6c757d;
    }

    /* Featured Section */
    .featured-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    @media (max-width: 768px) {
        .featured-grid {
            grid-template-columns: 1fr;
        }
    }

    .featured-card {
        border-radius: 12px;
        overflow: hidden;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .featured-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .featured-universe {
        background-color: #343a40;
        color: #ffffff;
    }

    .featured-minimalist {
        background-color: #f8f9fa;
        color: #000000;
        border: 1px solid #e9ecef;
    }

    .featured-marvel {
        background: linear-gradient(135deg, #7c3aed, #2563eb);
        color: #ffffff;
    }

    .featured-future {
        background-color: #212529;
        color: #ffffff;
    }

    .featured-content {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .featured-content h4 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .featured-content p {
        opacity: 0.7;
    }

    .featured-content img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 0;
        display: block;
        transition: none !important;
        transform: none !important;
    }

    .featured-card:hover .featured-content img,
    .featured-card .featured-content img:hover {
        transform: none !important;
        scale: none !important;
    }

    /* Product Detail Modal */
    .product-detail-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .product-detail-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 1000px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: slideUp 0.3s ease;
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #f8f9fa;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: #e9ecef;
    }

    .product-detail {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 600px;
    }

    @media (max-width: 768px) {
        .product-detail {
            grid-template-columns: 1fr;
        }
    }

    .product-gallery {
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px;
        position: relative;
    }

    .main-product-image {
        width: 100%;
        max-width: 400px;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .thumbnail-gallery {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .thumbnail {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .thumbnail:hover,
    .thumbnail.active {
        border-color: #000;
    }

    .product-info-detail {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .brand-name {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .brand-logo {
        width: 24px;
        height: 24px;
        background: #000;
        border-radius: 50%;
    }

    .brand-text {
        font-size: 14px;
        color: #666;
        font-weight: 500;
    }

    .product-title {
        font-size: 28px;
        font-weight: bold;
        color: #000;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 10px;
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
        color: #666;
        font-size: 14px;
    }

    .product-price-detail {
        font-size: 32px;
        font-weight: bold;
        color: #000;
        margin-bottom: 30px;
    }

    .product-options {
        margin-bottom: 30px;
    }

    .option-group {
        margin-bottom: 25px;
    }

    .option-label {
        font-size: 16px;
        font-weight: 600;
        color: #000;
        margin-bottom: 10px;
        display: block;
    }

    .color-options,
    .size-options {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
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

    .color-option.selected {
        border-color: #000;
    }

    .color-beige { background-color: #F5F5DC; }
    .color-gray { background-color: #808080; }
    .color-black { background-color: #000000; }

    .size-option {
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
        min-width: 45px;
        text-align: center;
    }

    .size-option:hover,
    .size-option.selected {
        border-color: #000;
        background-color: #000;
        color: white;
    }

    .size-guide {
        color: #666;
        font-size: 14px;
        text-decoration: underline;
        cursor: pointer;
        margin-top: 10px;
        display: inline-block;
    }

    .product-actions {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .add-to-cart-btn {
        flex: 1;
        background: #000;
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .add-to-cart-btn:hover {
        background: #333;
    }

    .wishlist-btn {
        width: 50px;
        height: 50px;
        border: 1px solid #ddd;
        border-radius: 50%;
        background: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .wishlist-btn:hover {
        border-color: #000;
    }

    .delivery-info {
        padding: 15px 0;
        border-top: 1px solid #eee;
        font-size: 14px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .delivery-icon {
        width: 20px;
        height: 20px;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1.5rem;
        }

        .filter-container {
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-btn {
            padding: 10px 20px;
            font-size: 14px;
        }

        .product-info-detail {
            padding: 20px;
        }

        .product-title {
            font-size: 24px;
        }

        .product-price-detail {
            font-size: 28px;
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

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .product-card,
    .outfit-card,
    .featured-card {
        animation: fadeInUp 0.6s ease forwards;
    }
</style>

<div class="allproduk-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">
                The New Innovation:
            </h1>
            <h2 class="hero-subtitle">
                Form Chaos To Order
            </h2>
            <button class="btn-primary">
                Get Started
            </button>
        </div>
    </div>

    <!-- Best Seller Section -->
    <div class="section">
        <div class="container">
            <h3 class="section-title">Best Seller</h3>
            <div class="product-grid">
                <!-- Product 1 -->
                <div class="product-card" data-product="muzan-tshirt" data-price="50000" data-image="storage/image/produk1.jpg">
                    <div class="product-image">
                        <img src="storage/image/produk1.jpg" alt="Muzan T-Shirt">
                    </div>
                    <div class="product-info">
                        <div class="product-content">
                            <div class="product-details">
                                <h4 class="product-name">Muzan T-Shirt</h4>
                                <p class="product-price">IDR 50,000.00</p>
                            </div>
                            <button class="product-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14m-7-7 7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card" data-product="douma-tshirt" data-price="50000" data-image="storage/image/produk2.jpg">
                    <div class="product-image">
                        <img src="storage/image/produk2.jpg" alt="Douma T-Shirt">
                    </div>
                    <div class="product-info">
                        <div class="product-content">
                            <div class="product-details">
                                <h4 class="product-name">Douma T-Shirt</h4>
                                <p class="product-price">IDR 50,000.00</p>
                            </div>
                            <button class="product-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14m-7-7 7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card" data-product="mt-shirt" data-price="50000" data-image="storage/image/produk2.jpg">
                    <div class="product-image">
                        <img src="storage/image/produk2.jpg" alt="MT-Shirt">
                    </div>
                    <div class="product-info">
                        <div class="product-content">
                            <div class="product-details">
                                <h4 class="product-name">MT-Shirt</h4>
                                <p class="product-price">IDR 50,000.00</p>
                            </div>
                            <button class="product-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14m-7-7 7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card" data-product="muzan-premium" data-price="50000" data-image="storage/image/produk3.jpg">
                    <div class="product-image">
                        <img src="storage/image/produk3.jpg" alt="Muzan T-Shirt Premium">
                    </div>
                    <div class="product-info">
                        <div class="product-content">
                            <div class="product-details">
                                <h4 class="product-name">Muzan T-Shirt Premium</h4>
                                <p class="product-price">IDR 50,000.00</p>
                            </div>
                            <button class="product-arrow">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14m-7-7 7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inspirational Outfits Section -->
    <div class="section">
        <div class="container">
            <h3 class="section-title">Inspirational Outfits</h3>
            <div class="outfit-grid">
                <!-- Outfit 1 -->
                <div class="outfit-card outfit-left">
                    <div class="outfit-content">
                        <div class="outfit-image">
                            <img src="storage/image/inspirasi1.jpg" alt="Build For The Grind Outfit">
                        </div>
                        <div class="outfit-text">
                            <h4 class="outfit-title">"Dare To Win" For The Dedicated Individuals</h4>
                            <p class="outfit-date">June 5, 2025</p>
                        </div>
                    </div>
                </div>

                <!-- Outfit 2 -->
                <div class="outfit-card outfit-right">
                    <div class="outfit-content">
                        <div class="outfit-text">
                            <h4 class="outfit-title">Made For Those Who Are Silent But Resilient</h4>
                            <p class="outfit-date">July 10, 2025</p>
                        </div>
                        <div class="outfit-image">
                            <img src="storage/image/inspirasi2.jpg" alt="Silent But Resilient Outfit">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Collections Section -->
    <div class="section">
        <div class="container">
            <h3 class="section-title">Our Collections</h3>

            <!-- Filter Buttons -->
            <div class="filter-container">
                <button class="filter-btn active" data-filter="all">T-Shirt</button>
                <button class="filter-btn" data-filter="hoodie">Hoodie</button>
                <button class="filter-btn" data-filter="shoes">Shoes</button>
            </div>

            <!-- Products Grid -->
            <div class="products-grid">
                @for($i = 1; $i <= 16; $i++)
                    <div class="product-card" 
                         data-product="product-{{ $i }}" 
                         data-price="{{ $i % 4 == 1 ? '150000' : ($i % 4 == 2 ? '350000' : ($i % 4 == 3 ? '350000' : '125000')) }}" 
                         data-image="storage/image/produk2.jpg">
                        <div class="product-image">
                            <img src="storage/image/produk2.jpg" alt="Product {{ $i }}">
                        </div>
                        <div class="product-info">
                            <div class="product-content">
                                <div class="product-details">
                                    <h4 class="product-name">
                                        @if($i % 4 == 1) Fashion Tshirt
                                        @elseif($i % 4 == 2) Hoodie
                                        @elseif($i % 4 == 3) Hoodie
                                        @else White Tshirt
                                        @endif
                                    </h4>
                                    <p class="product-price">
                                        @if($i % 4 == 1) IDR 150,000.00
                                        @elseif($i % 4 == 2) IDR 350,000.00
                                        @elseif($i % 4 == 3) IDR 350,000.00
                                        @else IDR 125,000.00
                                        @endif
                                    </p>
                                </div>
                                <button class="product-arrow">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14m-7-7 7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- See All Button -->
            <div class="see-all-container">
                <a href="#" class="see-all-btn">See All →</a>
            </div>
        </div>
    </div>

    <!-- Featured Section -->
    <div class="section">
        <div class="container">
            <h3 class="section-title">Featured</h3>
            <div class="featured-grid">
                <!-- Featured Item 1 -->
                <div class="featured-card featured-universe">
                    <div class="featured-content">
                        <img src="storage/image/banner2.jpg" alt="Featured Banner">
                    </div>
                </div>

                <!-- Featured Item 2 -->
                <div class="featured-card featured-minimalist">
                    <div class="featured-content">
                        <img src="storage/image/banner-sepatu.jpg" alt="Shoes Banner">
                    </div>
                </div>

                <!-- Featured Item 3 -->
                <div class="featured-card featured-marvel">
                    <div class="featured-content">
                        <img src="storage/image/banner-sepatu2.jpg" alt="Shoes Banner 2">
                    </div>
                </div>

                <!-- Featured Item 4 -->
                <div class="featured-card featured-future">
                    <div class="featured-content">
                        <img src="storage/image/banner-hoodie.jpg" alt="Hoodie Banner">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Product Detail Modal -->
<div class="product-detail-modal" id="productModal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeProductModal()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        
        <div class="product-detail">
            <div class="product-gallery">
                <img id="mainProductImage" class="main-product-image" src="" alt="Product Image">
                <div class="thumbnail-gallery">
                    <img class="thumbnail active" src="" alt="Thumbnail 1">
                    <img class="thumbnail" src="" alt="Thumbnail 2">
                    <img class="thumbnail" src="" alt="Thumbnail 3">
                    <img class="thumbnail" src="" alt="Thumbnail 4">
                </div>
            </div>
            
            <div class="product-info-detail">
                <div class="brand-name" style="display: none;">
                    <div class="brand-logo"></div>
                    <span class="brand-text">BRAND</span>
                </div>
                
                <h1 id="modalProductTitle" class="product-title">Product Name</h1>
                
                <div class="product-rating">
                    <div class="stars">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star empty">★</span>
                    </div>
                    <span class="rating-text">4.2 reviews</span>
                </div>
                
                <div id="modalProductPrice" class="product-price-detail">$199.00</div>
                
                <div class="product-options">
                    <div class="option-group">
                        <label class="option-label">Color <span id="selectedColor">White</span></label>
                        <div class="color-options">
                            <div class="color-option color-beige selected" data-color="Beige"></div>
                            <div class="color-option color-gray" data-color="Gray"></div>
                            <div class="color-option color-black" data-color="Black"></div>
                        </div>
                    </div>
                    
                    <div class="option-group">
                        <label class="option-label">Size <span id="selectedSize">EU / Men</span></label>
                        <div class="size-options">
                            <button class="size-option" data-size="40.5">40.5</button>
                            <button class="size-option selected" data-size="41">41</button>
                            <button class="size-option" data-size="42">42</button>
                            <button class="size-option" data-size="43">43</button>
                            <button class="size-option" data-size="43.5">43.5</button>
                            <button class="size-option" data-size="44">44</button>
                            <button class="size-option" data-size="44.5">44.5</button>
                            <button class="size-option" data-size="45">45</button>
                            <button class="size-option" data-size="46">46</button>
                        </div>
                        <a href="#" class="size-guide">Size guide</a>
                    </div>
                </div>
                
                <div class="product-actions">
                    <button class="add-to-cart-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="m1 1 4 4 5.5 9H21l-4-8H7.2"></path>
                        </svg>
                        Add to cart
                    </button>
                    <button class="wishlist-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="delivery-info">
                    <svg class="delivery-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="3" width="15" height="13"></rect>
                        <polygon points="16,8 20,8 23,11 23,16 16,16"></polygon>
                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                    </svg>
                    Free delivery on orders over $30.0
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Product data untuk modal
    const productData = {
        'muzan-tshirt': {
            name: 'Muzan T-Shirt',
            price: 'IDR 50,000.00',
            image: 'storage/image/produk1.jpg'
        },
        'douma-tshirt': {
            name: 'Douma T-Shirt', 
            price: 'IDR 50,000.00',
            image: 'storage/image/produk2.jpg'
        },
        'mt-shirt': {
            name: 'MT-Shirt',
            price: 'IDR 50,000.00', 
            image: 'storage/image/produk2.jpg'
        },
        'muzan-premium': {
            name: 'Muzan T-Shirt Premium',
            price: 'IDR 50,000.00',
            image: 'storage/image/produk3.jpg'
        }
    };

    // Generate dynamic product data for collections
    for(let i = 1; i <= 16; i++) {
        const productType = i % 4;
        let name, price;
        
        if(productType === 1) {
            name = 'Fashion Tshirt';
            price = 'IDR 150,000.00';
        } else if(productType === 2) {
            name = 'Hoodie';
            price = 'IDR 350,000.00';
        } else if(productType === 3) {
            name = 'Hoodie';
            price = 'IDR 350,000.00';
        } else {
            name = 'White Tshirt';
            price = 'IDR 125,000.00';
        }
        
        productData[`product-${i}`] = {
            name: name,
            price: price,
            image: 'storage/image/produk2.jpg'
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                const filterType = this.getAttribute('data-filter');
                console.log('Filter by:', filterType);
            });
        });

        // Product card click events
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('click', function() {
                const productId = this.getAttribute('data-product');
                openProductModal(productId);
            });
        });

        // Color selection
        const colorOptions = document.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', function() {
                colorOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selectedColor').textContent = this.getAttribute('data-color');
            });
        });

        // Size selection
        const sizeOptions = document.querySelectorAll('.size-option');
        sizeOptions.forEach(option => {
            option.addEventListener('click', function() {
                sizeOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Thumbnail click
        const thumbnails = document.querySelectorAll('.thumbnail');
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('mainProductImage').src = this.src;
            });
        });

        // Modal close on background click
        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductModal();
            }
        });
    });

    function openProductModal(productId) {
        const modal = document.getElementById('productModal');
        const product = productData[productId];
        
        if (!product) return;

        // Update modal content
        document.getElementById('modalProductTitle').textContent = product.name;
        document.getElementById('modalProductPrice').textContent = product.price;
        document.getElementById('mainProductImage').src = product.image;
        
        // Update all thumbnails to show the same image (bisa disesuaikan dengan gambar yang berbeda)
        const thumbnails = document.querySelectorAll('.thumbnail');
        thumbnails.forEach(thumb => {
            thumb.src = product.image;
        });

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeProductModal() {
        const modal = document.getElementById('productModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProductModal();
        }
    });
</script>
@endsection