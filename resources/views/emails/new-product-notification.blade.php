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
            color: #111111;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e5e5;
        }
        
        .header {
            background: #000000;
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
            color: #111111;
            margin-bottom: 20px;
        }
        
        .product-card {
            border: 1px solid #d1d1d1;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            background: #f5f5f5;
            text-align: center;
        }
        
        .product-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
        }
        
        .product-name {
            font-size: 22px;
            font-weight: 700;
            color: #000000;
            margin-bottom: 10px;
        }
        
        .product-category {
            color: #555555;
            font-size: 15px;
            margin-bottom: 15px;
        }
        
        .product-description {
            color: #333333;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .price-section {
            margin: 20px 0;
        }
        
        .price {
            font-size: 24px;
            font-weight: 700;
            color: #000000;
            margin-right: 10px;
        }
        
        .original-price {
            font-size: 16px;
            color: #777777;
            text-decoration: line-through;
        }
        
        .sale-badge {
            background: #000000;
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
            padding: 12px 28px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            margin: 8px;
        }
        
        .btn-primary {
            background: #000000;
            color: white;
        }
        
        .btn-secondary {
            background: white;
            color: #000000;
            border: 1px solid #000000;
        }
        
        .btn:hover {
            opacity: 0.85;
        }
        
        .features {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            border: 1px solid #e5e5e5;
        }
        
        .features h3 {
            margin-top: 0;
            color: #111111;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
        }
        
        .feature-list li {
            padding: 5px 0;
            color: #333333;
        }
        
        .feature-list li:before {
            content: "✓";
            color: #000000;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .footer {
            background-color: #000000;
            color: #cccccc;
            text-align: center;
            padding: 25px;
            font-size: 14px;
        }
        
        .footer a {
            color: #ffffff;
            text-decoration: underline;
        }
        
        .social-links {
            margin: 15px 0;
        }
        
        .social-links a {
            margin: 0 10px;
            font-size: 16px;
            color: white;
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
            <span class="emoji">🖤</span>
            <h1>Produk Baru Tersedia!</h1>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $userName }}</strong>! 👋
            </div>
            
            <p>Kami ingin memperkenalkan produk terbaru yang baru saja ditambahkan ke koleksi kami.</p>
            
            <!-- Product Card -->
            <div class="product-card">
                @if($primaryImage)
                    <img src="{{ $primaryImage }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <div class="product-image" style="background:#e5e5e5; display:flex; align-items:center; justify-content:center; color:#555; font-size:16px;">
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
                        <span class="sale-badge">SALE</span>
                    @else
                        <span class="price">IDR {{ number_format($product->harga, 0, ',', '.') }}</span>
                    @endif
                </div>
                
                @if($product->stock_kuantitas > 0)
                    <div style="color:#000; font-weight:600; margin:10px 0;">
                        ✅ Stok Tersedia ({{ $product->stock_kuantitas }} unit)
                    </div>
                @else
                    <div style="color:#000; font-weight:600; margin:10px 0;">
                        ⚠️ Stok Terbatas
                    </div>
                @endif
            </div>
            
            <!-- Features -->
            @if($product->meta_data && is_array($product->meta_data) && count($product->meta_data) > 0)
                <div class="features">
                    <h3>Keunggulan Produk:</h3>
                    <ul class="feature-list">
                        @foreach($product->meta_data as $key => $value)
                            <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- CTA -->
            <div class="cta-section">
                <a href="{{ $productUrl }}" class="btn btn-primary">
                    🛒 Lihat Detail Produk
                </a>
                <a href="{{ $allProductsUrl }}" class="btn btn-secondary">
                    📱 Jelajahi Semua Produk
                </a>
            </div>
            
            <p style="color: #555; font-size: 13px; text-align: center; margin-top: 30px;">
                <em>Jangan sampai kehabisan! Produk terbaru ini sangat populer dan stok terbatas.</em>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div>
                <strong>Terima kasih telah menjadi bagian dari keluarga kami! 🖤</strong>
            </div>
            
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
                <a href="#">Twitter</a>
            </div>
            
            <div style="margin-top: 15px; font-size: 12px; color: #aaa;">
                <p>Anda menerima email ini karena Anda adalah member terdaftar di toko kami.</p>
                <p>Jika tidak ingin menerima notifikasi produk baru, silakan 
                   <a href="#">kelola preferensi email</a>.</p>
            </div>
        </div>
    </div>
</body>
</html>
