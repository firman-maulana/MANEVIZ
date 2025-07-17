<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIMELESS - Premium T-Shirt Collection</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
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

        .cart-count {
            background: #ff6b6b;
            color: white;
            border-radius: 50%;
            padding: 0.2rem 0.5rem;
            font-size: 0.8rem;
            position: absolute;
            top: -8px;
            right: -8px;
            min-width: 18px;
            text-align: center;
        }

        .cart-icon {
            position: relative;
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
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('storage/image/banner.png');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
        }

        /* Featured Products Section */
        .featured-section {
            padding: 4rem 0;
            background: white;
        }

        .featured-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-bottom: 4rem;
        }

        .featured-item {
            text-align: center;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .featured-item:hover {
            transform: translateY(-5px);
        }

        .featured-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 1.1rem;
        }

        .featured-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .featured-overlay h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .featured-overlay p {
            opacity: 0.9;
        }

        /* Dark Section */
        .dark-section {
            background: #1a1a1a;
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .dark-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #ff6b6b;
        }

        .dark-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .dark-product {
            max-width: 400px;
            margin: 0 auto;
            background: #2a2a2a;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .dark-product-image {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #333, #555);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        /* Product Grid */
        .products-section {
            padding: 4rem 0;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        .product-image {
            width: 100%;
            height: 250px;
            background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 1.1rem;
            position: relative;
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #ff6b6b;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .product-info {
            padding: 1.5rem;
            text-align: center;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .product-price {
            font-size: 1.3rem;
            color: #ff6b6b;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .add-to-cart {
            width: 100%;
            background: #333;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }

        .add-to-cart:hover {
            background: #ff6b6b;
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

            .featured-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 1rem;
            }

            .section-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .products-grid {
                grid-template-columns: 1fr;
            }

            .featured-grid {
                grid-template-columns: 1fr;
            }

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

        .product-card {
            animation: fadeInUp 0.6s ease-out;
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
                        <span class="cart-count" id="cartCount">0</span>
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

    <!-- Featured Products -->
    <section class="featured-section">
        <div class="container">
            <div class="featured-grid">
                <div class="featured-item">
                    <div class="featured-overlay">
                        <h3>Premium White Collection</h3>
                        <p>Minimalist design with premium quality</p>
                    </div>
                    <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 1.1rem;">
                        White T-Shirt Collection
                    </div>
                </div>
                
                <div class="featured-item">
                    <div class="featured-overlay">
                        <h3>Graphic Design Series</h3>
                        <p>Unique artwork and creative designs</p>
                    </div>
                    <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #f0f0f0, #e0e0e0); display: flex; align-items: center; justify-content: center; color: #999; font-size: 1.1rem;">
                        Graphic T-Shirt Collection
                    </div>
                </div>
                
                <div class="featured-item">
                    <div class="featured-overlay">
                        <h3>Classic Black Series</h3>
                        <p>Timeless black designs for every occasion</p>
                    </div>
                    <div style="width: 100%; height: 400px; background: linear-gradient(135deg, #343a40, #495057); display: flex; align-items: center; justify-content: center; color: #adb5bd; font-size: 1.1rem;">
                        Black T-Shirt Collection
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Dark Section -->
    <section class="dark-section">
        <div class="container">
            <h2>demonlord</h2>
            <p>Built For The Grind. Styled By Chaos</p>
            <div class="dark-product">
                <div class="dark-product-image">
                    Demonlord T-Shirt Design
                </div>
                <div class="add-to-cart" onclick="addToCart(999)" style="background: #ff6b6b; margin-top: 1rem;">
                    Add to Cart
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section" id="products">
        <div class="container">
            <h2 class="section-title">Timeless Choice</h2>
            <div class="products-grid" id="productsGrid">
                <!-- Products will be loaded here -->
            </div>
        </div>
    </section>

    <script>
        // Sample products data
        const products = [
            {
                id: 1,
                name: "Basic White",
                price: "Rp 199.000",
                badge: "Popular"
            },
            {
                id: 2,
                name: "Basic Grey",
                price: "Rp 199.000",
                badge: "New"
            },
            {
                id: 3,
                name: "Basic Black",
                price: "Rp 199.000",
                badge: "Best Seller"
            },
            {
                id: 4,
                name: "Graphic White",
                price: "Rp 249.000",
                badge: "Limited"
            },
            {
                id: 5,
                name: "Graphic Grey",
                price: "Rp 249.000",
                badge: "Trending"
            },
            {
                id: 6,
                name: "Graphic Black",
                price: "Rp 249.000",
                badge: "Hot"
            }
        ];

        let cart = [];

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Load products on page load
        document.addEventListener('DOMContentLoaded', function() {
            displayProducts();
        });

        function displayProducts() {
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = '';

            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                productCard.innerHTML = `
                    <div class="product-image">
                        <div class="product-badge">${product.badge}</div>
                        ${product.name} Design
                    </div>
                    <div class="product-info">
                        <div class="product-title">${product.name}</div>
                        <div class="product-price">${product.price}</div>
                        <button class="add-to-cart" onclick="addToCart(${product.id})">
                            Add to Cart
                        </button>
                    </div>
                `;
                productsGrid.appendChild(productCard);
            });
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId) || { id: 999, name: "Demonlord T-Shirt", price: "Rp 299.000" };
            
            cart.push(product);
            updateCartCount();
            
            // Show success message
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Added!';
            button.style.background = '#4CAF50';
            
            setTimeout(() => {
                button.textContent = originalText;
                button.style.background = button.classList.contains('add-to-cart') ? '#333' : '#ff6b6b';
            }, 2000);
        }

        function updateCartCount() {
            document.getElementById('cartCount').textContent = cart.length;
        }

        function toggleCart() {
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            
            let cartItems = 'Shopping Cart:\n\n';
            cart.forEach((item, index) => {
                cartItems += `${index + 1}. ${item.name} - ${item.price}\n`;
            });
            
            alert(cartItems);
        }

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

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all product cards
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.querySelectorAll('.product-card, .featured-item').forEach(card => {
                    observer.observe(card);
                });
            }, 100);
        });
    </script>
</body>
</html>