@extends('layouts.app2')

@section('content')
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

    .page-header {
        margin: 80px 0 40px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a1a;
        letter-spacing: -0.01em;
    }

    .order-status-header {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending {
        background: #fff4e6;
        color: #d97706;
    }

    .status-processing {
        background: #eff6ff;
        color: #2563eb;
    }

    .status-shipped {
        background: #f0fdf4;
        color: #16a34a;
    }

    .status-delivered {
        background: #ecfeff;
        color: #0891b2;
    }

    .status-cancelled {
        background: #fef2f2;
        color: #dc2626;
    }

    .payment-paid {
        background: #f0fdf4;
        color: #16a34a;
    }

    .payment-pending {
        background: #fff4e6;
        color: #d97706;
    }

    .payment-failed {
        background: #fef2f2;
        color: #dc2626;
    }

    .order-layout {
        display: grid;
        gap: 24px;
    }

    /* Top Row - Info and Items */
    .top-row {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 24px;
    }

    .order-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #f0f0f0;
        transition: box-shadow 0.3s ease;
    }

    .order-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 20px;
        letter-spacing: -0.01em;
    }

    /* Order Information */
    .info-grid {
        display: grid;
        gap: 20px;
    }

    .info-section h4 {
        font-weight: 600;
        color: #374151;
        margin-bottom: 12px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 8px 0;
        gap: 16px;
    }

    .info-label {
        font-weight: 500;
        color: #6b7280;
        font-size: 14px;
        flex-shrink: 0;
        min-width: 100px;
    }

    .info-value {
        color: #1f2937;
        font-weight: 500;
        font-size: 14px;
        text-align: right;
    }

    .notes-section {
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #f3f4f6;
    }

    .notes-section h4 {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .notes-text {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.5;
    }

    /* Order Items */
    .order-items {
        display: grid;
        gap: 12px;
    }

    .item-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f9fafb;
    }

    .item-row:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        background: #f9fafb;
        flex-shrink: 0;
    }

    .item-details {
        flex: 1;
        min-width: 0;
    }

    .item-name {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
        font-size: 14px;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .item-info {
        font-size: 12px;
        color: #6b7280;
        line-height: 1.2;
    }

    .item-price {
        text-align: right;
        flex-shrink: 0;
    }

    .item-unit-price {
        font-size: 11px;
        color: #9ca3af;
        margin-bottom: 2px;
    }

    .item-subtotal {
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }

    /* Order Summary */
    .order-summary {
        background: #f9fafb;
        padding: 16px;
        border-radius: 12px;
        margin-top: 16px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
        color: #6b7280;
    }

    .summary-row.total {
        font-weight: 700;
        font-size: 16px;
        padding-top: 12px;
        border-top: 1px solid #e5e7eb;
        margin-top: 8px;
        color: #1f2937;
    }

    /* Order Tracking */
    .tracking-card {
        grid-column: 1 / -1;
    }

    .tracking-timeline {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 24px;
        margin-top: 8px;
    }

    .timeline-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        position: relative;
    }

    .timeline-dot {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .timeline-dot.active {
        background: #16a34a;
        color: white;
    }

    .timeline-dot.inactive {
        background: #e5e7eb;
        color: #9ca3af;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
        font-size: 14px;
    }

    .timeline-date {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .timeline-description {
        font-size: 12px;
        color: #9ca3af;
        line-height: 1.4;
    }

    /* Actions */
    .order-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
        flex-wrap: wrap;
        grid-column: 1 / -1;
        margin-bottom: 10px;
        justify-content: left;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-primary:hover {
        background: #1d4ed8;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn-danger:hover {
        background: #b91c1c;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .top-row {
            grid-template-columns: 1fr;
        }

        .tracking-timeline {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .order-card {
            padding: 20px;
        }

        .tracking-timeline {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .item-row {
            flex-wrap: wrap;
            gap: 8px;
        }

        .item-price {
            width: 100%;
            text-align: left;
            margin-top: 4px;
        }

        .order-actions {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
            width: 100%;
        }

        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 4px;
        }

        .info-value {
            text-align: left;
        }
    }

    @media (max-width: 480px) {
        .order-status-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Order {{ $order->order_number }}</h1>
        </div>
        <div class="order-status-header">
            <span class="status-badge status-{{ $order->status }}">
                {{ $order->getStatusLabelAttribute() }}
            </span>
            <span class="status-badge payment-{{ $order->payment_status }}">
                {{ $order->getPaymentStatusLabelAttribute() }}
            </span>
        </div>
    </div>

    <div class="order-layout">
        <!-- Top Row: Order Information and Items -->
        <div class="top-row">
            <!-- Order Information -->
            <div class="order-card">
                <h2 class="card-title">Order Information</h2>
                <div class="info-grid">
                    <div class="info-section">
                        <h4>Order Details</h4>
                        <div class="info-item">
                            <span class="info-label">Order Date</span>
                            <span class="info-value">{{ $order->order_date->format('d M Y H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Payment Method</span>
                            <span class="info-value">{{ $order->getPaymentMethodLabelAttribute() }}</span>
                        </div>
                        @if($order->transaction_id)
                        <div class="info-item">
                            <span class="info-label">Transaction ID</span>
                            <span class="info-value">{{ $order->transaction_id }}</span>
                        </div>
                        @endif
                    </div>

                    <div class="info-section">
                        <h4>Shipping Information</h4>
                        <div class="info-item">
                            <span class="info-label">Name</span>
                            <span class="info-value">{{ $order->shipping_name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $order->shipping_email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone</span>
                            <span class="info-value">{{ $order->shipping_phone }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Address</span>
                            <span class="info-value">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_province ?? '' }} {{ $order->shipping_postal_code }}</span>
                        </div>
                    </div>
                </div>

                @if($order->notes)
                <div class="notes-section">
                    <h4>Order Notes</h4>
                    <p class="notes-text">{{ $order->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="order-card">
                <h2 class="card-title">Order Items</h2>
                <div class="order-items">
                    @foreach($order->orderItems as $item)
                    <div class="item-row">
                        @if($item->product && $item->product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                            alt="{{ $item->product_name }}" class="item-image">
                        @else
                        <div class="item-image" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 10px;">No Image</div>
                        @endif

                        <div class="item-details">
                            <div class="item-name">{{ $item->product_name }}</div>
                            <div class="item-info">
                                Qty: {{ $item->kuantitas }}
                                @if($item->size) • Size: {{ $item->size }} @endif
                            </div>
                        </div>

                        <div class="item-price">
                            <div class="item-unit-price">IDR {{ number_format($item->product_price, 0, ',', '.') }} each</div>
                            <div class="item-subtotal">IDR {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>IDR {{ number_format($order->subtotal ?? $order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    @if(isset($order->tax) && $order->tax > 0)
                    <div class="summary-row">
                        <span>Tax</span>
                        <span>IDR {{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="summary-row">
                        <span>Shipping Cost</span>
                        <span>IDR {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total Amount</span>
                        <span>IDR {{ number_format($order->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Tracking -->
        <div class="order-card tracking-card">
            <h2 class="card-title">Order Tracking</h2>
            <div class="tracking-timeline">
                <div class="timeline-item">
                    <div class="timeline-dot active">1</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Order Placed</div>
                        <div class="timeline-date">{{ $order->order_date->format('d M Y H:i') }}</div>
                        <div class="timeline-description">Order confirmed and payment received</div>
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'active' : 'inactive' }}">2</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Processing</div>
                        @if($order->status === 'processing')
                        <div class="timeline-date">Currently processing</div>
                        <div class="timeline-description">Your order is being prepared</div>
                        @elseif(in_array($order->status, ['shipped', 'delivered']))
                        <div class="timeline-date">Completed</div>
                        <div class="timeline-description">Order has been processed</div>
                        @else
                        <div class="timeline-date">Pending</div>
                        <div class="timeline-description">Awaiting payment confirmation</div>
                        @endif
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot {{ in_array($order->status, ['shipped', 'delivered']) ? 'active' : 'inactive' }}">3</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Shipped</div>
                        @if($order->waybill_number && in_array($order->status, ['shipped', 'delivered']))
                        <div class="timeline-date">
                            {{ $order->shipped_date ? $order->shipped_date->format('d M Y H:i') : 'Recently shipped' }}
                        </div>
                        <div class="timeline-description">
                            Package is on the way
                            @if($order->waybill_number)
                            <br><strong>Resi: {{ $order->waybill_number }}</strong>
                            @endif
                        </div>
                        @else
                        <div class="timeline-date">Pending</div>
                        <div class="timeline-description">Will ship after processing</div>
                        @endif
                    </div>
                </div>

                <div class="timeline-item">
                    <div class="timeline-dot {{ $order->status === 'delivered' ? 'active' : 'inactive' }}">4</div>
                    <div class="timeline-content">
                        <div class="timeline-title">Delivered</div>
                        @if($order->delivered_date)
                        <div class="timeline-date">{{ $order->delivered_date->format('d M Y H:i') }}</div>
                        <div class="timeline-description">Successfully delivered</div>
                        @elseif($order->status === 'delivered')
                        <div class="timeline-date">Recently delivered</div>
                        <div class="timeline-description">Package has been delivered</div>
                        @else
                        <div class="timeline-date">Pending</div>
                        <div class="timeline-description">Will deliver after shipping</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($order->status === 'delivered')
        <!-- Delivered Success Message -->
        <div class="order-card tracking-card" style="grid-column: 1 / -1;">
            <div style="text-align: center; padding: 40px 20px;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h2 style="font-size: 28px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px;">
                    Order Delivered Successfully! 🎉
                </h2>
                <p style="font-size: 16px; color: #6b7280; margin-bottom: 8px;">
                    Your order has been delivered on <strong>{{ $order->delivered_date->format('l, d F Y') }}</strong> at <strong>{{ $order->delivered_date->format('H:i') }}</strong>
                </p>
                <p style="font-size: 14px; color: #9ca3af; margin-bottom: 24px;">
                    We hope you love your purchase! Thank you for shopping with us.
                </p>

                <div style="background: #f0fdf4; border: 2px solid #86efac; border-radius: 12px; padding: 20px; margin: 24px 0;">
                    <p style="font-size: 15px; color: #166534; margin-bottom: 12px; font-weight: 600;">
                        💚 How was your experience?
                    </p>
                    <p style="font-size: 13px; color: #166534; margin-bottom: 16px;">
                        Share your thoughts and help other customers make informed decisions
                    </p>
                    <a href="{{ route('order-history.review-form', $item->id) }}" class="btn btn-success" style="background: #10b981; padding: 12px 24px; font-size: 14px;">
                        Write a Review
                    </a>
                </div>
            </div>
        </div>
        @elseif($order->waybill_number && in_array($order->status, ['shipped']))
        <div class="order-card tracking-card" style="grid-column: 1 / -1;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="card-title">Shipment Tracking</h2>
                <button onclick="refreshTracking('{{ $order->order_number }}')" class="btn btn-primary" id="refreshTrackingBtn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2" />
                    </svg>
                    Refresh Tracking
                </button>
            </div>

            <div style="background: #f8fafc; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                    <div>
                        <p style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Courier</p>
                        <p style="font-weight: 600; color: #1e293b;">{{ $order->courier_label }}</p>
                    </div>
                    <div>
                        <p style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Service</p>
                        <p style="font-weight: 600; color: #1e293b;">{{ $order->courier_service }}</p>
                    </div>
                    <div>
                        <p style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Waybill Number</p>
                        <p style="font-weight: 600; color: #1e293b; font-family: monospace;">{{ $order->waybill_number }}</p>
                    </div>
                    @if($order->last_tracking_update)
                    <div>
                        <p style="font-size: 12px; color: #64748b; margin-bottom: 4px;">Last Updated</p>
                        <p style="font-weight: 600; color: #1e293b;">{{ $order->last_tracking_update->format('d M Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div id="trackingTimeline">
                @if($order->tracking_history && count($order->tracking_history) > 0)
                @include('partials.tracking-timeline', ['history' => $order->tracking_history])
                @else
                <div style="text-align: center; padding: 40px; color: #64748b;">
                    <svg style="width: 48px; height: 48px; margin: 0 auto 16px; opacity: 0.5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p style="font-weight: 500; margin-bottom: 8px;">No tracking information yet</p>
                    <p style="font-size: 14px;">Click "Refresh Tracking" to get the latest updates</p>
                </div>
                @endif
            </div>

            <div id="trackingLoading" style="display: none; text-align: center; padding: 40px;">
                <div style="display: inline-block; width: 40px; height: 40px; border: 4px solid #f3f4f6; border-top: 4px solid #3b82f6; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                <p style="margin-top: 16px; color: #64748b;">Loading tracking information...</p>
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="order-actions">
            @if($order->payment_status === 'pending' && $order->payment_method !== 'cod')
            <a href="#" class="btn btn-warning" onclick="completePayment('{{ $order->order_number }}')">
                Complete Payment
            </a>
            @endif

            @if(in_array($order->status, ['pending', 'processing']))
            <button class="btn btn-danger" onclick="cancelOrder('{{ $order->id }}')">
                Cancel Order
            </button>
            @endif

            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                Back to Orders
            </a>

            <a href="{{ route('products.index') }}" class="btn btn-primary">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<script>
    function completePayment(orderNumber) {
        alert('Payment feature will be implemented here for order: ' + orderNumber);
    }

    function cancelOrder(orderId) {
        if (confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {
            fetch(`/orders/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to cancel order');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to cancel order');
                });
        }
    }

    // Auto refresh order status every 30 seconds
    setInterval(function() {
        const orderNumber = '{{ $order->order_number }}';
        fetch(`/orders/${orderNumber}/status`)
            .then(response => response.json())
            .then(data => {
                const statusBadges = document.querySelectorAll('.status-badge');
                statusBadges.forEach(badge => {
                    if (badge.classList.contains('status-' + data.status)) {
                        badge.textContent = data.status_label;
                    }
                    if (badge.classList.contains('payment-' + data.payment_status)) {
                        badge.textContent = data.payment_status_label;
                    }
                });

                updateTimeline(data);
            })
            .catch(error => console.log('Status check failed:', error));
    }, 30000);

    function updateTimeline(data) {
        const timelineDots = document.querySelectorAll('.timeline-dot');

        timelineDots.forEach(dot => {
            dot.classList.remove('active');
            dot.classList.add('inactive');
        });

        if (data.status === 'processing' || data.status === 'shipped' || data.status === 'delivered') {
            timelineDots[0].classList.add('active');
            timelineDots[1].classList.add('active');
        }

        if (data.status === 'shipped' || data.status === 'delivered') {
            timelineDots[2].classList.add('active');
        }

        if (data.status === 'delivered') {
            timelineDots[3].classList.add('active');
        }
    }

    function refreshTracking(orderNumber) {
        const btn = document.getElementById('refreshTrackingBtn');
        const timeline = document.getElementById('trackingTimeline');
        const loading = document.getElementById('trackingLoading');

        btn.disabled = true;
        btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="animation: spin 1s linear infinite;"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg> Refreshing...';
        timeline.style.display = 'none';
        loading.style.display = 'block';

        fetch(`/tracking/${orderNumber}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const history = data.data.tracking.history;
                    if (history && history.length > 0) {
                        timeline.innerHTML = generateTimelineHTML(history);
                    }

                    showNotification('success', 'Tracking updated successfully');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showNotification('error', data.message || 'Failed to update tracking');
                    timeline.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Tracking error:', error);
                showNotification('error', 'Failed to refresh tracking. Please try again.');
                timeline.style.display = 'block';
            })
            .finally(() => {
                loading.style.display = 'none';
                btn.disabled = false;
                btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg> Refresh Tracking';
            });
    }

    function generateTimelineHTML(history) {
        let html = '<div style="position: relative;">';

        history.forEach((item, index) => {
            const isLatest = index === 0;
            const isLast = index === history.length - 1;

            html += `
            <div style="display: flex; gap: 16px; margin-bottom: ${isLast ? '0' : '24px'};">
                <div style="position: relative; display: flex; flex-direction: column; align-items: center;">
                    <div style="width: 16px; height: 16px; border-radius: 50%; background: ${isLatest ? '#10b981' : '#cbd5e1'}; z-index: 10;"></div>
                    ${!isLast ? '<div style="width: 2px; height: 100%; background: #cbd5e1; position: absolute; top: 16px;"></div>' : ''}
                </div>

                <div style="flex: 1; padding-bottom: ${isLast ? '0' : '8px'};">
                    <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; padding: 16px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px; gap: 12px;">
                            <p style="font-weight: 600; color: #1e293b; font-size: 14px; line-height: 1.4; flex: 1;">
                                ${item.description || 'No description'}
                            </p>
                            ${isLatest ? '<span style="background: #d1fae5; color: #065f46; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; white-space: nowrap;">LATEST</span>' : ''}
                        </div>

                        <div style="display: flex; gap: 16px; flex-wrap: wrap; font-size: 12px; color: #64748b;">
                            ${item.date ? `<span style="display: flex; align-items: center; gap: 4px;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>${item.date}</span>` : ''}
                            ${item.time ? `<span style="display: flex; align-items: center; gap: 4px;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>${item.time}</span>` : ''}
                            ${item.location ? `<span style="display: flex; align-items: center; gap: 4px;"><svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>${item.location}</span>` : ''}
                        </div>
                    </div>
                </div>
            </div>
        `;
        });

        html += '</div>';
        return html;
    }

    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.style.cssText = 'position: fixed; top: 20px; right: 20px; padding: 15px 20px; border-radius: 12px; color: white; z-index: 10001; font-weight: 500; box-shadow: 0 8px 25px rgba(0,0,0,0.15); transform: translateX(400px); transition: all 0.3s ease; max-width: 350px; display: flex; align-items: center; gap: 12px;';
        notification.style.background = type === 'success' ? 'linear-gradient(135deg, #28a745, #20c997)' : 'linear-gradient(135deg, #dc3545, #e74c3c)';
        notification.innerHTML = `
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            ${type === 'success' ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>' : '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>'}
        </svg>
        <span>${message}</span>
    `;
        document.body.appendChild(notification);

        setTimeout(() => notification.style.transform = 'translateX(0)', 100);
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
</script>
@endsection
