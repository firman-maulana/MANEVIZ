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
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
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

    .form-input, .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s ease;
    }

    .form-input:focus, .form-select:focus {
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
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
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
        box-shadow: 0 4px 15px rgba(0,123,255,0.3);
    }

    .pay-now-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,123,255,0.4);
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
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
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
        to { transform: rotate(360deg); }
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
            <path d="m12 19-7-7 7-7"/>
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
                                <select name="shipping_province_id" id="provinceSelect" class="form-select">
                                    <option value="">Select Province</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">City *</label>
                                <select name="shipping_city_id" id="citySelect" class="form-select" disabled>
                                    <option value="">Select City</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">District *</label>
                                <select name="shipping_district_id_select" id="districtSelect" class="form-select" disabled>
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

                            <input type="hidden" name="shipping_province" id="provinceName">
                            <input type="hidden" name="shipping_city" id="cityName">
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
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
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
                                    $itemWeight = $itemWeight * 1000;
                                }
                                $itemWeightKg = $itemWeight / 1000;
                                $totalItemWeight = $itemWeight * $item->kuantitas;
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
                <span>IDR {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>Tax (2.5%)</span>
                <span>IDR {{ number_format($tax, 0, ',', '.') }}</span>
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
let selectedShippingCost = 0;
const subtotal = {{ $subtotal }};
const tax = {{ $tax }};
const totalWeight = {{ $totalWeight }};

document.addEventListener('DOMContentLoaded', function() {
    // Load provinces untuk manual address form
    loadProvinces();
    
    @if($defaultAddress && $defaultAddress->district_id)
        document.getElementById('shippingDistrictId').value = {{ $defaultAddress->district_id }};
    @endif
});

function loadProvinces() {
    fetch('/api/rajaongkir/provinces')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('provinceSelect');
                data.data.forEach(province => {
                    const option = new Option(province.province, province.province_id);
                    option.setAttribute('data-name', province.province);
                    select.add(option);
                });
            }
        })
        .catch(error => {
            console.error('Failed to load provinces:', error);
            showNotification('error', 'Failed to load provinces');
        });
}

document.getElementById('provinceSelect').addEventListener('change', function() {
    const provinceId = this.value;
    const provinceName = this.options[this.selectedIndex].getAttribute('data-name');
    document.getElementById('provinceName').value = provinceName;
    
    const citySelect = document.getElementById('citySelect');
    citySelect.innerHTML = '<option value="">Select City</option>';
    citySelect.disabled = !provinceId;
    
    const districtSelect = document.getElementById('districtSelect');
    districtSelect.innerHTML = '<option value="">Select District</option>';
    districtSelect.disabled = true;
    
    if (provinceId) {
        fetch(`/api/rajaongkir/cities/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.data.forEach(city => {
                        const option = new Option(city.city_name, city.city_id);
                        option.setAttribute('data-name', city.city_name);
                        citySelect.add(option);
                    });
                }
            })
            .catch(error => {
                console.error('Failed to load cities:', error);
                showNotification('error', 'Failed to load cities');
            });
    }
});

document.getElementById('citySelect').addEventListener('change', function() {
    const cityId = this.value;
    const cityName = this.options[this.selectedIndex].getAttribute('data-name');
    document.getElementById('cityName').value = cityName;
    
    const districtSelect = document.getElementById('districtSelect');
    districtSelect.innerHTML = '<option value="">Select District</option>';
    districtSelect.disabled = !cityId;
    
    if (cityId) {
        fetch(`/api/rajaongkir/districts/${cityId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    data.data.forEach(district => {
                        const option = new Option(district.subdistrict_name, district.subdistrict_id);
                        districtSelect.add(option);
                    });
                }
            })
            .catch(error => {
                console.error('Failed to load districts:', error);
                showNotification('error', 'Failed to load districts');
            });
    }
});

document.getElementById('districtSelect').addEventListener('change', function() {
    document.getElementById('shippingDistrictId').value = this.value;
});

