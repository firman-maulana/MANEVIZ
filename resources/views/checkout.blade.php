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

    .address-actions {
        margin-top: 15px;
    }

    .btn-link {
        background: none;
        border: none;
        color: #007bff;
        cursor: pointer;
        text-decoration: underline;
        font-size: 14px;
        margin-right: 15px;
    }

    .btn-link:hover {
        color: #0056b3;
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

    .payment-methods-preview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
        gap: 10px;
        margin: 15px 0;
    }

    .payment-method-preview {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px;
        text-align: center;
        font-size: 12px;
        color: #6c757d;
    }

    .payment-method-preview div {
        font-size: 20px;
        margin-bottom: 5px;
    }

    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: block;
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

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
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

    /* Loading spinner */
    .spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
        margin-right: 8px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Payment Modal */
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
    }

    .loading-content {
        text-align: center;
        padding: 40px 20px;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #007bff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .checkout-content {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .checkout-form {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .checkout-title {
            font-size: 2rem;
        }

        .container {
            padding: 15px;
        }
    }

    @media (max-width: 480px) {
        .checkout-header {
            margin: 80px 0 30px;
        }

        .checkout-title {
            font-size: 1.8rem;
        }

        .checkout-form {
            padding: 15px;
        }

        .order-summary {
            padding: 20px;
        }
    }
</style>

