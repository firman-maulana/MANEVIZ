@extends('layouts.app2')

@section('content')

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
        line-height: 1.5;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 15px;
    }

    .cart-header {
        padding: 20px 0;
    }

    .cart-title {
        font-size: 23px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-align: center;
        margin-top: 60px;
    }

    .cart-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-top: -30px;
        margin-bottom: 25px;
    }

    .cart-items {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }

    .empty-cart h3 {
        margin-bottom: 15px;
        font-size: 1.5rem;
    }

    .empty-cart a {
        color: #333;
        text-decoration: none;
        font-weight: 500;
    }

    .cart-item {
        display: grid;
        grid-template-columns: auto 80px 1fr auto;
        grid-template-rows: auto auto;
        gap: 15px;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
        align-items: flex-start;
        position: relative;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-checkbox {
        grid-column: 1;
        grid-row: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #333;
    }

    .item-image {
        grid-column: 2;
        grid-row: 1 / 3;
        width: 80px;
        height: 80px;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* 🔥 DISCOUNT BADGE IN CART */
    .cart-discount-badge {
        position: absolute;
        top: 4px;
        left: 4px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 8px;
        font-weight: 700;
        z-index: 2;
        box-shadow: 0 2px 6px rgba(255, 107, 107, 0.3);
    }

    .item-details {
        grid-column: 3;
        grid-row: 1;
        min-width: 0;
    }

    .item-name {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 8px;
        text-transform: uppercase;
        color: #333;
    }

    .item-options {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .option-group {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .option-circle {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #000;
        border: 2px solid #ddd;
        flex-shrink: 0;
    }

    .option-text {
        font-size: 10px;
        color: #666;
        text-transform: uppercase;
    }

    /* 🔥 PRICE WITH DISCOUNT STYLES */
    .item-price-container {
        display: flex;
        flex-direction: column;
        gap: 4px;
        align-items: flex-end;
    }

    .item-price-original {
        color: #999;
        font-size: 12px;
        text-decoration: line-through;
        font-weight: 400;
    }

    .item-price-final {
        font-size: 16px;
        font-weight: bold;
        color: #dc3545;
    }

    .item-price-regular {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .item-savings {
        color: #28a745;
        font-size: 10px;
        font-weight: 600;
    }

    .move-to-favorites {
        color: #666;
        font-size: 9px;
        text-transform: uppercase;
        text-decoration: none;
        transition: color 0.2s;
    }

    .move-to-favorites:hover {
        color: #333;
    }

    .item-controls {
        grid-column: 3 / 5;
        grid-row: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
    }

    .remove-btn {
        background: none;
        border: none;
        font-size: 20px;
        color: #999;
        cursor: pointer;
        padding: 5px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .remove-btn:hover {
        color: #dc3545;
        background-color: #f8f9fa;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        border: 1px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
    }

    .quantity-btn {
        background: none;
        border: none;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.2s;
    }

    .quantity-btn:hover {
        background-color: #f8f9fa;
    }

    .quantity-input {
        border: none;
        width: 40px;
        text-align: center;
        font-size: 14px;
        padding: 6px 0;
        background: transparent;
    }

    .item-price {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .order-summary {
        background: white;
        border-radius: 12px;
        padding: 25px;
        height: fit-content;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        position: sticky;
        top: 20px;
    }

    .summary-title {
        font-size: 15px;
        font-weight: bold;
        text-transform: uppercase;
        margin-bottom: 20px;
        color: #666;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }

    /* 🔥 DISCOUNT SUMMARY ROW */
    .summary-row.discount {
        color: #28a745;
        font-weight: 600;
    }

    .summary-row.total {
        font-weight: bold;
        font-size: 16px;
        padding-top: 15px;
        border-top: 1px solid #e9ecef;
        margin-top: 15px;
    }

    /* 🔥 SAVINGS INFO BOX */
    .savings-box {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        border: 1px solid #28a745;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .savings-box svg {
        width: 20px;
        height: 20px;
        color: #28a745;
        flex-shrink: 0;
    }

    .savings-text {
        flex: 1;
    }

    .savings-amount {
        font-weight: bold;
        color: #155724;
        font-size: 16px;
    }

    .savings-label {
        font-size: 12px;
        color: #155724;
        margin-top: 2px;
    }

    .checkout-btn {
        width: 100%;
        background-color: #333;
        color: white;
        border: none;
        padding: 15px;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        cursor: pointer;
        margin-top: 20px;
        border-radius: 8px;
        transition: all 0.3s;
    }

    /* Tablet styles */
    @media (min-width: 768px) {
        .container {
            padding: 20px;
        }

        .cart-content {
            grid-template-columns: 2fr 1fr;
        }

        .cart-title {
            text-align: left;
        }

        .cart-item {
            grid-template-columns: auto 120px 1fr auto;
            grid-template-rows: auto;
            gap: 20px;
            padding: 25px;
            align-items: center;
        }

        .item-checkbox {
            grid-row: 1;
        }

        .item-image {
            grid-row: 1;
            width: 120px;
            height: 120px;
        }

        .item-details {
            grid-row: 1;
        }

        .item-controls {
            grid-column: 4;
            grid-row: 1;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
            margin-top: 0;
            min-height: 120px;
        }

        .quantity-controls {
            order: 2;
        }

        .item-price-container {
            order: 3;
        }

        .remove-btn {
            order: 1;
        }

        .cart-discount-badge {
            top: 6px;
            left: 6px;
            padding: 3px 8px;
            font-size: 9px;
        }
    }

    /* Mobile styles */
    @media (max-width: 767px) {
        .container {
            padding: 10px;
        }

        .cart-header {
            padding: 15px 0;
            margin-bottom: 15px;
        }

        .cart-item {
            padding: 15px;
            gap: 12px;
        }

        .item-name {
            font-size: 14px;
        }

        .option-text {
            font-size: 11px;
        }

        .move-to-favorites {
            font-size: 10px;
        }

        .item-price-final,
        .item-price-regular {
            font-size: 14px;
        }

        .item-price-original {
            font-size: 11px;
        }

        .item-savings {
            font-size: 9px;
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .quantity-input {
            width: 35px;
            font-size: 12px;
        }

        .order-summary {
            padding: 20px;
            margin-top: 10px;
        }

        .savings-box {
            padding: 10px;
        }

        .savings-amount {
            font-size: 14px;
        }
    }

    /* Small mobile styles */
    @media (max-width: 480px) {
        .cart-item {
            grid-template-columns: 1fr;
            grid-template-rows: auto auto auto auto;
            text-align: left;
            gap: 15px;
            padding: 15px;
        }

        .item-checkbox {
            grid-column: 1;
            grid-row: 1;
            justify-self: start;
        }

        .item-image {
            grid-column: 1;
            grid-row: 2;
            justify-self: center;
            width: 100px;
            height: 100px;
        }

        .item-details {
            grid-column: 1;
            grid-row: 3;
            text-align: center;
        }

        .item-controls {
            grid-column: 1;
            grid-row: 4;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
        }

        .remove-btn {
            order: 3;
        }

        .quantity-controls {
            order: 1;
        }

        .item-price-container {
            order: 2;
            align-items: center;
        }

        .cart-discount-badge {
            top: 4px;
            left: 4px;
            padding: 2px 5px;
            font-size: 7px;
        }
    }


    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        padding: 20px;
    }

    .modal-overlay.show {
        opacity: 1;
    }

    .modal-container {
        transform: scale(0.9);
        transition: transform 0.3s ease;
    }

    .modal-overlay.show .modal-container {
        transform: scale(1);
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        padding: 35px 30px;
        max-width: 420px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        text-align: center;
    }

    .modal-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        animation: modalIconPop 0.5s ease;
    }

    @keyframes modalIconPop {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .modal-icon svg {
        width: 35px;
        height: 35px;
        stroke-width: 2.5;
    }

    .modal-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .modal-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .modal-product-preview {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
        text-align: left;
    }

    .modal-product-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        background: white;
    }

    .modal-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .modal-product-info {
        flex: 1;
        min-width: 0;
    }

    .modal-product-name {
        font-size: 13px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .modal-product-details {
        font-size: 11px;
        color: #666;
    }

    .modal-actions {
        display: flex;
        gap: 12px;
    }

    .modal-btn {
        flex: 1;
        padding: 14px 20px;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modal-btn-cancel {
        background: #f8f9fa;
        color: #666;
        border: 2px solid #e9ecef;
    }

    .modal-btn-cancel:hover {
        background: #e9ecef;
        color: #333;
        transform: translateY(-2px);
    }

    .modal-btn-delete {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
    }

    .modal-btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
    }

    .modal-btn-delete:active {
        transform: translateY(0);
    }

    /* Loading state */
    .modal-btn.loading {
        position: relative;
        color: transparent;
        pointer-events: none;
    }

    .modal-btn.loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spinner 0.6s linear infinite;
    }

    @keyframes spinner {
        to {
            transform: rotate(360deg);
        }
    }

    /* Mobile responsive */
    @media (max-width: 480px) {
        .modal-content {
            padding: 30px 20px;
        }

        .modal-icon {
            width: 60px;
            height: 60px;
        }

        .modal-icon svg {
            width: 30px;
            height: 30px;
        }

        .modal-title {
            font-size: 20px;
        }

        .modal-description {
            font-size: 13px;
        }

        .modal-actions {
            flex-direction: column-reverse;
        }

        .modal-btn {
            width: 100%;
        }
    }
</style>

<div class="cart-header">
    <div class="container">
        <h1 class="cart-title">Shopping Cart</h1>
    </div>
</div>

<div class="container">
    <div class="cart-content">
        <div class="cart-items">
            @if($cartItems->count() > 0)
            @foreach($cartItems as $item)
            @php
            $product = $item->product;
            $hasDiscount = $product->hasActiveDiscount() || $product->is_on_sale;
            $finalPrice = $product->final_price;
            $originalPrice = $product->getOriginalPrice();
            $discountAmount = $hasDiscount ? $product->getDiscountAmount() : 0;
            $itemTotal = $finalPrice * $item->kuantitas;
            @endphp
            <div class="cart-item" data-cart-id="{{ $item->id }}">
                <div class="item-checkbox">
                    <input type="checkbox"
                        class="cart-checkbox"
                        data-price="{{ $finalPrice }}"
                        data-original-price="{{ $originalPrice }}"
                        data-has-discount="{{ $hasDiscount ? 'true' : 'false' }}"
                        data-discount-amount="{{ $discountAmount }}"
                        data-quantity="{{ $item->kuantitas }}"
                        checked>
                </div>
                <div class="item-image">
                    @if($product->images && $product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}">
                    @else
                    <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                    @endif

                    @if($hasDiscount)
                    <div class="cart-discount-badge">
                        {{ $product->getDiscountLabel() }}
                    </div>
                    @endif
                </div>
                <div class="item-details">
                    <h3 class="item-name">{{ $product->name }}</h3>
                    <div class="item-options">
                        @if($item->color)
                        <div class="option-group">
                            <div class="option-circle" style="background-color: {{ $item->color === 'Black' ? '#000' : ($item->color === 'White' ? '#fff' : '#6c757d') }}; {{ $item->color === 'White' ? 'border: 2px solid #ddd;' : '' }}"></div>
                            <span class="option-text">{{ $item->color }}</span>
                        </div>
                        @endif
                        @if($item->size)
                        <div class="option-group">
                            <span class="option-text">{{ $item->size }}</span>
                        </div>
                        @endif
                    </div>
                    <a href="#" class="move-to-favorites">Move to Favorites</a>
                </div>
                <div class="item-controls">
                    <button class="remove-btn" onclick="removeItem({{ $item->id }})">&times;</button>
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="decreaseQuantity({{ $item->id }})">-</button>
                        <input type="text" class="quantity-input" value="{{ $item->kuantitas }}" readonly>
                        <button class="quantity-btn" onclick="increaseQuantity({{ $item->id }})">+</button>
                    </div>
                    <div class="item-price-container">
                        @if($hasDiscount)
                        <span class="item-price-original">IDR {{ number_format($originalPrice * $item->kuantitas, 0, ',', '.') }}</span>
                        <span class="item-price-final">IDR {{ number_format($itemTotal, 0, ',', '.') }}</span>
                        <span class="item-savings">Save IDR {{ number_format($discountAmount * $item->kuantitas, 0, ',', '.') }}</span>
                        @else
                        <span class="item-price-regular">IDR {{ number_format($itemTotal, 0, ',', '.') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="empty-cart">
                <h3>Keranjang Belanja Kosong</h3>
                <p>Belum ada produk di keranjang Anda.</p>
                <a href="{{ route('products.index') }}">Mulai Belanja Sekarang</a>
            </div>
            @endif
        </div>

        @if($cartItems->count() > 0)
        <div class="order-summary">
            <h3 class="summary-title">Order Summary</h3>

            <!-- 🔥 SAVINGS BOX -->
            <div class="savings-box" id="savingsBox" style="display: none;">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z" />
                </svg>
                <div class="savings-text">
                    <div class="savings-amount" id="totalSavings">IDR 0</div>
                    <div class="savings-label">Total Savings</div>
                </div>
            </div>

            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotal">IDR 0</span>
            </div>
            <div class="summary-row discount" id="discountRow" style="display: none;">
                <span>Discount</span>
                <span id="discount">-IDR 0</span>
            </div>
            <div class="summary-row">
                <span>Tax (2.5%)</span>
                <span id="tax">IDR 0</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="total">IDR 0</span>
            </div>
            <button class="checkout-btn" onclick="proceedToCheckout()">Checkout</button>
        </div>
        @endif
    </div>

    <div id="deleteModal" class="modal-overlay" style="display: none;">
        <div class="modal-container">
            <div class="modal-content">
                <div class="modal-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6" />
                    </svg>
                </div>
                <h3 class="modal-title">Remove Item?</h3>
                <p class="modal-description">Are you sure you want to remove this item from your cart?</p>
                <div class="modal-product-preview" id="modalProductPreview">
                    <!-- Product info will be inserted here -->
                </div>
                <div class="modal-actions">
                    <button class="modal-btn modal-btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                    <button class="modal-btn modal-btn-delete" id="confirmDeleteBtn">Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ==========================================
    // QUANTITY MANAGEMENT FUNCTIONS
    // ==========================================
    function increaseQuantity(cartId) {
        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
        const quantityInput = cartItem.querySelector('.quantity-input');
        const currentValue = parseInt(quantityInput.value);

        updateQuantity(cartId, currentValue + 1);
    }

    function decreaseQuantity(cartId) {
        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
        const quantityInput = cartItem.querySelector('.quantity-input');
        const currentValue = parseInt(quantityInput.value);

        if (currentValue > 1) {
            updateQuantity(cartId, currentValue - 1);
        }
    }

    function updateQuantity(cartId, newQuantity) {
        fetch(`/cart/update/${cartId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                kuantitas: newQuantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);
                const quantityInput = cartItem.querySelector('.quantity-input');
                const checkbox = cartItem.querySelector('.cart-checkbox');
                const priceContainer = cartItem.querySelector('.item-price-container');

                const hasDiscount = checkbox.dataset.hasDiscount === 'true';
                const finalPrice = parseFloat(checkbox.dataset.price);
                const originalPrice = parseFloat(checkbox.dataset.originalPrice);
                const discountAmount = parseFloat(checkbox.dataset.discountAmount);

                quantityInput.value = newQuantity;
                checkbox.setAttribute('data-quantity', newQuantity);

                // Update displayed prices
                if (hasDiscount) {
                    priceContainer.innerHTML = `
                        <span class="item-price-original">IDR ${(originalPrice * newQuantity).toLocaleString('id-ID')}</span>
                        <span class="item-price-final">IDR ${data.new_total.toLocaleString('id-ID')}</span>
                        <span class="item-savings">Save IDR ${(discountAmount * newQuantity).toLocaleString('id-ID')}</span>
                    `;
                } else {
                    priceContainer.innerHTML = `
                        <span class="item-price-regular">IDR ${data.new_total.toLocaleString('id-ID')}</span>
                    `;
                }

                updateOrderSummary();
                showNotification('success', data.message);
            } else {
                showNotification('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat mengupdate kuantitas');
        });
    }

    // ==========================================
    // DELETE MODAL FUNCTIONS
    // ==========================================
    let currentDeleteCartId = null;

    function openDeleteModal(cartId) {
        const modal = document.getElementById('deleteModal');
        const cartItem = document.querySelector(`[data-cart-id="${cartId}"]`);

        if (!cartItem) return;

        currentDeleteCartId = cartId;

        // Get product info
        const productName = cartItem.querySelector('.item-name').textContent;
        const productImage = cartItem.querySelector('.item-image img').src;
        const quantity = cartItem.querySelector('.quantity-input').value;

        // Get color and size safely
        const optionTexts = cartItem.querySelectorAll('.option-text');
        const color = optionTexts[0]?.textContent || '';
        const size = optionTexts[1]?.textContent || '';

        // Build product details
        let details = `Qty: ${quantity}`;
        if (color) details += ` • ${color}`;
        if (size) details += ` • ${size}`;

        // Insert product preview
        const preview = document.getElementById('modalProductPreview');
        preview.innerHTML = `
            <div class="modal-product-image">
                <img src="${productImage}" alt="${productName}">
            </div>
            <div class="modal-product-info">
                <div class="modal-product-name">${productName}</div>
                <div class="modal-product-details">${details}</div>
            </div>
        `;

        // Show modal with animation
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.classList.add('show');
        }, 10);

        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('show');

        setTimeout(() => {
            modal.style.display = 'none';
            currentDeleteCartId = null;
            document.body.style.overflow = '';
        }, 300);
    }

    function confirmDelete() {
        if (!currentDeleteCartId) return;

        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.classList.add('loading');

        fetch(`/cart/remove/${currentDeleteCartId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            confirmBtn.classList.remove('loading');

            if (data.success) {
                // Close modal
                closeDeleteModal();

                // Remove item with animation
                const cartItem = document.querySelector(`[data-cart-id="${currentDeleteCartId}"]`);
                cartItem.style.transition = 'all 0.3s ease';
                cartItem.style.transform = 'translateX(-100%)';
                cartItem.style.opacity = '0';

                setTimeout(() => {
                    cartItem.remove();
                    updateOrderSummary();
                    showNotification('success', data.message);

                    // Check if cart is empty
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        location.reload();
                    }
                }, 300);
            } else {
                closeDeleteModal();
                showNotification('error', data.message);
            }
        })
        .catch(error => {
            confirmBtn.classList.remove('loading');
            closeDeleteModal();
            console.error('Error:', error);
            showNotification('error', 'Terjadi kesalahan saat menghapus item');
        });
    }

    // Main remove item function (now uses modal)
    function removeItem(cartId) {
        openDeleteModal(cartId);
    }

    // ==========================================
    // ORDER SUMMARY UPDATE
    // ==========================================
    function updateOrderSummary() {
        const checkedItems = document.querySelectorAll('.cart-checkbox:checked');
        let subtotalBeforeDiscount = 0;
        let subtotal = 0;
        let totalDiscount = 0;

        checkedItems.forEach(checkbox => {
            const price = parseFloat(checkbox.getAttribute('data-price'));
            const originalPrice = parseFloat(checkbox.getAttribute('data-original-price'));
            const quantity = parseInt(checkbox.getAttribute('data-quantity'));
            const hasDiscount = checkbox.getAttribute('data-has-discount') === 'true';
            const discountAmount = parseFloat(checkbox.getAttribute('data-discount-amount'));

            subtotalBeforeDiscount += originalPrice * quantity;
            subtotal += price * quantity;

            if (hasDiscount) {
                totalDiscount += discountAmount * quantity;
            }
        });

        const tax = subtotal * 0.025;
        const total = subtotal + tax;

        // Update displays
        document.getElementById('subtotal').textContent = `IDR ${subtotalBeforeDiscount.toLocaleString('id-ID')}`;

        // Show/hide discount row
        const discountRow = document.getElementById('discountRow');
        const savingsBox = document.getElementById('savingsBox');

        if (totalDiscount > 0) {
            discountRow.style.display = 'flex';
            document.getElementById('discount').textContent = `-IDR ${Math.round(totalDiscount).toLocaleString('id-ID')}`;

            savingsBox.style.display = 'flex';
            document.getElementById('totalSavings').textContent = `IDR ${Math.round(totalDiscount).toLocaleString('id-ID')}`;
        } else {
            discountRow.style.display = 'none';
            savingsBox.style.display = 'none';
        }

        document.getElementById('tax').textContent = `IDR ${Math.round(tax).toLocaleString('id-ID')}`;
        document.getElementById('total').textContent = `IDR ${Math.round(total).toLocaleString('id-ID')}`;
    }

    // ==========================================
    // CHECKOUT FUNCTION
    // ==========================================
    function proceedToCheckout() {
        const checkedItems = document.querySelectorAll('.cart-checkbox:checked');

        if (checkedItems.length === 0) {
            showNotification('error', 'Pilih minimal satu item untuk checkout');
            return;
        }

        // Collect selected item IDs
        const selectedItemIds = Array.from(checkedItems).map(checkbox => {
            return checkbox.closest('.cart-item').getAttribute('data-cart-id');
        });

        // Redirect to checkout with selected items
        window.location.href = `/checkout?items=${selectedItemIds.join(',')}`;
    }

    // ==========================================
    // NOTIFICATION FUNCTION
    // ==========================================
    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            z-index: 10000;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            max-width: 350px;
            ${type === 'success' ? 'background: #28a745;' : 'background: #dc3545;'}
        `;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);

        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // ==========================================
    // EVENT LISTENERS & INITIALIZATION
    // ==========================================

    // Add event listeners for checkboxes
    document.querySelectorAll('.cart-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateOrderSummary);
    });

    // Modal event listeners
    document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);

    // Close modal when clicking overlay
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });

    // Initialize order summary on page load
    updateOrderSummary();
</script>
@endsection