function selectAddress(addressId, districtId) {
    document.querySelectorAll('.address-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    event.currentTarget.classList.add('selected');
    event.currentTarget.querySelector('input[type="radio"]').checked = true;
    
    document.getElementById('manualAddressForm').classList.remove('show');
    
    if (districtId) {
        document.getElementById('shippingDistrictId').value = districtId;
    }
    
    resetShipping();
}

function selectManualAddress() {
    document.querySelectorAll('.address-option').forEach(option => {
        option.classList.remove('selected');
    });
    
    event.currentTarget.classList.add('selected');
    document.getElementById('manualAddressRadio').checked = true;
    document.getElementById('manualAddressForm').classList.add('show');
    document.getElementById('shippingDistrictId').value = '';
    
    resetShipping();
}

function resetShipping() {
    selectedShippingCost = 0;
    document.getElementById('shippingCostInput').value = '0';
    document.getElementById('shippingCostDisplay').textContent = 'IDR 0';
    document.getElementById('courierCode').value = '';
    document.getElementById('courierService').value = '';
    document.getElementById('shippingOptions').classList.remove('show');
    document.getElementById('shippingResults').innerHTML = '';
    updateGrandTotal();
    updatePayButton();
}

document.getElementById('calculateShippingBtn').addEventListener('click', function() {
    const districtId = document.getElementById('shippingDistrictId').value;
    const courier = document.getElementById('courierSelect').value;
    
    if (!districtId) {
        showNotification('error', 'Please select a shipping address first');
        return;
    }
    
    if (!courier) {
        showNotification('error', 'Please select a courier');
        return;
    }
    
    const resultsDiv = document.getElementById('shippingResults');
    resultsDiv.innerHTML = '<div class="loading-indicator"><span class="loading-spinner"></span>Calculating shipping cost...</div>';
    document.getElementById('shippingOptions').classList.add('show');
    
    fetch('/api/rajaongkir/calculate-cost', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            destination_district_id: districtId,
            weight: totalWeight,
            courier: courier
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data.length > 0) {
            displayShippingOptions(data.data[0]);
        } else {
            resultsDiv.innerHTML = '<p style="color: #dc3545; text-align: center; padding: 10px;">No shipping options available for this destination</p>';
        }
    })
    .catch(error => {
        console.error('Shipping calculation error:', error);
        resultsDiv.innerHTML = '<p style="color: #dc3545; text-align: center; padding: 10px;">Failed to calculate shipping cost. Please try again.</p>';
        showNotification('error', 'Failed to calculate shipping cost');
    });
});

function displayShippingOptions(courierData) {
    const resultsDiv = document.getElementById('shippingResults');
    let html = '';
    
    if (courierData.costs && courierData.costs.length > 0) {
        courierData.costs.forEach(service => {
            const cost = service.cost[0];
            html += `
                <div class="shipping-option" onclick="selectShipping('${courierData.code}', '${service.service}', ${cost.value}, '${service.description}')">
                    <input type="radio" name="shipping_service" value="${service.service}">
                    <div class="shipping-info">
                        <div class="shipping-service">${courierData.name} - ${service.service}</div>
                        <div class="shipping-description">${service.description} (${cost.etd} days)</div>
                    </div>
                    <div class="shipping-cost">IDR ${cost.value.toLocaleString('id-ID')}</div>
                </div>
            `;
        });
    } else {
        html = '<p style="color: #dc3545; text-align: center; padding: 10px;">No shipping services available</p>';
    }
    
    resultsDiv.innerHTML = html;
}

function selectShipping(courierCode, service, cost, description) {
    document.querySelectorAll('.shipping-option').forEach(opt => opt.classList.remove('selected'));
    event.currentTarget.classList.add('selected');
    event.currentTarget.querySelector('input[type="radio"]').checked = true;
    
    selectedShippingCost = cost;
    document.getElementById('shippingCostInput').value = cost;
    document.getElementById('courierCode').value = courierCode;
    document.getElementById('courierService').value = service;
    document.getElementById('shippingCostDisplay').textContent = 'IDR ' + cost.toLocaleString('id-ID');
    
    updateGrandTotal();
    updatePayButton();
}

function updateGrandTotal() {
    const grandTotal = subtotal + tax + selectedShippingCost;
    document.getElementById('grandTotalDisplay').textContent = 'IDR ' + grandTotal.toLocaleString('id-ID');
}

function updatePayButton() {
    const btn = document.getElementById('payNowBtn');
    const grandTotal = subtotal + tax + selectedShippingCost;
    
    if (selectedShippingCost > 0) {
        btn.disabled = false;
        btn.querySelector('.btn-text').textContent = 'Pay Now - IDR ' + grandTotal.toLocaleString('id-ID');
    } else {
        btn.disabled = true;
        btn.querySelector('.btn-text').textContent = 'Select Shipping First';
    }
}

