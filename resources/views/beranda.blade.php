@extends('layouts.app')

@section('content')


<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f5f5f5;
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
    }

    /* Tambahan CSS untuk membuat tampilan lebih sesuai dengan gambar */
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Replace the existing product card styles with these updated ones */

    /* Replace the existing product card styles with these updated ones */

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 120px;
        padding: 30px 20px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid #f0f0f0;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.2);
    }

    .product-image {
        position: relative;
        width: 100%;
        height: 220px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin: 12px;
        border-radius: 12px;
        width: calc(100% - 24px);
        height: 200px;
    }

    .product-image img {
        width: 85%;
        height: 85%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.08);
    }

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

    .product-info {
        padding: 18px 20px 22px 20px;
        text-align: left;
    }

    .product-info h4 {
        font-size: 16px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 6px;
        line-height: 1.3;
    }

    .product-info p {
        color: #7f8c8d;
        font-size: 13px;
        margin-bottom: 3px;
        line-height: 1.4;
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

    /* Placeholder untuk gambar yang belum ada */
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 30px 15px;
        }

        .product-info {
            padding: 20px;
        }

        .product-image {
            height: 260px;
            margin: 12px;
            width: calc(100% - 24px);
        }
    }

    @media (max-width: 480px) {
        .product-grid {
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 20px 10px;
        }

        .product-card {
            border-radius: 16px;
        }

        .product-image {
            height: 240px;
            margin: 10px;
            width: calc(100% - 20px);
            border-radius: 12px;
        }
    }

    /* Mobile Menu */
    .mobile-menu-toggle {
        display: none;
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .navbar.scrolled .mobile-menu-toggle {
        color: #333;
    }

    /* Hero Section */
    .hero {
        height: 100vh;
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('storage/image/banner.png');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }


    /* Responsive Design */
    @media (max-width: 768px) {
        .nav-menu {
            display: none;
        }

        .mobile-menu-toggle {
            display: block;
        }

        .logo {
            position: static;
            transform: none;
            height: 35px;
        }

        .nav-content {
            justify-content: space-between;
        }

        .nav-right {
            justify-content: flex-end;
        }

        .search-bar {
            width: 150px;
        }

        .search-bar:focus {
            width: 170px;
        }
    }

    @media (max-width: 480px) {
        .search-bar {
            width: 120px;
        }

        .search-bar:focus {
            width: 140px;
        }
    }

    /* Animations */
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

    .banner2{
        margin-bottom: 80px;
    }
</style>

<!-- Hero Section -->
<section class="hero" id="home">
    <!-- Hero section is now empty, showing only the background image -->
</section>

<!-- styleback -->
<section class="styleback">
    <img src="storage/image/styleback.png">
    <h4>Fashion</h4>
    <h3>Built for The Grind, Styled by Chaos</h3>
    <hr>

     <h2>Timeless Choice</h2>

    <!-- Product Grid -->
    <div class="container">
        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <div class="product-image">
                    <div class="placeholder-image">
                        <div>Product Image<br>280x280</div>
                    </div>
                    <div class="product-badge bestseller">Bestseller</div>
                </div>
                <div class="product-info">
                    <h4>Nike Club</h4>
                    <p>Men's Shorts</p>
                    <p class="color-info">1 Colour</p>
                    <p class="price">Rp 529.000</p>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
                <div class="product-image">
                    <div class="placeholder-image">
                        <div>Product Image<br>280x280</div>
                    </div>
                </div>
                <div class="product-info">
                    <h4>Nike Gato</h4>
                    <p>Men's Shoes</p>
                    <p class="color-info">1 Colour</p>
                    <p class="price">Rp 1.729.000</p>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
                <div class="product-image">
                    <div class="placeholder-image">
                        <div>Product Image<br>280x280</div>
                    </div>
                </div>
                <div class="product-info">
                    <h4>Nike Total 90</h4>
                    <p>Men's Shoes</p>
                    <p class="color-info">1 Colour</p>
                    <p class="price">Rp 1.729.000</p>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
                <div class="product-image">
                    <div class="placeholder-image">
                        <div>Product Image<br>280x280</div>
                    </div>
                    <div class="product-badge sustainable">Sustainable Materials</div>
                </div>
                <div class="product-info">
                    <h4>Nike 24-7 PerfectStretch</h4>
                    <p>Men's Dri-FIT 15cm (approx.) Shorts</p>
                    <p class="color-info">1 Colour</p>
                    <p class="price">Rp 1.099.000</p>
                </div>
            </div>

            <!-- Product 5 -->
            <div class="product-card">
                <div class="product-image">
                    <div class="placeholder-image">
                        <div>Product Image<br>280x280</div>
                    </div>
                    <div class="product-badge just-in">Just In</div>
                </div>
                <div class="product-info">
                    <h4>Nike Total 90</h4>
                    <p>Men's Dri-FIT Football Shirt</p>
                    <p class="color-info">1 Colour</p>
                    <p class="price">Rp 809.000</p>
                </div>
            </div>

            <!-- Product 6 -->
            <div class="product-card">
                <div class="product-image">
                    <div class="placeholder-image">
                        <div>Product Image<br>280x280</div>
                    </div>
                    <div class="product-badge sustainable">Sustainable Materials</div>
                </div>
                <div class="product-info">
                    <h4>Nike Sportswear</h4>
                    <p>Women's V-Neck Jersey Top</p>
                    <p class="color-info">1 Colour</p>
                    <p class="price">Rp 599.000</p>
                </div>
            </div>
        </div>
    </div>

    <h2>The Latest</h2>
    <img src="storage/image/banner2.jpg" class="banner2">
</section>

<!-- Timeless Choice -->
<section class="timeless">
    
</section>

<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
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

    // Optional: Add some interactivity
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function() {
            const productName = this.querySelector('h4').textContent;
            console.log('Product clicked:', productName);
            // Add your product click logic here
        });
    });
</script>
@endsection