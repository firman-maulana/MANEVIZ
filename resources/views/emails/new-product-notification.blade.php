<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Baru Tersedia</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .header .emoji {
            font-size: 40px;
            margin-bottom: 10px;
            display: block;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 20px;
        }
        
        .product-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            background: linear-gradient(45deg, #f7fafc 0%, #edf2f7 100%);
            text-align: center;
        }
        
        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .product-name {
            font-size: 24px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }
        
        .product-category {
            color: #718096;
            font-size: 16px;
            margin-bottom: 15px;
        }
        
        .product-description {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .price-section {
            margin: 20px 0;
        }
        
        .price {
            font-size: 28px;
            font-weight: 700;
            color: #e53e3e;
            margin-right: 10px;
        }
        
        .original-price {
            font-size: 18px;
            color: #718096;
            text-decoration: line-through;
        }
        
        .sale-badge {
            background: #e53e3e;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .cta-section {
            text-align: center;
            margin: 35px 0;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            margin: 10px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-secondary {
            background: #edf2f7;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .features {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
        }
        
        .features h3 {
            margin-top: 0;
            color: #2d3748;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            padding: 5px 0;
            color: #4a5568;
        }
        
        .feature-list li:before {
            content: "✓";
            color: #48bb78;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .footer {
            background-color: #2d3748;
            color: #cbd5e0;
            text-align: center;
            padding: 25px;
            font-size: 14px;
        }
        
        .footer a {
            color: #81e6d9;
            text-decoration: none;
        }
        
        .social-links {
            margin: 15px 0;
        }
        
        .social-links a {
            margin: 0 10px;
            font-size: 18px;
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .content {
                padding: 25px 20px;
            }
            
            .product-card {
                padding: 20px;
            }
            
            .product-image {
                width: 150px;
                height: 150px;
            }
            
            .btn {
                display: block;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <span class="emoji">🎉</span>
            <h1>Produk Baru Tersedia!</h1>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $userName }}</strong>! 👋
            </div>
            
            <p>Kami dengan senang hati ingin memperkenalkan produk terbaru yang baru saja ditambahkan ke koleksi kami!</p>
            
            <!-- Product Card -->
            <div class="product-card">
                @if($primaryImage)
                    <img src="{{ $primaryImage }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image" style="background: linear-gradient(45deg, #e2e8f0, #cbd5e0); display: flex; align-items: center; justify-content: center; color: #718096; font-size: 18px;">
                        📦 Gambar Produk
                    </div>
                @endif
                
                <div class="product-name">{{ $product->name }}</div>
                
                @if($product->category)
                    <div class="product-category">📂 {{ $product->category->name }}</div>
                @endif
                
                @if($product->deskripsi_singkat)
                    <div class="product-description">{{ $product->deskripsi_singkat }}</div>
                @endif
                
                <div class="price-section">
                    @if($product->is_on_sale)
                        <span class="price">IDR {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                        <span class="original-price">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
                        <span class="sale-badge">SALE!</span>
                    @else
                        <span class="price">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
                    @endif
                </div>
                
                @if($product->stock_kuantitas > 0)
                    <div style="color: #48bb78; font-weight: 600; margin: 10px 0;">
                        ✅ Stok Tersedia ({{ $product->stock_kuantitas }} unit)
                    </div>
                @else
                    <div style="color: #e53e3e; font-weight: 600; margin: 10px 0;">
                        ⚠️ Stok Terbatas
                    </div>
                @endif
            </div>
            
            <!-- Features (if available) -->
            @if($product->meta_data && is_array($product->meta_data) && count($product->meta_data) > 0)
                <div class="features">
                    <h3>🌟 Keunggulan Produk:</h3>
                    <ul class="feature-list">
                        @foreach($product->meta_data as $key => $value)
                            <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- CTA Section -->
            <div class="cta-section">
                <a href="{{ $productUrl }}" class="btn btn-primary">
                    🛒 Lihat Detail Produk
                </a>
                <a href="{{ $allProductsUrl }}" class="btn btn-secondary">
                    📱 Jelajahi Semua Produk
                </a>
            </div>
            
            <p style="color: #718096; font-size: 14px; text-align: center; margin-top: 30px;">
                <em>Jangan sampai kehabisan! Produk terbaru ini sangat populer dan stok terbatas. 
                Segera kunjungi toko kami untuk mendapatkan penawaran terbaik.</em>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div>
                <strong>Terima kasih telah menjadi bagian dari keluarga kami! ❤️</strong>
            </div>
            
            <div class="social-links">
                <a href="#">📘 Facebook</a>
                <a href="#">📷 Instagram</a>
                <a href="#">🐦 Twitter</a>
            </div>
            
            <div style="margin-top: 15px; font-size: 12px; color: #a0aec0;">
                <p>Anda menerima email ini karena Anda adalah member terdaftar di toko kami.</p>
                <p>Jika tidak ingin menerima notifikasi produk baru, silakan 
                   <a href="#" style="color: #81e6d9;">kelola preferensi email</a> Anda.</p>
            </div>
        </div>
    </div>
</body>
</html>