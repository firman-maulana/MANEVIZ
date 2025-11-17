@extends('layouts.app2')

@section('content')
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
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .checkout-header {
        text-align: center;
        margin: 100px 0 40px;
    }

    .checkout-title {
        font-size: 2.5rem;
        font-weight: bold;
        text-transform: uppercase;
        color: #333;
        margin-bottom: 10px;
    }

    .checkout-subtitle {
        color: #6c757d;
        font-size: 1.1rem;
    }

    .checkout-content {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 40px;
        margin-top: 40px;
    }

    .checkout-form {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .form-section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
        border-bottom: 2px solid #f8f9fa;
        padding-bottom: 10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .form-input:focus,
    .form-select:focus {
        outline: none;
        border-color: #333;
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 15px 0;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #333;
    }

    .checkbox-label {
        font-size: 14px;
        color: #333;
        cursor: pointer;
    }

    .address-section {
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .address-selector {
        margin-bottom: 20px;
    }

    .address-option {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .address-option:hover {
        border-color: #333;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .address-option.selected {
        border-color: #333;
        background-color: #f8f9fa;
    }

    .address-option input[type="radio"] {
        position: absolute;
        top: 15px;
        right: 15px;
        transform: scale(1.2);
        accent-color: #333;
    }

    .address-name {
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .address-label {
        background-color: #333;
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 12px;
        margin-left: 10px;
    }

    .address-details {
        color: #666;
        font-size: 14px;
        margin-bottom: 5px;
        line-height: 1.4;
    }

    .add-address-btn {
        display: inline-block;
        background-color: #333;
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: background-color 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .add-address-btn:hover {
        background-color: #555;
        text-decoration: none;
        color: white;
    }

    .manual-address-form {
        display: none;
        border-top: 2px solid #f8f9fa;
        padding-top: 20px;
        margin-top: 20px;
    }

    .manual-address-form.show {
        display: block;
    }

    .shipping-calculator {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }

    .shipping-options {
        display: none;
        margin-top: 15px;
    }

    .shipping-options.show {
        display: block;
    }

    .shipping-option {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .shipping-option:hover {
        border-color: #333;
    }

    .shipping-option.selected {
        border-color: #007bff;
        background-color: #e7f3ff;
    }

    .shipping-option input[type="radio"] {
        margin-right: 10px;
    }

    .shipping-info {
        flex: 1;
    }

    .shipping-service {
        font-weight: 600;
        color: #333;
    }

    .shipping-description {
        font-size: 12px;
        color: #666;
    }

    .shipping-cost {
        font-weight: bold;
        color: #007bff;
    }

    .loading-indicator {
        text-align: center;
        padding: 20px;
        color: #666;
    }

    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 10px;
    }

    .order-summary {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        height: fit-content;
        position: sticky;
        top: 20px;
    }

    .summary-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
        border-bottom: 2px solid #f8f9fa;
        padding-bottom: 10px;
    }

    .order-item {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .item-image {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        background: #f8f9fa;
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        margin-bottom: 5px;
    }

    .item-options {
        display: flex;
        gap: 10px;
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    .item-price {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .summary-row.total {
        font-weight: bold;
        font-size: 18px;
        padding-top: 15px;
        border-top: 2px solid #f8f9fa;
        margin-top: 20px;
        color: #333;
    }

    .pay-now-btn {
        width: 100%;
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        border: none;
        padding: 16px;
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    .pay-now-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
    }

    .pay-now-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .payment-info {
        background: #e3f2fd;
        border: 1px solid #bbdefb;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        text-align: center;
    }

    .payment-info h5 {
        color: #1976d2;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .payment-info p {
        color: #424242;
        margin: 0;
        font-size: 14px;
    }

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 14px;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .back-to-cart {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 20px;
        transition: color 0.3s ease;
    }

    .back-to-cart:hover {
        color: #333;
        text-decoration: none;
    }

    .payment-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 10000;
    }

    .payment-modal.show {
        display: flex;
    }

    .payment-modal-content {
        background: white;
        border-radius: 16px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }

    .loading-content {
        text-align: center;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 12px;
        color: white;
        z-index: 10001;
        font-weight: 500;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateX(400px);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        max-width: 350px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notification.success {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .notification.error {
        background: linear-gradient(135deg, #dc3545, #e74c3c);
    }

    .notification.show {
        transform: translateX(0);
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @media (max-width: 768px) {
        .checkout-content {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <div class="checkout-header">
        <h1 class="checkout-title">Checkout</h1>
        <p class="checkout-subtitle">Complete your order with secure payment</p>
    </div>

    <a href="{{ route('cart.index') }}" class="back-to-cart">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m12 19-7-7 7-7" />
        </svg>
        Back to Cart
    </a>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Please correct the following errors:</strong>
        <ul style="margin: 10px 0 0 20px;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="checkout-content">
        <div class="checkout-form">
            <form id="checkoutForm">
                @csrf

                <input type="hidden" name="items" value="{{ $selectedItems->pluck('id')->implode(',') }}">
                <input type="hidden" name="shipping_district_id" id="shippingDistrictId">
                <input type="hidden" name="courier_code" id="courierCode">
                <input type="hidden" name="courier_service" id="courierService">
                <input type="hidden" name="shipping_cost" id="shippingCostInput" value="0">

                <div class="form-section">
                    <h3 class="section-title">Shipping Information</h3>

                    <div class="address-section">
                        @if($userAddresses->count() > 0)
                        <div class="address-selector">
                            <label class="form-label">Select Address</label>
                            @foreach($userAddresses as $address)
                            <div class="address-option {{ $defaultAddress && $defaultAddress->id === $address->id ? 'selected' : '' }}"
                                onclick="selectAddress({{ $address->id }}, {{ $address->district_id ?? 'null' }})">
                                <input type="radio" name="selected_address" value="{{ $address->id }}"
                                    {{ $defaultAddress && $defaultAddress->id === $address->id ? 'checked' : '' }}
                                    data-district-id="{{ $address->district_id }}">

                                <div class="address-name">
                                    {{ $address->recipient_name }}
                                    @if($address->label)
                                    <span class="address-label">{{ $address->label }}</span>
                                    @endif
                                    @if($address->is_default)
                                    <span class="address-label" style="background-color: #28a745;">Default</span>
                                    @endif
                                </div>

                                <div class="address-details">
                                    {{ $address->address }}<br>
                                    {{ $address->district_name ?? '' }}{{ $address->district_name ? ', ' : '' }}{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}<br>
                                    Phone: {{ $address->user->phone ?? 'No phone' }}
                                </div>
                            </div>
                            @endforeach

                            <div class="address-option" onclick="selectManualAddress()">
                                <input type="radio" name="selected_address" value="manual" id="manualAddressRadio">
                                <div class="address-name">Use different address</div>
                                <div class="address-details">Enter a new address for this order</div>
                            </div>
                        </div>
                        @else
                        <p style="color: #6c757d; margin-bottom: 20px;">
                            You don't have any saved addresses. Please add an address first.
                        </p>
                        <a href="{{ route('address.create') }}" class="add-address-btn">
                            Add Your First Address
                        </a>
                        @endif

                        <div class="manual-address-form" id="manualAddressForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="shipping_name" class="form-input"
                                        value="{{ old('shipping_name', auth()->user()->name) }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="shipping_email" class="form-input"
                                        value="{{ old('shipping_email', auth()->user()->email) }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" name="shipping_phone" class="form-input"
                                    value="{{ old('shipping_phone', auth()->user()->phone ?? '') }}" placeholder="08xxxxxxxxxx">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Province *</label>
                                <select name="shipping_province_id" id="provinceSelectManual" class="form-select">
                                    <option value="">Select Province</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">City *</label>
                                <select name="shipping_city_id" id="citySelectManual" class="form-select" disabled>
                                    <option value="">Select City</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">District *</label>
                                <select name="shipping_district_id_select" id="districtSelectManual" class="form-select" disabled>
                                    <option value="">Select District</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Address *</label>
                                <textarea name="shipping_address" class="form-input form-textarea"
                                    placeholder="Street address, building, apartment, etc.">{{ old('shipping_address') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Postal Code *</label>
                                <input type="text" name="shipping_postal_code" class="form-input"
                                    value="{{ old('shipping_postal_code') }}" maxlength="10">
                            </div>

                            <input type="hidden" name="shipping_province" id="provinceNameManual">
                            <input type="hidden" name="shipping_city" id="cityNameManual">
                        </div>
                    </div>

                    <div class="shipping-calculator">
                        <h4 style="margin-bottom: 15px;">Calculate Shipping Cost</h4>

                        <div class="form-group">
                            <label class="form-label">Select Courier</label>
                            <select id="courierSelect" class="form-select">
                                <option value="">Choose courier service</option>
                                <option value="jne">JNE</option>
                                <option value="tiki">TIKI</option>
                                <option value="pos">POS Indonesia</option>
                                <option value="jnt">J&T Express</option>
                                <option value="sicepat">SiCepat</option>
                                <option value="anteraja">AnterAja</option>
                            </select>
                        </div>

                        <button type="button" id="calculateShippingBtn" class="add-address-btn" style="width: 100%; text-align: center;">
                            Calculate Shipping
                        </button>

                        <div class="shipping-options" id="shippingOptions">
                            <div id="shippingResults"></div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">Billing Information</h3>

                    <div class="checkbox-group">
                        <input type="checkbox" id="same_as_shipping" name="same_as_shipping" value="1" checked onchange="toggleBillingFields()">
                        <label for="same_as_shipping" class="checkbox-label">Same as shipping address</label>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="section-title">Order Notes (Optional)</h3>
                    <div class="form-group">
                        <textarea name="notes" class="form-input form-textarea"
                            placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="order-summary">
            <h3 class="summary-title">Order Summary</h3>

            <!-- Weight Information Box -->
            <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); border-radius: 12px; padding: 16px; margin-bottom: 20px; border-left: 4px solid #0284c7;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2.5">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                    </svg>
                    <span style="font-weight: 700; color: #0c4a6e; font-size: 15px;">Total Weight</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: baseline; flex-wrap: wrap; gap: 8px;">
                    <span style="color: #0369a1; font-size: 13px; font-weight: 500;">Total berat pesanan</span>
                    <div style="text-align: right;">
                        <div style="font-weight: 800; color: #0284c7; font-size: 20px; line-height: 1.2;">
                            {{ number_format($totalWeightKg, 2) }} kg
                        </div>
                        <div style="color: #0369a1; font-size: 11px; margin-top: 2px;">
                            ({{ number_format($totalWeight) }} gram)
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items List -->
            @foreach($selectedItems as $item)
            <div class="order-item">
                <div class="item-image">
                    @if($item->product->images && $item->product->images->isNotEmpty())
                    <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" alt="{{ $item->product->name }}">
                    @else
                    <img src="{{ asset('images/no-image.png') }}" alt="No Image">
                    @endif
                </div>
                <div class="item-details">
                    <div class="item-name">{{ $item->product->name }}</div>
                    <div class="item-options">
                        @if($item->size)
                        <span>Size: {{ $item->size }}</span>
                        @endif
                        @php
                        $itemWeight = $item->product->berat ?? 1000;
                        // Auto-convert if stored in kg
                        if ($itemWeight > 0 && $itemWeight < 100) {
                            $itemWeight=$itemWeight * 1000;
                            }
                            $itemWeightKg=$itemWeight / 1000;
                            $totalItemWeight=$itemWeight * $item->kuantitas;
                            $totalItemWeightKg = $totalItemWeight / 1000;
                            @endphp
                            <span style="color: #6b7280;">
                                • {{ number_format($itemWeightKg, 2) }} kg
                                @if($item->kuantitas > 1)
                                <span style="font-size: 11px; color: #9ca3af;">
                                    ({{ number_format($totalItemWeightKg, 2) }} kg total)
                                </span>
                                @endif
                            </span>
                    </div>
                    <div class="item-price">
                        <span>Qty: {{ $item->kuantitas }}</span>
                        <span><strong>IDR {{ number_format(($item->product->harga_jual ?? $item->product->harga) * $item->kuantitas, 0, ',', '.') }}</strong></span>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Summary Totals -->
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotalDisplay">IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Tax (2.5%)</span>
                <span id="taxDisplay">IDR {{ number_format($tax, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <span id="shippingCostDisplay">IDR 0</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="grandTotalDisplay">IDR {{ number_format($subtotal + $tax, 0, ',', '.') }}</span>
            </div>

            <div class="payment-info">
                <h5>Secure Payment</h5>
                <p>Choose from various payment methods after confirming your order.</p>
            </div>

            <button type="button" id="payNowBtn" class="pay-now-btn" disabled>
                <span class="btn-text">Select Shipping First</span>
            </button>
        </div>
    </div>
</div>

<div id="paymentModal" class="payment-modal">
    <div class="payment-modal-content">
        <div id="loadingContent" class="loading-content">
            <div class="loading-spinner"></div>
            <h3>Preparing Payment...</h3>
            <p>Please wait while we set up your secure payment.</p>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadProvincesManual();
        setupManualAddressListeners();
        setupShippingCalculator();
        setupPayNowButton();
        // Initialize grand total on page load
        updateGrandTotal();
    });

    // =====================
    // ADDRESS SELECTION
    // =====================
    function selectAddress(addressId, districtId) {
        document.querySelectorAll('.address-option').forEach(opt => opt.classList.remove('selected'));
        event.currentTarget.classList.add('selected');
        const radio = event.currentTarget.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;

        const manualForm = document.getElementById('manualAddressForm');
        if (manualForm) manualForm.classList.remove('show');

        if (districtId) document.getElementById('shippingDistrictId').value = districtId;

        resetShippingOptions();
    }

    function selectManualAddress() {
        document.querySelectorAll('.address-option').forEach(opt => opt.classList.remove('selected'));
        event.currentTarget.classList.add('selected');

        const manualRadio = document.getElementById('manualAddressRadio');
        if (manualRadio) manualRadio.checked = true;

        const manualForm = document.getElementById('manualAddressForm');
        if (manualForm) manualForm.classList.add('show');

        document.getElementById('shippingDistrictId').value = '';
        resetShippingOptions();
    }

    // =====================
    // MANUAL ADDRESS FORM
    // =====================
    function setupManualAddressListeners() {
        const provinceSelect = document.getElementById('provinceSelectManual');
        const citySelect = document.getElementById('citySelectManual');
        const districtSelect = document.getElementById('districtSelectManual');

        if (provinceSelect) {
            provinceSelect.addEventListener('change', function() {
                const provinceId = this.value;
                const provinceName = this.options[this.selectedIndex]?.dataset.name || '';
                document.getElementById('provinceNameManual').value = provinceName;

                citySelect.innerHTML = '<option value="">Select City</option>';
                citySelect.disabled = true;
                districtSelect.innerHTML = '<option value="">Select District</option>';
                districtSelect.disabled = true;

                if (provinceId) loadCitiesManual(provinceId);
            });
        }

        if (citySelect) {
            citySelect.addEventListener('change', function() {
                const cityId = this.value;
                const cityName = this.options[this.selectedIndex]?.dataset.name || '';
                document.getElementById('cityNameManual').value = cityName;

                districtSelect.innerHTML = '<option value="">Select District</option>';
                districtSelect.disabled = true;

                if (cityId) loadDistrictsManual(cityId);
            });
        }

        if (districtSelect) {
            districtSelect.addEventListener('change', function() {
                const districtId = this.value;
                document.getElementById('shippingDistrictId').value = districtId;
                resetShippingOptions();
            });
        }
    }

    // =====================
    // LOAD PROVINCES
    // =====================
    function loadProvincesManual() {
        fetch('/api/rajaongkir/provinces')
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('provinceSelectManual');
                if (!select) return;

                select.innerHTML = '<option value="">Select Province</option>';

                if (data.success && data.data) {
                    data.data.forEach(province => {
                        const id = province.province_id || province.id || province.code;
                        const name = province.province || province.province_name || province.name;
                        const option = document.createElement('option');
                        option.value = id;
                        option.text = name;
                        option.dataset.name = name;
                        select.appendChild(option);
                    });
                    select.disabled = false;
                } else {
                    showNotification('error', 'No provinces found');
                }
            })
            .catch(err => {
                console.error('Failed to load provinces:', err);
                showNotification('error', 'Failed to load provinces');
            });
    }

    // =====================
    // LOAD CITIES
    // =====================
    function loadCitiesManual(provinceId) {
        fetch(`/api/rajaongkir/cities/${provinceId}`)
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('citySelectManual');
                if (!select) return;

                select.innerHTML = '<option value="">Select City</option>';

                if (data.success && data.data) {
                    data.data.forEach(city => {
                        const id = city.city_id || city.id;
                        const name = city.city_name || city.name;
                        const option = document.createElement('option');
                        option.value = id;
                        option.text = name;
                        option.dataset.name = name;
                        select.appendChild(option);
                    });
                    select.disabled = false;
                } else {
                    showNotification('error', 'No cities found');
                }
            })
            .catch(err => {
                console.error('Failed to load cities:', err);
                showNotification('error', 'Failed to load cities');
            });
    }

    // =====================
    // LOAD DISTRICTS
    // =====================
    function loadDistrictsManual(cityId) {
        fetch(`/api/rajaongkir/districts/${cityId}`)
            .then(res => res.json())
            .then(data => {
                const select = document.getElementById('districtSelectManual');
                if (!select) return;

                select.innerHTML = '<option value="">Select District</option>';

                if (data.success && data.data) {
                    data.data.forEach(dist => {
                        const id = dist.subdistrict_id || dist.id;
                        const name = dist.subdistrict_name || dist.name;
                        const option = document.createElement('option');
                        option.value = id;
                        option.text = name;
                        select.appendChild(option);
                    });
                    select.disabled = false;
                } else {
                    showNotification('error', 'No districts found');
                }
            })
            .catch(err => {
                console.error('Failed to load districts:', err);
                showNotification('error', 'Failed to load districts');
            });
    }

    // =====================
    // SHIPPING CALCULATOR
    // =====================
    function setupShippingCalculator() {
        const calculateBtn = document.getElementById('calculateShippingBtn');
        if (calculateBtn) {
            calculateBtn.addEventListener('click', calculateShipping);
        }
    }

    function calculateShipping() {
        const districtId = document.getElementById('shippingDistrictId').value;
        const courier = document.getElementById('courierSelect').value;
        const totalWeight = {{$totalWeight}};

        if (!districtId) {
            showNotification('error', 'Please select a shipping address first');
            return;
        }

        if (!courier) {
            showNotification('error', 'Please select a courier service');
            return;
        }

        const resultsDiv = document.getElementById('shippingResults');
        resultsDiv.innerHTML = '<div class="loading-indicator"><div class="loading-spinner"></div> Calculating shipping cost...</div>';
        document.getElementById('shippingOptions').classList.add('show');

        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const formData = new FormData();
        formData.append('destination_district_id', districtId);
        formData.append('weight', totalWeight);
        formData.append('courier', courier);

        fetch('/api/rajaongkir/check-ongkir', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Network response was not ok');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.data) {
                    const costs = Array.isArray(data.data) ? data.data : [];

                    if (costs.length > 0) {
                        displayShippingOptions(costs, courier);
                        showNotification('success', 'Shipping options loaded successfully');
                    } else {
                        resultsDiv.innerHTML = `
                            <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 20px; text-align: center;">
                                <p style="color: #856404; margin: 0 0 10px 0; font-weight: 600;">
                                    ⚠️ No shipping service available
                                </p>
                                <p style="color: #856404; margin: 0; font-size: 13px;">
                                    ${courier.toUpperCase()} doesn't serve this destination or weight.<br>
                                    Please try another courier service.
                                </p>
                            </div>
                        `;
                        showNotification('error', 'No shipping options for ' + courier.toUpperCase());
                    }
                } else {
                    resultsDiv.innerHTML = '<p style="color: #dc3545; text-align: center; padding: 15px;">Invalid response from shipping API</p>';
                    showNotification('error', 'Failed to get shipping options');
                }
            })
            .catch(error => {
                console.error('Shipping calculation error:', error);
                resultsDiv.innerHTML = `
                    <div style="background: #f8d7da; border: 1px solid #dc3545; border-radius: 8px; padding: 20px; text-align: center;">
                        <p style="color: #721c24; margin: 0 0 10px 0; font-weight: 600;">
                            ❌ Failed to calculate shipping
                        </p>
                        <p style="color: #721c24; margin: 0; font-size: 13px;">
                            ${error.message}
                        </p>
                    </div>
                `;
                showNotification('error', 'Failed to calculate shipping cost');
            });
    }

    function displayShippingOptions(services, courierCode) {
        const resultsDiv = document.getElementById('shippingResults');
        let html = '';

        services.forEach((service, index) => {
            let serviceName, description, costValue, etd;

            if (service.name || service.service) {
                serviceName = service.service || service.name || service.code || 'Unknown Service';
                description = service.description || '';
                costValue = service.cost || 0;
                etd = service.etd || '';
            } else if (service.cost && Array.isArray(service.cost) && service.cost.length > 0) {
                serviceName = service.service || service.service_name || 'Unknown Service';
                description = service.description || service.service_description || '';
                costValue = service.cost[0].value || 0;
                etd = service.cost[0].etd || '';
            } else {
                serviceName = service.service_name || service.type || 'Unknown Service';
                description = service.service_description || service.desc || '';
                costValue = service.value || service.price || 0;
                etd = service.etd || service.estimation || '';
            }

            if (costValue > 0) {
                const etdDisplay = etd ? ` (${etd} days)` : '';
                const descDisplay = description ? description : serviceName;

                html += `
                <div class="shipping-option" onclick="selectShipping('${courierCode}', '${serviceName}', ${costValue}, '${description}')">
                    <input type="radio" name="shipping_service" value="${serviceName}" id="ship_${index}">
                    <div class="shipping-info">
                        <div class="shipping-service">${courierCode.toUpperCase()} - ${serviceName}</div>
                        <div class="shipping-description">${descDisplay}${etdDisplay}</div>
                    </div>
                    <div class="shipping-cost">IDR ${formatNumber(costValue)}</div>
                </div>
            `;
            }
        });

        if (html === '') {
            resultsDiv.innerHTML = `
                <div style="background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 20px; text-align: center;">
                    <p style="color: #856404; margin: 0 0 10px 0;">⚠️ No valid shipping options found</p>
                </div>
            `;
        } else {
            resultsDiv.innerHTML = html;
        }
    }

    // =====================
    // SELECT SHIPPING - FIXED VERSION
    // =====================
    function selectShipping(courierCode, serviceName, cost, description) {
        console.log('=== SELECT SHIPPING ===');
        console.log('Courier:', courierCode);
        console.log('Service:', serviceName);
        console.log('Cost:', cost);

        // Remove selected class from all options
        document.querySelectorAll('.shipping-option').forEach(option => {
            option.classList.remove('selected');
        });

        // Add selected class to clicked option
        event.currentTarget.classList.add('selected');

        // Check the radio button
        const radio = event.currentTarget.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;

        // Update hidden form inputs
        document.getElementById('courierCode').value = courierCode;
        document.getElementById('courierService').value = serviceName;
        document.getElementById('shippingCostInput').value = cost;

        // Update shipping cost display
        document.getElementById('shippingCostDisplay').textContent = 'IDR ' + formatNumber(cost);

        console.log('Shipping cost input value:', document.getElementById('shippingCostInput').value);

        // ⭐⭐⭐ UPDATE GRAND TOTAL - THIS IS THE MAIN FIX! ⭐⭐⭐
        updateGrandTotal();

        console.log('Grand total after update:', document.getElementById('grandTotalDisplay').textContent);

        // Enable Pay Now button
        const payBtn = document.getElementById('payNowBtn');
        payBtn.disabled = false;
        payBtn.querySelector('.btn-text').textContent = 'Pay Now';

        showNotification('success', `${courierCode.toUpperCase()} - ${serviceName} selected`);
    }

    // =====================
    // RESET SHIPPING OPTIONS
    // =====================
    function resetShippingOptions() {
        document.getElementById('shippingOptions').classList.remove('show');
        document.getElementById('shippingResults').innerHTML = '';
        document.getElementById('courierSelect').value = '';
        document.getElementById('shippingCostDisplay').textContent = 'IDR 0';
        document.getElementById('shippingCostInput').value = '0';
        document.getElementById('courierCode').value = '';
        document.getElementById('courierService').value = '';

        const payBtn = document.getElementById('payNowBtn');
        payBtn.disabled = true;
        payBtn.querySelector('.btn-text').textContent = 'Select Shipping First';

        updateGrandTotal();
        console.log('Grand total after reset:', document.getElementById('grandTotalDisplay').textContent);
    }

    // =====================
// UPDATE GRAND TOTAL - FINAL VERSION
// =====================
function updateGrandTotal() {
    console.log('=== UPDATE GRAND TOTAL ===');

    // Get subtotal and tax elements by their new IDs
    const subtotalElement = document.getElementById('subtotalDisplay'); // <-- Ambil dari ID
    const taxElement = document.getElementById('taxDisplay');           // <-- Ambil dari ID

    if (!subtotalElement || !taxElement) {
        console.error('Cannot find subtotal or tax display elements');
        return;
    }

    // Parse values using the parsePrice function
    const subtotal = parsePrice(subtotalElement.textContent); // <-- Ambil nilai Subtotal
    const tax = parsePrice(taxElement.textContent);           // <-- Ambil nilai Tax

    // Get shipping cost from the hidden input field
    const shippingCostInput = document.getElementById('shippingCostInput');
    let shippingCost = 0;
    if (shippingCostInput) {
        shippingCost = Number(shippingCostInput.value) || 0; // Gunakan Number() lebih aman
    } else {
        console.error('Cannot find shippingCostInput element');
        // Jika elemen tidak ditemukan, tetap lanjutkan dengan 0
    }

    console.log('Parsed Subtotal:', subtotal);
    console.log('Parsed Tax:', tax);
    console.log('Parsed Shipping Cost:', shippingCost);

    // Calculate grand total
    const grandTotal = subtotal + tax + shippingCost; // <-- Hitung total akhir
    console.log('Calculated Grand Total:', grandTotal);

    // Update the display for the grand total
    const grandTotalDisplay = document.getElementById('grandTotalDisplay');
    if (grandTotalDisplay) {
        grandTotalDisplay.textContent = 'IDR ' + formatNumber(grandTotal); // <-- Update tampilan
        console.log('Updated Grand Total Display to:', grandTotalDisplay.textContent);
    } else {
        console.error('Cannot find grandTotalDisplay element');
    }
}

    // =====================
    // PAYMENT HANDLING
    // =====================
    function setupPayNowButton() {
        const payBtn = document.getElementById('payNowBtn');
        if (payBtn) {
            payBtn.addEventListener('click', handlePayment);
        }
    }

    function handlePayment() {
        const districtId = document.getElementById('shippingDistrictId').value;
        const shippingCost = document.getElementById('shippingCostInput').value;
        const courierCode = document.getElementById('courierCode').value;
        const courierService = document.getElementById('courierService').value;

        console.log('=== HANDLE PAYMENT ===');
        console.log('District ID:', districtId);
        console.log('Shipping Cost:', shippingCost);
        console.log('Courier:', courierCode);
        console.log('Service:', courierService);

        if (!districtId) {
            showNotification('error', 'Please select a shipping address');
            return;
        }

        if (!shippingCost || shippingCost === '0') {
            showNotification('error', 'Please select a shipping method');
            return;
        }

        if (!courierCode || !courierService) {
            showNotification('error', 'Please select a shipping service');
            return;
        }

        document.getElementById('paymentModal').classList.add('show');

        const form = document.getElementById('checkoutForm');
        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Log form data
        console.log('Form Data:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ':', value);
        }

        fetch('/checkout/create-payment', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Payment response:', data);

                if (data.success && data.snap_token) {
                    document.getElementById('paymentModal').classList.remove('show');

                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Payment Success:', result);
                            handleMidtransCallback(data.order_number, result.transaction_id || result.order_id);
                        },
                        onPending: function(result) {
                            console.log('Payment Pending:', result);
                            window.location.href = '/checkout/success/' + data.order_number;
                        },
                        onError: function(result) {
                            console.error('Payment Error:', result);
                            showNotification('error', 'Payment failed. Please try again.');
                        },
                        onClose: function() {
                            showNotification('error', 'Payment cancelled');
                        }
                    });
                } else {
                    document.getElementById('paymentModal').classList.remove('show');
                    showNotification('error', data.message || 'Payment creation failed');
                }
            })
            .catch(error => {
                console.error('Payment error:', error);
                document.getElementById('paymentModal').classList.remove('show');
                showNotification('error', 'An error occurred. Please try again.');
            });
    }

    // Handle Midtrans callback
    function handleMidtransCallback(orderNumber, transactionId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        fetch('/checkout/handle-payment', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                order_number: orderNumber,
                transaction_id: transactionId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect_url;
            } else {
                showNotification('error', data.message || 'Failed to process payment');
                setTimeout(() => {
                    window.location.href = '/checkout/success/' + orderNumber;
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Callback error:', error);
            window.location.href = '/checkout/success/' + orderNumber;
        });
    }

    // =====================
    // UTILITY FUNCTIONS
    // =====================
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function parsePrice(priceText) {
        // Remove "IDR", spaces, dots (thousand separator)
        // Keep only digits
        return parseInt(priceText.replace(/[^\d]/g, '')) || 0;
    }

    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            ${type === 'success' ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>' : '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>'}
        </svg>
        <span>${message}</span>
    `;
        document.body.appendChild(notification);

        setTimeout(() => notification.classList.add('show'), 100);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    function toggleBillingFields() {
        const checkbox = document.getElementById('same_as_shipping');
        const billingFields = document.getElementById('billingFields');

        if (billingFields) {
            if (checkbox.checked) {
                billingFields.style.display = 'none';
            } else {
                billingFields.style.display = 'block';
            }
        }
    }
</script>

@endsection
