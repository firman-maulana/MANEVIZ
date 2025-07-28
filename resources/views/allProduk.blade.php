@extends('layouts.app')

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
    color:#000000;
    font-weight: bold;
    margin-bottom: 20px;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 3rem;
    color:#000000;
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
    color: #000000;;
    font-weight: bold;
    margin-bottom: 40px;
}

/* Product Grid */
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
    background-color: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid #e9ecef;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.product-image {
    width: 100%;
    aspect-ratio: 1;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-info {
    padding: 20px;
}

.product-name {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 8px;
}

.product-price {
    color: #6c757d;
    font-size: 14px;
}

/* Outfit Grid */
.outfit-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

@media (max-width: 768px) {
    .outfit-grid {
        grid-template-columns: 1fr;
    }
}

.outfit-card {
    padding: 40px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
}

.outfit-card:hover {
    transform: translateY(-5px);
}

.outfit-red {
    background-color: #dc2626;
}

.outfit-dark {
    background-color: #343a40;
    color: #ffffff;
}

.outfit-title {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 20px;
    line-height: 1.4;
}

.outfit-image {
    margin-top: 20px;
}

.outfit-image img {
    width: 100%;
    border-radius: 8px;
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
    transition: all 0.3s ease;
    cursor: pointer;
}

.featured-card:hover {
    transform: translateY(-5px);
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

.featured-content h4 {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.featured-content p {
    opacity: 0.7;
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
                Form Chaos To Cosmos
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
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/200/200" alt="Cosmos Tshirt">
                    </div>
                    <div class="product-info">
                        <h4 class="product-name">Cosmos Tshirt</h4>
                        <p class="product-price">Rp 150.000</p>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/200/200" alt="Hoodie">
                    </div>
                    <div class="product-info">
                        <h4 class="product-name">Hoodie</h4>
                        <p class="product-price">Rp 350.000</p>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/200/200" alt="Hoodie">
                    </div>
                    <div class="product-info">
                        <h4 class="product-name">Hoodie</h4>
                        <p class="product-price">Rp 350.000</p>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/200/200" alt="White Tshirt">
                    </div>
                    <div class="product-info">
                        <h4 class="product-name">White Tshirt</h4>
                        <p class="product-price">Rp 125.000</p>
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
                <div class="outfit-card outfit-red">
                    <h4 class="outfit-title">"Dare to Win" For Strong Individuals</h4>
                    <div class="outfit-image">
                        <img src="/api/placeholder/300/200" alt="Dare to Win Outfit">
                    </div>
                </div>

                <!-- Outfit 2 -->
                <div class="outfit-card outfit-dark">
                    <h4 class="outfit-title">Ideal for Those Who Are Silent But Resilient</h4>
                    <div class="outfit-image">
                        <img src="/api/placeholder/300/200" alt="Silent But Resilient Outfit">
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
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/200/200" alt="Product {{ $i }}">
                    </div>
                    <div class="product-info">
                        <h4 class="product-name">
                            @if($i % 4 == 1) Cosmos Tshirt
                            @elseif($i % 4 == 2) Hoodie
                            @elseif($i % 4 == 3) Hoodie
                            @else White Tshirt
                            @endif
                        </h4>
                        <p class="product-price">
                            @if($i % 4 == 1) Rp 150.000
                            @elseif($i % 4 == 2) Rp 350.000
                            @elseif($i % 4 == 3) Rp 350.000
                            @else Rp 125.000
                            @endif
                        </p>
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
                        <h4>UNIVERSE T-SHIRT</h4>
                        <p>Premium Quality</p>
                    </div>
                </div>

                <!-- Featured Item 2 -->
                <div class="featured-card featured-minimalist">
                    <div class="featured-content">
                        <h4>MINIMALIST</h4>
                        <p>Clean Design</p>
                    </div>
                </div>

                <!-- Featured Item 3 -->
                <div class="featured-card featured-marvel">
                    <div class="featured-content">
                        <h4>MARVEL-F X CHAOS COSMOS</h4>
                        <p>Limited Edition</p>
                    </div>
                </div>

                <!-- Featured Item 4 -->
                <div class="featured-card featured-future">
                    <div class="featured-content">
                        <h4>BUILD THE FUTURE</h4>
                        <p>Innovation Series</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Filter logic here
            const filterType = this.getAttribute('data-filter');
            console.log('Filter by:', filterType);
        });
    });
    
    // Add click events to product cards
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('click', function() {
            console.log('Product clicked:', this.querySelector('.product-name').textContent);
        });
    });
});
</script>
@endsection