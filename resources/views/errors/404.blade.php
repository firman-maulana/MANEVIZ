<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <title>404 - Halaman Tidak Ditemukan | MANEVIZ</title>
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
            background-color: white;
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
            color: #333;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-menu .nav-link {
            text-decoration: none;
            color: #333;
            transition: color 0.3s ease;
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

        .nav-icons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-icon {
            color: #333;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 50%;
        }

        .nav-icon:hover {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
            transform: scale(1.1);
        }

        .cart-icon {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #ff6b6b;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .mobile-profile-icon {
            display: none;
            color: #333;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .mobile-profile-icon:hover {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        .mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            z-index: 2000;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .mobile-menu.open {
            transform: translateX(0);
        }

        .mobile-menu-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .mobile-menu-close:hover {
            color: #ff6b6b;
            transform: scale(1.1);
        }

        .mobile-nav-menu {
            list-style: none;
            text-align: center;
            margin-bottom: 2rem;
        }

        .mobile-nav-menu li {
            margin: 1rem 0;
        }

        .mobile-nav-menu a {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 10px 20px;
            border-radius: 10px;
            display: block;
        }

        .mobile-nav-menu a:hover {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        .mobile-menu-toggle {
            display: none;
            color: #333;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            color: #ff6b6b;
            background: rgba(255, 107, 107, 0.1);
        }

        .mobile-nav-icons {
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
        }

        .mobile-nav-icons .nav-icon {
            color: white;
            font-size: 1.5rem;
            padding: 15px;
        }

        .user-dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.3s ease;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: #ff6b6b;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item.logout {
            color: #dc3545;
        }

        /* Error Page Styles */
        .error-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            padding-top: 120px;
            padding-bottom: 60px;
        }

        .error-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            max-width: 1200px;
            width: 100%;
            padding: 2rem;
            align-items: center;
        }

        .error-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 2rem;
        }

        .error-title {
            font-size: 8rem;
            font-weight: 900;
            margin: 0;
            line-height: 1;
            color: #000;
            letter-spacing: -5px;
        }

        .error-subtitle {
            font-size: 2.5rem;
            margin: 0;
            font-weight: 700;
            color: #000;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        .error-description {
            font-size: 1.1rem;
            margin: 0;
            color: #000;
            line-height: 1.8;
            max-width: 500px;
        }

        .error-suggestions {
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .suggestion-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            color: #333;
        }

        .suggestion-item i {
            color: #000;
            font-size: 1.1rem;
        }

        .home-button {
            display: inline-block;
            padding: 15px 40px;
            background-color: #000;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: fit-content;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .home-button:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .error-right {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container {
            width: 100%;
            max-width: 800px;
            height: auto;
            display: flex;
            justify-content: right;
            align-items: center;
        }

        .image-container img {
            max-width: 100%;
            height: auto;
            object-fit: contain;
        }

        /* Footer Styles */
        .footer {
            background: #000;
            color: white;
            position: relative;
            border-top: 1px solid #333;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 25px 20px;
            position: relative;
        }

        .footer-main {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: start;
        }

        .footer-left {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            margin-left: -8px;
            gap: 10px;
            margin-bottom: 1px;
        }

        .footer-logo img {
            height: 80px;
            width: auto;
        }

        .footer-social-section h4 {
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-social {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-icon:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }

        .auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-width: 200px;
        }

        .auth-btn {
            padding: 10px 20px;
            border: 2px solid white;
            border-radius: 25px;
            background: transparent;
            color: white;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .auth-btn.sign-in {
            background: transparent;
            color: white;
        }

        .auth-btn.sign-up {
            background: white;
            color: black;
        }

        .auth-btn.sign-in:hover {
            background: white;
            color: black;
        }

        .auth-btn.sign-up:hover {
            background: transparent;
            color: white;
        }

        .footer-right {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: flex-end;
            text-align: right;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .copy {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 6px 0;
            border-bottom: 1px solid transparent;
        }

        .footer-links li a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 6px 0;
            border-bottom: 1px solid transparent;
        }

        .footer-links li a:hover {
            color: white;
            border-bottom-color: rgba(255, 255, 255, 0.3);
        }

        .footer-divider {
            width: 100%;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            margin: 0;
            border: none;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .nav-content {
                padding: 0 15px;
            }

            .nav-menu {
                gap: 1.5rem;
            }

            .logo {
                height: 80px;
            }

            .error-content {
                gap: 60px;
            }

            .error-title {
                font-size: 6rem;
            }

            .error-subtitle {
                font-size: 2rem;
            }

            .footer-content {
                padding: 20px 15px;
            }

            .footer-main {
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 12px 0;
            }

            .nav-content {
                padding: 0 15px;
                justify-content: space-between;
            }

            .nav-menu {
                display: none;
            }

            .logo {
                position: static;
                transform: none;
                height: 70px;
                order: 2;
            }

            .mobile-menu-toggle {
                display: block;
                order: 1;
            }

            .mobile-profile-icon {
                display: block;
                order: 3;
            }

            .nav-right {
                order: 4;
                flex: 0;
                gap: 0.5rem;
            }

            .nav-icons {
                display: none;
            }

            .error-container {
                padding-top: 100px;
            }

            .error-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .error-left {
                align-items: center;
            }

            .error-title {
                font-size: 5rem;
            }

            .error-subtitle {
                font-size: 1.8rem;
            }

            .error-description {
                font-size: 1rem;
            }

            .error-suggestions {
                gap: 0.6rem;
            }

            .suggestion-item {
                font-size: 0.9rem;
            }

            .home-button {
                margin: 0 auto;
            }

            .footer-main {
                grid-template-columns: 1fr;
                gap: 30px;
                text-align: center;
            }

            .footer-left {
                align-items: center;
            }

            .footer-logo {
                justify-content: center;
                margin-left: 0;
            }

            .footer-logo img {
                height: 60px;
            }

            .footer-social {
                justify-content: center;
            }

            .auth-buttons {
                max-width: 100%;
                align-self: center;
                width: 100%;
                max-width: 250px;
            }

            .footer-right {
                align-items: center;
                text-align: center;
            }

            .footer-links {
                gap: 15px;
                width: 100%;
            }

            .footer-links li a,
            .copy {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .navbar {
                padding: 10px 0;
            }

            .nav-content {
                padding: 0 10px;
                gap: 8px;
            }

            .logo {
                height: 60px;
                flex: 1;
            }

            .mobile-menu-toggle {
                font-size: 1.3rem;
                order: 1;
                flex: 0;
            }

            .mobile-profile-icon {
                font-size: 1.2rem;
                order: 3;
                flex: 0;
            }

            .nav-right {
                order: 4;
                flex: 0;
            }

            .nav-right .nav-icon {
                font-size: 1.2rem;
                padding: 8px;
            }

            .mobile-nav-menu a {
                font-size: 1.3rem;
            }

            .error-title {
                font-size: 4rem;
            }

            .error-subtitle {
                font-size: 1.5rem;
            }

            .error-description {
                font-size: 0.95rem;
            }

            .error-suggestions {
                gap: 0.5rem;
            }

            .suggestion-item {
                font-size: 0.85rem;
            }

            .suggestion-item i {
                font-size: 1rem;
            }

            .home-button {
                padding: 12px 30px;
                font-size: 0.9rem;
            }

            .footer-content {
                padding: 20px 10px;
            }

            .footer-logo img {
                height: 50px;
            }

            .footer-social {
                gap: 8px;
            }

            .social-icon {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .auth-btn {
                padding: 8px 16px;
                font-size: 0.8rem;
            }

            .footer-links {
                gap: 12px;
            }

            .footer-links li a,
            .copy {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 360px) {
            .nav-content {
                padding: 0 8px;
                gap: 6px;
            }

            .logo {
                height: 55px;
                padding-left: 37px;
            }

            .mobile-menu-toggle,
            .mobile-profile-icon {
                padding: 6px;
                font-size: 1.1rem;
            }

            .error-title {
                font-size: 3.5rem;
            }

            .error-subtitle {
                font-size: 1.3rem;
            }

            .footer-content {
                padding: 15px 8px;
            }

            .footer-main {
                gap: 25px;
            }

            .footer-social {
                gap: 6px;
            }

            .social-icon {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-close" onclick="toggleMobileMenu()">
            <i class="bi bi-x"></i>
        </div>

        <ul class="mobile-nav-menu">
            <li><a href="/" onclick="toggleMobileMenu()">Home</a></li>
            <li><a href="/allProduct" onclick="toggleMobileMenu()">Products</a></li>
            <li><a href="/about" onclick="toggleMobileMenu()">About</a></li>
            <li><a href="/contact" onclick="toggleMobileMenu()">Contact</a></li>
        </ul>

        @auth
        <div class="mobile-nav-icons">
            <a href="/orders" class="nav-icon">
                <i class="bi bi-bag-check"></i>
            </a>
            <a href="/cart" class="nav-icon cart-icon">
                <i class="bi bi-cart3"></i>
            </a>
            <a href="/address" class="nav-icon">
                <i class="bi bi-geo-alt"></i>
            </a>
        </div>
        @endauth
    </div>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="nav-content">
            <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">
                <i class="bi bi-list"></i>
            </div>

            <ul class="nav-menu">
                <li><a class="nav-link" href="/">Home</a></li>
                <li><a class="nav-link" href="/allProduct">Products</a></li>
                <li><a class="nav-link" href="/about">About</a></li>
                <li><a class="nav-link" href="/contact">Contact</a></li>
            </ul>

            <img src="../image/maneviz.png" alt="MANEVIZ Logo" class="logo">

            <a href="{{ url('/profil') }}" class="mobile-profile-icon">
                <i class="bi bi-person-circle"></i>
            </a>

            <div class="nav-right">
                @auth
                <div class="nav-icons">
                    <a href="{{ url('/cart') }}" class="nav-icon cart-icon">
                        <i class="bi bi-cart3"></i>
                    </a>
                    <a href="{{ url('/orders') }}" class="nav-icon">
                        <i class="bi bi-bag-check"></i>
                    </a>
                    <div class="nav-icon user-dropdown" onclick="toggleUserDropdown()">
                        <i class="bi bi-person-circle"></i>
                        <div class="dropdown-menu" id="userDropdown">
                            <a href="{{ url('/profil') }}" class="dropdown-item">
                                <i class="bi bi-person me-2"></i> Profile
                            </a>
                            <a href="{{ url('/address') }}" class="dropdown-item">
                                <i class="bi bi-geo-alt me-2"></i> Alamat
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="dropdown-item logout" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Error Page Content -->
    <div class="error-container">
        <div class="error-content">
            <div class="error-left">
                <h1 class="error-title">404</h1>
                <h2 class="error-subtitle">NOT FOUND</h2>
                <p class="error-description">
                    Oops! The page you're looking for doesn't exist. It might have been moved, deleted, or the URL might be incorrect.
                </p>

                <!-- <div class="error-suggestions">
                    <div class="suggestion-item">
                        <i class="bi bi-house-door"></i>
                        <span>Return to homepage</span>
                    </div>
                    <div class="suggestion-item">
                        <i class="bi bi-bag"></i>
                        <span>Browse our products</span>
                    </div>
                    <div class="suggestion-item">
                        <i class="bi bi-telephone"></i>
                        <span>Contact our support team</span>
                    </div>
                </div> -->

                <a href="{{ url('/') }}" class="home-button">Go Home</a>
            </div>

            <div class="error-right">
                <div class="image-container">
                    <img src="{{ asset('image/eror404.png') }}" alt="404 Not Found">
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-main">
                <!-- Left Section -->
                <div class="footer-left">
                    <div class="footer-logo">
                        <img src="{{ asset('image/maneviz-white.png') }}" alt="MANEVIZ">
                    </div>

                    <div class="footer-social-section">
                        <h4>Find Us On</h4>
                        <div class="footer-social">
                            <a href="#" class="social-icon" title="WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <a href="#" class="social-icon" title="Shopee">
                                <i class="bi bi-shop"></i>
                            </a>
                            <a href="#" class="social-icon" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-icon" title="Discord">
                                <i class="bi bi-discord"></i>
                            </a>
                            <a href="#" class="social-icon" title="TikTok">
                                <i class="bi bi-tiktok"></i>
                            </a>
                            <a href="#" class="social-icon" title="Twitter">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" class="social-icon" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>

                    @guest
                    <div class="auth-buttons">
                        <a href="{{ route('signIn') }}" class="auth-btn sign-in">Sign In</a>
                        <a href="{{ route('signUp') }}" class="auth-btn sign-up">Sign Up</a>
                    </div>
                    @else
                    <div class="auth-buttons">
                        <div style="text-align: left; color: rgba(255, 255, 255, 0.8); font-size: 0.9rem;">
                            Selamat datang, <strong>{{ Auth::user()->name }}</strong>!
                        </div>
                    </div>
                    @endguest
                </div>

                <!-- Right Section -->
                <div class="footer-right">
                    <ul class="footer-links">
                        <li><a href="{{ url('/refundPolicy') }}">Refund Policy</a></li>
                        <hr class="footer-divider">
                        <li><a href="{{ url('/howToOrder') }}">How To Order</a></li>
                        <hr class="footer-divider">
                        <li><a href="{{ url('/about') }}">About</a></li>
                        <hr class="footer-divider">
                        <li><a href="{{ url('/paymentConfirmation') }}">Payment Confirmation</a></li>
                        <hr class="footer-divider">
                        <li class="copy">Copyright © 2025 MANEVIZ</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('open');

            if (mobileMenu.classList.contains('open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        }

        // User dropdown toggle
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const userDropdown = document.querySelector('.user-dropdown');

            if (userDropdown && !userDropdown.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Close mobile menu on outside click
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');

            if (mobileMenu && !mobileMenu.contains(event.target) &&
                mobileMenuToggle && !mobileMenuToggle.contains(event.target)) {
                mobileMenu.classList.remove('open');
                document.body.style.overflow = '';
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            const dropdown = document.getElementById('userDropdown');

            if (window.innerWidth > 768) {
                if (mobileMenu) mobileMenu.classList.remove('open');
                document.body.style.overflow = '';
            }

            if (dropdown) dropdown.classList.remove('show');
        });

        // Handle escape key press
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const mobileMenu = document.getElementById('mobileMenu');
                if (mobileMenu) mobileMenu.classList.remove('open');

                const dropdown = document.getElementById('userDropdown');
                if (dropdown) dropdown.classList.remove('show');

                document.body.style.overflow = '';
            }
        });

        // Animate footer elements on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -30px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe footer elements
            document.querySelectorAll('.footer-main > *').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'all 0.6s ease';
                observer.observe(el);
            });

            // Add click handlers for social icons
            document.querySelectorAll('.social-icon').forEach(icon => {
                icon.addEventListener('click', function(e) {
                    e.preventDefault();
                    const platform = this.getAttribute('title');
                    console.log(`${platform} social icon clicked`);
                });
            });
        });

        // Dynamic cart count update function
        function updateCartCount(count) {
            const cartBadge = document.getElementById('cartCount');
            if (cartBadge) {
                cartBadge.textContent = count;
                if (count === 0) {
                    cartBadge.style.display = 'none';
                } else {
                    cartBadge.style.display = 'flex';
                }
            }
        }

        // Profile icon link update based on authentication
        function updateProfileLink(isAuthenticated, profileUrl = '/profil', loginUrl = '/signin') {
            const profileIcon = document.getElementById('profileIcon');
            const mobileProfileIcon = document.querySelector('.mobile-profile-icon');

            if (profileIcon) {
                profileIcon.href = isAuthenticated ? profileUrl : loginUrl;
                profileIcon.title = isAuthenticated ? 'Profile' : 'Sign In';
            }

            if (mobileProfileIcon) {
                mobileProfileIcon.href = isAuthenticated ? profileUrl : loginUrl;
                mobileProfileIcon.title = isAuthenticated ? 'Profile' : 'Sign In';
            }
        }
    </script>
</body>

</html>
