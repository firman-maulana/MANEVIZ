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
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.2), transparent);
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

        /* footer */
        .footer-container {
            display: flex;
            justify-content: space-between;
            padding: 40px 80px;
            background-color: #0a0707;
            color: white;
            font-family: 'Arial', sans-serif;
            flex-wrap: wrap;
        }

        .footer-left {
            max-width: 300px;
        }

        .logo img {
            width: 150px;
            margin-bottom: 20px;
        }

        .find-us {
            margin-bottom: 10px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .social-icons img {
            width: 28px;
            margin-right: 12px;
            margin-bottom: 15px;
            vertical-align: middle;
        }

        .auth-buttons {
            margin-top: 10px;
        }

        .auth-buttons button {
            margin-top: 10px;
            display: block;
            width: 160px;
            height: 36px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid white;
            color: white;
        }

        .btn-filled {
            background: white;
            color: black;
            border: none;
        }

        .footer-right {
            flex-grow: 1;
            padding-left: 40px;
        }

        .footer-right ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-right li {
            padding: 10px 0;
            border-bottom: 1px solid white;
        }

        .footer-right li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-right li.copyright {
            border: none;
            padding-top: 15px;
            font-size: 13px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="nav-content">
            <ul class="nav-menu">
                @auth
                <li><a class="nav-link" href="{{ url('/beranda') }}">Home</a></li>
                @else
                <li><a class="nav-link" href="{{ url('/beranda') }}">Home</a></li>
                @endauth
                <li><a class="nav-link" href="{{ url('/allProduct') }}">Products</a></li>
                <li><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                <li><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
            </ul>

            <img src="storage/image/maneviz.png" alt="TIMELESS Logo" class="logo">

            <div class="nav-right">
                <div class="search-container">
                    <input type="text" class="search-bar" placeholder="Search products...">
                    <span class="search-icon">⌕</span>
                </div>

                @auth
                <div class="nav-icons">
                    <span class="nav-icon cart-icon" onclick="toggleCart()">
                        ⚏
                    </span>
                    <span class="nav-icon">♡</span>
                    <span class="nav-icon">⚐</span>
                </div>
                @endauth
            </div>

            <button class="mobile-menu-toggle">☰</button>
        </div>
    </nav>

    <main id="konten">
        @yield('content')
    </main>

    <footer class="footer-container">
        <div class="footer-left">
            <div class="logo">
                <img src="storage/image/maneviz-white.png" alt="MANEVIZ Logo" />
            </div>
            <p class="find-us">FIND US ON</p>
            <div class="social-icons">
                <img src="wa.png" alt="WhatsApp" />
                <img src="shopee.png" alt="Shopee" />
                <img src="ig.png" alt="Instagram" />
                <img src="tokopedia.png" alt="Tokopedia" />
                <img src="tiktok.png" alt="TikTok" />
                <img src="x.png" alt="X" />
                <img src="yt.png" alt="YouTube" />
            </div>
            <div class="auth-buttons">
                @guest
                <button class="btn-outline"><a href="{{ route('signIn') }}">Sign In</a></button>
                <button class="btn-filled"><a href="{{ route('signUp') }}">Sign Up</a></button>
                @else
                <button class="btn-outline" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endguest
            </div>
        </div>

        <div class="footer-right">
            <ul>
                <li><a href="#">Refund Policy</a></li>
                <li><a href="#">How To Order</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Payment Confirmation</a></li>
                <li class="copyright">Copyright © 2025 MANEVIZ</li>
            </ul>
        </div>
    </footer>
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
    </script>


</body>

</html>