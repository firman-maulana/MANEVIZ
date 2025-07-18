<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANEVIZ</title>
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 15px 0;
            transition: all 0.3s ease;
            background: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.2), transparent);
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 2rem;
            flex: 1;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.3s ease;
            position: relative;
        }

        .navbar.scrolled .nav-menu a {
            color: #333;
        }

        .nav-menu a:hover {
            color: #ff6b6b;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #ff6b6b;
            transition: width 0.3s ease;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .logo {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            height: 93px;
            width: auto;
            object-fit: contain;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            justify-content: flex-end;
        }

        .search-container {
            position: relative;
        }

        .search-bar {
            padding: 8px 40px 8px 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 0.9rem;
            width: 200px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .search-bar::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-bar:focus {
            outline: none;
            border-color: #ffff;
            background: rgba(255, 255, 255, 0.2);
            width: 220px;
        }

        .navbar.scrolled .search-bar {
            border-color: rgba(51, 51, 51, 0.3);
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }

        .navbar.scrolled .search-bar::placeholder {
            color: rgba(51, 51, 51, 0.7);
        }

        .navbar.scrolled .search-bar:focus {
            border-color: black;
            background: rgba(255, 255, 255, 0.9);
        }

        .search-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 1rem;
            pointer-events: none;
        }

        .navbar.scrolled .search-icon {
            color: #333;
        }

        .nav-icons {
            display: flex;
            gap: 1rem;
            align-items: center;
            margin-left: 1rem;
        }

        .nav-icon {
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: color 0.3s ease;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar.scrolled .nav-icon {
            color: #333;
        }

        .nav-icon:hover {
            color: #ff6b6b;
        }
        .cart-icon {
            position: relative;
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
        .timeless h2 {
            color: black;
            text-align: left;
            padding-left: 20px;
            font-weight: 600;
        } 

        /* Tambahan CSS untuk membuat tampilan lebih sesuai dengan gambar */
.product-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2px; /* Gap minimal seperti di gambar */
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.product-card {
    background: white;
    overflow: hidden;
    transition: transform 0.2s ease;
    cursor: pointer;
    border: none;
    box-shadow: none;
}

.product-image {
    position: relative;
    width: 100%;
    height: 400px; /* Tinggi lebih besar seperti di gambar */
    overflow: hidden;
    background: #f8f8f8;
}

.product-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 4px 8px;
    border-radius: 3px;
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: capitalize;
}

.product-badge.bestseller {
    background: #ff4444;
    color: white;
}

.product-badge.sustainable {
    background: #ff6600; /* Warna orange seperti di gambar */
    color: white;
}

.product-badge.just-in {
    background: #ff6600;
    color: white;
}

.product-info {
    padding: 15px 10px;
    background: white;
}

.product-info h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #000;
    margin-bottom: 2px;
    line-height: 1.2;
}

.product-info p {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 2px;
    line-height: 1.3;
}

.product-info .price {
    font-size: 1rem;
    font-weight: 600;
    color: #000;
    margin-top: 5px;
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
            height: 90vh;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('storage/image/banner.png');
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
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="nav-content">
            <ul class="nav-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            
            <img src="storage/image/maneviz.png" alt="TIMELESS Logo" class="logo">
            
            <div class="nav-right">
                <div class="search-container">
                    <input type="text" class="search-bar" placeholder="Search products...">
                    <span class="search-icon">⌕</span>
                </div>
                
                <div class="nav-icons">
                    <span class="nav-icon cart-icon" onclick="toggleCart()">
                        ⚏
                    </span>
                    <span class="nav-icon">♡</span>
                    <span class="nav-icon">⚐</span>
                </div>
            </div>
            
            <button class="mobile-menu-toggle">☰</button>
        </div>
    </nav>

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
    </section>

    <!-- Timeless Choice -->
     <section class="timeless">
        <h2>Timeless Choice</h2>
        
        <!-- Product Grid -->
        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="storage/image/banner.png" alt="Nike Club">
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
                    <img src="storage/image/banner.png" alt="Nike Gato">
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
                    <img src="storage/image/banner.png" alt="Nike Total 90">
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
                    <img src="storage/image/banner.png" alt="Nike 24-7 PerfectStretch">
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
                    <img src="storage/image/banner.png" alt="Nike Total 90">
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
                    <img src="storage/image/banner.png" alt="Nike Sportswear">
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
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>