@extends('layouts.app2')

@section('content')

    <style>
        

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            margin-top: 30px;
        }

        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .language-selector {
            margin: 20px 0;
            display: flex;
            gap: 10px;
        }

        .lang-btn {
            padding: 8px 16px;
            border: 2px solid #333;
            background: white;
            color: #333;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .lang-btn.active {
            background: #333;
            color: white;
        }

        .lang-btn:hover {
            background: #555;
            color: white;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }

        .content {
            font-size: 13px;
            color: #444;
            line-height: 1.8;
        }

        .content p {
            margin-bottom: 12px;
        }

        .email-link {
            color: #0066cc;
            text-decoration: none;
        }

        .email-link:hover {
            text-decoration: underline;
        }

        .hidden {
            display: none;
        }

        .highlight {
            font-weight: bold;
        }
    </style>
    <div class="container">
        <div class="header">
            <h1 class="title" id="page-title">REFUND POLICY</h1>
        </div>

        <div class="language-selector">
            <button class="lang-btn active" onclick="setLanguage('id')" id="btn-id">Bahasa Indonesia</button>
            <button class="lang-btn" onclick="setLanguage('en')" id="btn-en">English</button>
        </div>

        <!-- Indonesian Content -->
        <div id="content-id" class="language-content">
            <div class="section">
                <h2 class="section-title">KEBIJAKAN PENGEMBALIAN DANA</h2>
                <div class="content">
                    <p>Barang harus dikembalikan dalam waktu 5 hari setelah barang diterima.</p>
                    <p>Barang harus memiliki kondisi asli seperti yang diserahkan saat penerimaan.</p>
                    <p>Kami berhak untuk menolak pengembalian dana atau penukaran apabila barang tersebut telah berubah bentuk, terjadi kerusakan, dicuci atau kedalamguannya akibat hal yang disebabkan.</p>
                    <p>Anda tidak dapat melakukan atau pengembalian dana untuk barang yang tidak memenuhi kriteria pengembalian. Jika anda menerima produk yang mengalami kerusakan atau cacat pada saat penerimaan pengiriman silahkan memberikan pemberitahuan terlebih dahulu dalam waktu 2 hari setelah anda menerima produk melalui email <a href="mailto:website@materialdesaster.com" class="email-link">website@materialdesaster.com</a> sebelum mengirim barang kembali.</p>
                    <p>Anda dapat mengggunakan jasa pengiriman lain untuk pengembalian barang. Untuk memastikan kami menerima barang yang anda kirim silahkan meminta nomor pelacakan dari pengirim dan konfirmasikan kepada kami lagi melalui email <a href="mailto:website@materialdesaster.com" class="email-link">website@materialdesaster.com</a> beserta nomor <span class="highlight">KONFIRMASI PEMBAYARAN</span> anda.</p>
                    <p>Kemasa kembali barang pengembalian anda dengan aman.</p>
                    <p>Kirim barang pengembalian anda ke alamat: Material Desaster Jl. Wira Angun Angun No 4. Bandung.</p>
                    <p>Barang baru akan di kirim setelah kami menerima barang penukaran anda dan mengkonfirmasi pengembalian atau penukaran anda.</p>
                    <p>Kami tidak bertanggungjawab atas kehilangan barang pengembalian saat pengiriman kembali.</p>
                    <p>Biaya pengiriman awal tidak dapat dikembalikan.</p>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">KEBIJAKAN PENUKARAN BARANG</h2>
                <div class="content">
                    <p>Kami hanya dapat menukar barang yang terspat kerusakan atau cacat tidak menerima penukaran size.</p>
                    <p>Apabila barang yang bersinggungan telah habis, dana akan dikembalikan penuh dikurangi biaya pengiriman awal setelah kami menerima pengembalian barang anda.</p>
                    <p>Kami tidak bertanggungjawab atas kehilangan barang pengembalian saat pengiriman kembali.</p>
                </div>
            </div>
        </div>

        <!-- English Content -->
        <div id="content-en" class="language-content hidden">
            <div class="section">
                <h2 class="section-title">REFUND POLICY</h2>
                <div class="content">
                    <p>Items must be returned within 5 days after receiving the goods.</p>
                    <p>Items must be in original condition as delivered upon receipt.</p>
                    <p>We reserve the right to refuse refunds or exchanges if the item has changed shape, been damaged, washed or compromised due to circumstances caused by the customer.</p>
                    <p>You cannot make a refund for items that do not meet the return criteria. If you receive a product that is damaged or defective upon delivery, please provide notification within 2 days after receiving the product via email <a href="mailto:website@materialdesaster.com" class="email-link">website@materialdesaster.com</a> before sending the item back.</p>
                    <p>You may use other shipping services for item returns. To ensure we receive the items you send, please request a tracking number from the sender and confirm it to us again via email <a href="mailto:website@materialdesaster.com" class="email-link">website@materialdesaster.com</a> along with your <span class="highlight">PAYMENT CONFIRMATION</span> number.</p>
                    <p>Please repack your return items safely.</p>
                    <p>Send your return items to the address: Material Desaster Jl. Wira Angun Angun No 4. Bandung.</p>
                    <p>New items will only be shipped after we receive your exchange items and confirm your return or exchange.</p>
                    <p>We are not responsible for lost return items during return shipping.</p>
                    <p>Initial shipping costs cannot be refunded.</p>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">EXCHANGE POLICY</h2>
                <div class="content">
                    <p>We can only exchange items that are damaged or defective. We do not accept size exchanges.</p>
                    <p>If the replacement item is out of stock, a full refund will be provided minus the initial shipping cost after we receive your returned item.</p>
                    <p>We are not responsible for lost return items during return shipping.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setLanguage(lang) {
            // Hide all language content
            const allContent = document.querySelectorAll('.language-content');
            allContent.forEach(content => content.classList.add('hidden'));
            
            // Show selected language content
            document.getElementById(`content-${lang}`).classList.remove('hidden');
            
            // Update active button
            const allButtons = document.querySelectorAll('.lang-btn');
            allButtons.forEach(btn => btn.classList.remove('active'));
            document.getElementById(`btn-${lang}`).classList.add('active');
            
            // Update page title
            const pageTitle = document.getElementById('page-title');
            if (lang === 'id') {
                pageTitle.textContent = 'KEBIJAKAN PENGEMBALIAN';
                document.documentElement.lang = 'id';
            } else {
                pageTitle.textContent = 'REFUND POLICY';
                document.documentElement.lang = 'en';
            }
        }
    </script>
@endsection