function toggleBillingFields() {
    const checkbox = document.getElementById('same_as_shipping');
    const billingFields = document.getElementById('billing-fields');
    
    if (checkbox.checked && billingFields) {
        billingFields.style.display = 'none';
    } else if (billingFields) {
        billingFields.style.display = 'block';
    }
}

document.getElementById('payNowBtn').addEventListener('click', function() {
    const btn = this;
    
    const selectedAddress = document.querySelector('input[name="selected_address"]:checked');
    if (!selectedAddress) {
        showNotification('error', 'Please select a shipping address');
        return;
    }
    
    const districtId = document.getElementById('shippingDistrictId').value;
    if (!districtId) {
        showNotification('error', 'Please select a valid address with district information');
        return;
    }
    
    if (selectedShippingCost === 0) {
        showNotification('error', 'Please calculate and select shipping method');
        return;
    }
    
    if (selectedAddress.value === 'manual') {
        const form = document.getElementById('checkoutForm');
        const requiredFields = form.querySelectorAll('[name^="shipping_"]:not([type="hidden"])');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value && field.hasAttribute('required')) {
                isValid = false;
                field.style.borderColor = '#dc3545';
            } else {
                field.style.borderColor = '#e9ecef';
            }
        });
        
        if (!isValid) {
            showNotification('error', 'Please fill in all required fields');
            return;
        }
    }

    btn.classList.add('loading');
    btn.disabled = true;
    showPaymentModal();
    
    const formData = new FormData(document.getElementById('checkoutForm'));
    
    if (selectedAddress.value !== 'manual') {
        const addresses = @json($userAddresses ?? []);
        const address = addresses.find(addr => addr.id == selectedAddress.value);
        if (address) {
            formData.set('shipping_name', address.recipient_name);
            formData.set('shipping_email', '{{ auth()->user()->email ?? "" }}');
            formData.set('shipping_phone', '{{ auth()->user()->phone ?? "" }}');
            formData.set('shipping_address', address.address);
            formData.set('shipping_city', address.city);
            formData.set('shipping_province', address.province);
            formData.set('shipping_postal_code', address.postal_code);
        }
    }
    
    fetch('{{ route("checkout.create-payment") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        btn.classList.remove('loading');
        btn.disabled = false;
        
        if (data.success) {
            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    handlePaymentSuccess(result, data.order_number);
                },
                onPending: function(result) {
                    showNotification('info', 'Payment is being processed...');
                    hidePaymentModal();
                },
                onError: function(result) {
                    showNotification('error', 'Payment failed. Please try again.');
                    hidePaymentModal();
                },
                onClose: function() {
                    hidePaymentModal();
                }
            });
        } else {
            showNotification('error', data.message || 'Failed to create payment');
            hidePaymentModal();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.classList.remove('loading');
        btn.disabled = false;
        showNotification('error', 'An error occurred. Please try again.');
        hidePaymentModal();
    });
});

function showPaymentModal() {
    document.getElementById('paymentModal').classList.add('show');
}

function hidePaymentModal() {
    document.getElementById('paymentModal').classList.remove('show');
}

function handlePaymentSuccess(result, orderNumber) {
    const loadingContent = document.getElementById('loadingContent');
    loadingContent.innerHTML = '<div class="loading-spinner"></div><h3>Processing payment...</h3>';

    fetch('{{ route("checkout.handle-payment") }}', {
        method: 'POST',
        body: JSON.stringify({
            order_number: orderNumber,
            transaction_id: result.transaction_id
        }),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('success', 'Payment successful! Redirecting...');
            setTimeout(() => {
                window.location.href = data.redirect_url;
            }, 2000);
        } else {
            showNotification('error', data.message || 'Failed to process payment');
            hidePaymentModal();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'An error occurred. Please contact support.');
        hidePaymentModal();
    });
}

function showNotification(type, message) {
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => {
        if (document.body.contains(notification)) {
            document.body.removeChild(notification);
        }
    });

    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    let icon = '';
    switch(type) {
        case 'success':
            icon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20,6 9,17 4,12"></polyline></svg>';
            break;
        case 'error':
            icon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
            break;
        case 'info':
            icon = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
            break;
    }
    
    notification.innerHTML = `
        <div class="notification-icon">${icon}</div>
        <span>${message}</span>
    `;
    
    document.body.appendChild(notification);
    setTimeout(() => notification.classList.add('show'), 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hidePaymentModal();
    }
});

@if(session('success'))
    showNotification('success', '{{ session('success') }}');
@endif

@if(session('error'))
    showNotification('error', '{{ session('error') }}');
@endif
</script>
@endsection