<div class="container">
    <div class="checkout-header">
        <h1 class="checkout-title">Checkout</h1>
        <p class="checkout-subtitle">Complete your order with secure payment</p>
    </div>

    <!-- Back to Cart Link -->
    <a href="{{ route('cart.index') }}" class="back-to-cart">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="m12 19-7-7 7-7"/>
            <path d="m19 12-7 7-7-7"/>
        </svg>
        Back to Cart
    </a>

    <!-- Display Errors -->
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

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="checkout-content">
        <!-- Checkout Form -->
        <div class="checkout-form">
            <form id="checkoutForm">
                @csrf
                
                <!-- Hidden field untuk items -->
                <input type="hidden" name="items" value="{{ $selectedItems->pluck('id')->implode(',') }}">

                <!-- Shipping Information -->
                <div class="form-section">
                    <h3 class="section-title">Shipping Information</h3>
                    
                    <div class="address-section">
                        @if($userAddresses->count() > 0)
                            <div class="address-selector">
                                <label class="form-label">Select Address</label>
                                @foreach($userAddresses as $address)
                                    <div class="address-option {{ $defaultAddress && $defaultAddress->id === $address->id ? 'selected' : '' }}" 
                                         onclick="selectAddress({{ $address->id }})">
                                        <input type="radio" name="selected_address" value="{{ $address->id }}" 
                                               {{ $defaultAddress && $defaultAddress->id === $address->id ? 'checked' : '' }}>
                                        
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
                                            {{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}<br>
                                            Phone: {{ $address->user->phone ?? 'No phone' }}
                                        </div>
                                    </div>
                                @endforeach
                                
                                <div class="address-option" onclick="selectManualAddress()">
                                    <input type="radio" name="selected_address" value="manual">
                                    <div class="address-name">Use different address</div>
                                    <div class="address-details">Enter a new address for this order</div>
                                </div>
                            </div>
                            
                            <div class="address-actions">
                                <button type="button" onclick="refreshAddresses()" class="btn-link">
                                    Refresh Addresses
                                </button>
                                <a href="{{ route('address.create') }}" class="add-address-btn" target="_blank">
                                    Add New Address
                                </a>
                            </div>
                        @else
                            <p style="color: #6c757d; margin-bottom: 20px;">
                                You don't have any saved addresses. Please add an address first.
                            </p>
                            <a href="{{ route('address.create') }}" class="add-address-btn">
                                Add Your First Address
                            </a>
                        @endif
                        
                        <!-- Manual Address Form (Hidden by default when addresses exist) -->
                        <div class="manual-address-form" id="manualAddressForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" name="shipping_name" class="form-input" 
                                           value="{{ old('shipping_name', auth()->user()->name) }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="shipping_email" class="form-input" 
                                           value="{{ old('shipping_email', auth()->user()->email) }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" name="shipping_phone" class="form-input" 
                                       value="{{ old('shipping_phone') }}" required placeholder="08xxxxxxxxxx">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Address *</label>
                                <textarea name="shipping_address" class="form-input form-textarea" 
                                          required placeholder="Street address, building, apartment, etc.">{{ old('shipping_address') }}</textarea>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">City *</label>
                                    <input type="text" name="shipping_city" class="form-input" 
                                           value="{{ old('shipping_city') }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Province *</label>
                                    <input type="text" name="shipping_province" class="form-input" 
                                           value="{{ old('shipping_province') }}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Postal Code *</label>
                                <input type="text" name="shipping_postal_code" class="form-input" 
                                       value="{{ old('shipping_postal_code') }}" required maxlength="10">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Billing Information -->
                <div class="form-section">
                    <h3 class="section-title">Billing Information</h3>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="same_as_shipping" name="same_as_shipping" value="1" 
                               {{ old('same_as_shipping', true) ? 'checked' : '' }} onchange="toggleBillingFields()">
                        <label for="same_as_shipping" class="checkbox-label">Same as shipping address</label>
                    </div>

                    <div id="billing-fields" style="display: {{ old('same_as_shipping', true) ? 'none' : 'block' }};">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="billing_name" class="form-input" 
                                       value="{{ old('billing_name') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" name="billing_email" class="form-input" 
                                       value="{{ old('billing_email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="billing_phone" class="form-input" 
                                   value="{{ old('billing_phone') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea name="billing_address" class="form-input form-textarea">{{ old('billing_address') }}</textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">City</label>
                                <input type="text" name="billing_city" class="form-input" 
                                       value="{{ old('billing_city') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Province</label>
                                <input type="text" name="billing_province" class="form-input" 
                                       value="{{ old('billing_province') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Postal Code</label>
                            <input type="text" name="billing_postal_code" class="form-input" 
                                   value="{{ old('billing_postal_code') }}" maxlength="10">
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="form-section">
                    <h3 class="section-title">Order Notes (Optional)</h3>
                    <div class="form-group">
                        <textarea name="notes" class="form-input form-textarea" 
                                  placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3 class="summary-title">Order Summary</h3>
            
            <!-- Order Items -->
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
                            @if($item->color)
                                <span>Color: {{ $item->color }}</span>
                            @endif
                            @if($item->size)
                                <span>Size: {{ $item->size }}</span>
                            @endif
                        </div>
                        <div class="item-price">
                            <span>Qty: {{ $item->kuantitas }}</span>
                            <span><strong>IDR {{ number_format(($item->product->harga_jual ?? $item->product->harga) * $item->kuantitas, 0, ',', '.') }}</strong></span>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Summary Calculation -->
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
                <span>IDR {{ number_format($shipping ?? 15000, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span>IDR {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <!-- Payment Info -->
            <div class="payment-info">
                <h5>Secure Payment</h5>
                <p>Choose from various payment methods including bank transfer, credit card, e-wallets, and more.</p>
                <div class="payment-methods-preview">
                    <div class="payment-method-preview">
                        <div>🏦</div>
                        <span>Bank</span>
                    </div>
                    <div class="payment-method-preview">
                        <div>💳</div>
                        <span>Card</span>
                    </div>
                    <div class="payment-method-preview">
                        <div>📱</div>
                        <span>E-Wallet</span>
                    </div>
                    <div class="payment-method-preview">
                        <div>📊</div>
                        <span>QRIS</span>
                    </div>
                </div>
            </div>

            <button type="button" id="payNowBtn" class="pay-now-btn">
                <span class="btn-text">Pay Now - IDR {{ number_format($total, 0, ',', '.') }}</span>
            </button>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="payment-modal">
    <div class="payment-modal-content">
        <div id="loadingContent" class="loading-content">
            <div class="loading-spinner"></div>
            <h3>Preparing Payment...</h3>
            <p>Please wait while we set up your secure payment.</p>
        </div>
        <div id="paymentContent" style="display: none;">
            <!-- Midtrans Snap will load here -->
        </div>
    </div>
</div>

<!-- Midtrans Snap JS -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
    // Address selection functions
    function selectAddress(addressId) {
        // Remove selected class from all address options
        document.querySelectorAll('.address-option').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Add selected class to clicked option
        event.currentTarget.classList.add('selected');
        
        // Check the radio button
        event.currentTarget.querySelector('input[type="radio"]').checked = true;
        
        // Hide manual address form
        document.getElementById('manualAddressForm').classList.remove('show');
        
        // Fill form with selected address data (if needed for processing)
        if (addressId !== 'manual') {
            fillAddressForm(addressId);
        }
    }
    
    function selectManualAddress() {
        // Remove selected class from all address options
        document.querySelectorAll('.address-option').forEach(option => {
            option.classList.remove('selected');
        });
        
        // Add selected class to manual option
        event.currentTarget.classList.add('selected');
        
        // Show manual address form
        document.getElementById('manualAddressForm').classList.add('show');
        
        // Clear form fields
        clearAddressForm();
    }
    
    function refreshAddresses() {
        // Fetch updated addresses from server
        fetch('{{ route("address.index") }}', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to show updated addresses
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error refreshing addresses:', error);
            showNotification('info', 'Please refresh the page to see new addresses');
        });
    }
    
    function fillAddressForm(addressId) {
        const addresses = @json($userAddresses);
        const selectedAddress = addresses.find(addr => addr.id == addressId);
        
        if (selectedAddress) {
            document.querySelector('input[name="shipping_name"]').value = selectedAddress.recipient_name;
            document.querySelector('input[name="shipping_email"]').value = '{{ auth()->user()->email }}';
            document.querySelector('input[name="shipping_phone"]').value = '{{ auth()->user()->phone ?? "" }}';
            document.querySelector('textarea[name="shipping_address"]').value = selectedAddress.address;
            document.querySelector('input[name="shipping_city"]').value = selectedAddress.city;
            document.querySelector('input[name="shipping_province"]').value = selectedAddress.province;
            document.querySelector('input[name="shipping_postal_code"]').value = selectedAddress.postal_code;
        }
    }
    
    function clearAddressForm() {
        document.querySelector('input[name="shipping_name"]').value = '{{ auth()->user()->name }}';
        document.querySelector('input[name="shipping_email"]').value = '{{ auth()->user()->email }}';
        document.querySelector('input[name="shipping_phone"]').value = '';
        document.querySelector('textarea[name="shipping_address"]').value = '';
        document.querySelector('input[name="shipping_city"]').value = '';
        document.querySelector('input[name="shipping_province"]').value = '';
        document.querySelector('input[name="shipping_postal_code"]').value = '';
    }

    function toggleBillingFields() {
        const checkbox = document.getElementById('same_as_shipping');
        const billingFields = document.getElementById('billing-fields');
        
        if (checkbox.checked) {
            billingFields.style.display = 'none';
            billingFields.querySelectorAll('input, textarea').forEach(input => {
                input.removeAttribute('required');
            });
        } else {
            billingFields.style.display = 'block';
            billingFields.querySelectorAll('input[name$="_name"], input[name$="_email"], input[name$="_phone"], textarea[name$="_address"], input[name$="_city"], input[name$="_province"], input[name$="_postal_code"]').forEach(input => {
                input.setAttribute('required', 'required');
            });
        }
    }

    // Payment button click handler
    document.getElementById('payNowBtn').addEventListener('click', function() {
        // Check if address is selected
        const selectedAddress = document.querySelector('input[name="selected_address"]:checked');
        if (!selectedAddress) {
            showNotification('error', 'Please select or enter a shipping address');
            return;
        }
        
        // If manual address is selected, validate the form
        if (selectedAddress.value === 'manual') {
            const form = document.getElementById('checkoutForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
        }

        // Show modal and loading
        const modal = document.getElementById('paymentModal');
        modal.classList.add('show');
        
        // Prepare form data
        const formData = new FormData(document.getElementById('checkoutForm'));
        
        // If a saved address is selected, get address data
        if (selectedAddress.value !== 'manual') {
            const addresses = @json($userAddresses);
            const address = addresses.find(addr => addr.id == selectedAddress.value);
            if (address) {
                formData.set('shipping_name', address.recipient_name);
                formData.set('shipping_email', '{{ auth()->user()->email }}');
                formData.set('shipping_phone', '{{ auth()->user()->phone ?? "" }}');
                formData.set('shipping_address', address.address);
                formData.set('shipping_city', address.city);
                formData.set('shipping_province', address.province);
                formData.set('shipping_postal_code', address.postal_code);
            }
        }
        
        // Create payment token
        fetch('{{ route("checkout.create-payment") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide loading and show payment
                document.getElementById('loadingContent').style.display = 'none';
                document.getElementById('paymentContent').style.display = 'block';
                
                // Trigger Midtrans Snap
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        // Handle successful payment
                        handlePaymentSuccess(result, data.order_number);
                    },
                    onPending: function(result) {
                        // Handle pending payment
                        showNotification('info', 'Payment is being processed...');
                        modal.classList.remove('show');
                    },
                    onError: function(result) {
                        // Handle payment error
                        showNotification('error', 'Payment failed. Please try again.');
                        modal.classList.remove('show');
                    },
                    onClose: function() {
                        // Handle when user closes payment popup
                        modal.classList.remove('show');
                    }
                });
            } else {
                // Handle error
                showNotification('error', data.message || 'Failed to create payment. Please try again.');
                modal.classList.remove('show');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'An error occurred. Please try again.');
            modal.classList.remove('show');
        });
    });

    // Handle successful payment
    function handlePaymentSuccess(result, orderNumber) {
        fetch('{{ route("checkout.handle-payment") }}', {
            method: 'POST',
            body: JSON.stringify({
                order_number: orderNumber,
                transaction_id: result.transaction_id
            }),
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                showNotification('error', data.message || 'Failed to process payment. Please contact support.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('error', 'An error occurred. Please contact support.');
        });
    }

    // Show notification function
    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            z-index: 10001;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            max-width: 350px;
            ${type === 'success' ? 'background: #28a745;' : 
              type === 'info' ? 'background: #17a2b8;' : 'background: #dc3545;'}
        `;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => notification.style.transform = 'translateX(0)', 100);
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 4000);
    }

    // Close modal when clicking outside
    document.getElementById('paymentModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('show');
        }
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize billing fields visibility
        toggleBillingFields();
        
        @if($userAddresses->count() === 0)
            // If no addresses exist, show manual form
            document.getElementById('manualAddressForm').classList.add('show');
        @elseif($defaultAddress)
            // Fill form with default address
            fillAddressForm({{ $defaultAddress->id }});
        @endif
    });

    // Show server-side messages
    @if(session('success'))
        showNotification('success', '{{ session('success') }}');
    @endif

    @if(session('error'))
        showNotification('error', '{{ session('error') }}');
    @endif
</script>
@endsection