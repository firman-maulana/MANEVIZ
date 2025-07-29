@extends('layouts.app2')

@section('content')

<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        background: white;
        padding: 40px;
        margin-top: 40px;
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

    .hidden {
        display: none;
    }

    .highlight {
        font-weight: bold;
        text-transform: uppercase;
    }

    .step {
        margin-bottom: 12px;
    }
</style>
<div class="container">
    <div class="header">
        <h1 class="title" id="page-title">HOW TO ORDER</h1>
    </div>

    <div class="language-selector">
        <button class="lang-btn active" onclick="setLanguage('id')" id="btn-id">Bahasa Indonesia</button>
        <button class="lang-btn" onclick="setLanguage('en')" id="btn-en">English</button>
    </div>

    <!-- Indonesian Content -->
    <div id="content-id" class="language-content">
        <div class="section">
            <h2 class="section-title">CARA PEMESANAN</h2>
            <div class="content">
                <div class="step">
                    <p>Pilih barang yang ingin Anda beli di halaman <span class="highlight">SHOP</span>, kemudian klik item yang ingin dibeli ke halaman <span class="highlight">PRODUCT</span>.</p>
                </div>
                <div class="step">
                    <p>Isi jumlah produk pada kolom <span class="highlight">QUANTITY</span>, lalu klik <span class="highlight">ADD TO CART</span>. Ketika <span class="highlight">CART</span> sudah terisi, Anda dapat memperbarui keranjang (menghapus item yang tidak diinginkan) atau mengubah jumlah kuantitas di halaman <span class="highlight">SHOPPING CART</span>.</p>
                </div>
                <div class="step">
                    <p>Isi informasi formulir pada halaman <span class="highlight">ORDER DETAIL</span>. Jika Anda ingin memberikan instruksi khusus pada pesanan Anda, silakan tulis di kolom <span class="highlight">NOTE</span> yang disediakan di bagian bawah halaman <span class="highlight">ORDER DETAIL</span>.</p>
                </div>
                <div class="step">
                    <p>Setelah selesai, Anda akan mendapatkan <span class="highlight">E-MAIL</span> berisi <span class="highlight">INVOICE</span> dan <span class="highlight">PAYMENT CONFIRMATION CODE</span>.</p>
                </div>
                <div class="step">
                    <p>Silakan lanjutkan ke pembayaran melalui bank yang disediakan (<span class="highlight">BCA</span>). Sertakan <span class="highlight">PAYMENT CONFIRMATION CODE</span> saat melakukan pembayaran baik melalui <span class="highlight">ATM</span> atau <span class="highlight">INTERNET BANKING</span>.</p>
                </div>
                <div class="step">
                    <p>Setelah pembayaran selesai, silakan konfirmasi dengan menyertakan <span class="highlight">PAYMENT CONFIRMATION CODE</span>. Kami akan memvalidasi status pembayaran dan mengirimkan barang yang dipesan.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- English Content -->
    <div id="content-en" class="language-content hidden">
        <div class="section">
            <h2 class="section-title">HOW TO ORDER</h2>
            <div class="content">
                <div class="step">
                    <p>Choose the item that you would like to purchase at the <span class="highlight">SHOP</span> page, and then click the item to proceed to the <span class="highlight">PRODUCT</span> page.</p>
                </div>
                <div class="step">
                    <p>Fill in the number of products on the <span class="highlight">QUANTITY</span> column, and then click <span class="highlight">ADD TO CART</span>. When the <span class="highlight">CART</span> is filled, you can update the cart (deleting unwanted items) or change the number of quantity on the <span class="highlight">SHOPPING CART</span> page.</p>
                </div>
                <div class="step">
                    <p>Fill the information form on the <span class="highlight">ORDER DETAIL</span> page. If you want to make a certain instruction on your order, please note on the <span class="highlight">NOTE</span> column provided on the bottom of the <span class="highlight">ORDER DETAIL</span> page.</p>
                </div>
                <div class="step">
                    <p>Once completed, you will get an <span class="highlight">E-MAIL</span> with <span class="highlight">INVOICE</span> and <span class="highlight">PAYMENT CONFIRMATION CODE</span>.</p>
                </div>
                <div class="step">
                    <p>Please proceed to payment via the provided bank (<span class="highlight">BCA</span>). Include the <span class="highlight">PAYMENT CONFIRMATION CODE</span> when making the payment either through <span class="highlight">ATM</span> or <span class="highlight">INTERNET BANKING</span>.</p>
                </div>
                <div class="step">
                    <p>After the payment is done, please confirm it by including the <span class="highlight">PAYMENT CONFIRMATION CODE</span>. We will validate the payment status and ship the ordered items.</p>
                </div>
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
            pageTitle.textContent = 'CARA PEMESANAN';
            document.documentElement.lang = 'id';
        } else {
            pageTitle.textContent = 'HOW TO ORDER';
            document.documentElement.lang = 'en';
        }
    }
</script>
@endsection