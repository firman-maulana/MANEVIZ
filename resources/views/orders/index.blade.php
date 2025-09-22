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
            text-align: center;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .filters {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-row {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .filter-group select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: white;
        }

        .btn-filter {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s ease;
            margin-top: 30px;
        }

        .btn-filter:hover {
            background: #0056b3;
        }

        .orders-grid {
            display: grid;
            gap: 20px;
        }

        .order-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #f0f0f0;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .order-card:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
            border-color: #e0e0e0;
        }

        .order-main {
            padding: 24px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            gap: 16px;
        }

        .order-info h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 4px;
            letter-spacing: -0.01em;
        }

        .order-meta {
            font-size: 13px;
            color: #666;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .order-status {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }

        .status-badges {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 8px;
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

        .order-total {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-top: 4px;
        }

        .order-items {
            margin: 16px 0;
            border-top: 1px solid #f5f5f5;
            padding-top: 16px;
        }

        .item-row {
            display: flex;
            align-items: center;
            padding: 8px 0;
            gap: 12px;
        }

        .item-row:not(:last-child) {
            border-bottom: 1px solid #f8f8f8;
            padding-bottom: 12px;
        }

        .item-image {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            background: #f8f8f8;
            flex-shrink: 0;
        }

        .item-details {
            flex: 1;
            min-width: 0;
        }

        .item-name {
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 2px;
            font-size: 14px;
            line-height: 1.3;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .item-info {
            font-size: 12px;
            color: #666;
            line-height: 1.2;
        }

        .item-price {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
            flex-shrink: 0;
        }

        .items-more {
            text-align: center;
            color: #666;
            font-size: 12px;
            padding-top: 8px;
            font-weight: 500;
        }

        .tracking-timeline {
            margin: 16px 0;
            padding: 16px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 12px;
            color: #475569;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .timeline-dot.active {
            background: #22c55e;
        }

        .timeline-dot.inactive {
            background: #cbd5e1;
        }

        .order-actions {
            padding: 20px 24px;
            background: white;
            border-top: 1px solid #f0f0f0;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background: #0056b3;
            color: white;
            text-decoration: none;
        }

        .btn-danger {
            background: #dc3545;
            color: white;   
        }

        .btn-danger:hover {
            background: #c82333;
            color: white;
            text-decoration: none;
        }

        .btn-warning {
            background: #ffc107;
            color: #333;
        }

        .btn-warning:hover {
            background: #e0a800;
            color: #333;
            text-decoration: none;
        }

        .cancel-form {
            display: inline-block;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
            color: #6c757d;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .empty-text {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .pagination-wrapper {
            margin-top: 40px;
            display: flex;
            justify-content: center;
        }

        .nav-tabs {
            display: flex;
            justify-content: center;
            margin: 20px 0 40px;
            border-bottom: 2px solid #e1e5e9;
        }

        .nav-tab {
            padding: 12px 24px;
            text-decoration: none;
            color: #6c757d;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            margin: 0 10px;
        }

        .nav-tab:hover {
            color: #007bff;
            text-decoration: none;
        }

        .nav-tab.active {
            color: #007bff;
            border-bottom-color: #007bff;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .info-banner {
            background: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 0 8px 8px 0;
        }

        .info-content {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #004085;
        }

        .info-content .icon {
            font-size: 18px;
        }

        .info-content strong {
            display: block;
        }

        .info-content small {
            font-size: 12px;
        }

        .info-content a {
            color: #007bff;
            text-decoration: underline;
        }

        /* Custom Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease-out;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 0;
            max-width: 400px;
            width: 90%;
            position: relative;
            animation: slideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            border: 1px solid #f0f0f0;
        }

        .modal-header {
            padding: 28px 28px 20px;
            position: relative;
            text-align: center;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            color: #666;
            font-size: 20px;
            cursor: pointer;
            padding: 4px;
            border-radius: 8px;
            transition: all 0.2s ease;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: #1a1a1a;
            background-color: #f5f5f5;
        }

        .modal-icon {
            width: 56px;
            height: 56px;
            background: #fef2f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .modal-icon svg {
            width: 24px;
            height: 24px;
            color: #dc2626;
        }

        .modal-title {
            color: #1a1a1a;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .modal-message {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
        }

        .modal-footer {
            padding: 20px 28px 28px;
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .modal-btn {
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 80px;
        }

        .modal-btn-cancel {
            background: #f5f5f5;
            color: #666;
            border: 1px solid #e0e0e0;
        }

        .modal-btn-cancel:hover {
            background: #e8e8e8;
            color: #1a1a1a;
            transform: translateY(-1px);
        }

        .modal-btn-delete {
            background: #dc2626;
            color: white;
        }

        .modal-btn-delete:hover {
            background: #b91c1c;
            transform: translateY(-1px);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .order-status {
                align-items: flex-start;
                width: 100%;
            }

            .status-badges {
                justify-content: flex-start;
            }

            .order-actions {
                flex-direction: column;
            }

            .btn {
                flex: 1;
                justify-content: center;
            }

            .modal-content {
                margin: 20px;
                width: calc(100% - 40px);
            }

            .order-main {
                padding: 20px;
            }

            .order-actions {
                padding: 16px 20px;
            }
        }

        @media (max-width: 480px) {
            .item-name {
                font-size: 13px;
            }
            
            .item-info, .item-price {
                font-size: 12px;
            }
            
            .order-meta {
                font-size: 12px;
            }
        }
    </style>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title">My Orders</h1>
            <p class="page-subtitle">Track and manage your orders</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <a href="{{ route('orders.index') }}" class="nav-tab active">Active Orders</a>
            <a href="{{ route('order-history.index') }}" class="nav-tab">Order History</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Info Message -->
        <div class="info-banner">
            <div class="info-content">
                <span class="icon">ℹ️</span>
                <div>
                    <strong>Looking for completed orders?</strong>
                    <small>Delivered orders have been moved to <a href="{{ route('order-history.index') }}">Order History</a> where you can leave reviews.</small>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('orders.index') }}" class="filters">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="status">Order Status</label>
                    <select name="status" id="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="payment_status">Payment Status</label>
                    <select name="payment_status" id="payment_status">
                        <option value="">All Payment Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>

        <!-- Orders List -->
        @if ($orders->count() > 0)
            <div class="orders-grid">
                @foreach ($orders as $order)
                    <div class="order-card">
                        <div class="order-main">
                            <div class="order-header">
                                <div class="order-info">
                                    <h3>{{ $order->order_number }}</h3>
                                    <div class="order-meta">
                                        <div>{{ $order->order_date->format('d M Y H:i') }}</div>
                                        <div>{{ $order->orderItems->sum('kuantitas') }} items</div>
                                    </div>
                                </div>
                                <div class="order-status">
                                    <div class="status-badges">
                                        <span class="status-badge status-{{ $order->status }}">
                                            {{ $order->getStatusLabelAttribute() }}
                                        </span>
                                        <span class="status-badge payment-{{ $order->payment_status }}">
                                            {{ $order->getPaymentStatusLabelAttribute() }}
                                        </span>
                                    </div>
                                    <div class="order-total">IDR {{ number_format($order->grand_total, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <!-- Order Items Preview -->
                            <div class="order-items">
                                @foreach ($order->orderItems->take(2) as $item)
                                    <div class="item-row">
                                        @if ($item->product && $item->product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}"
                                                alt="{{ $item->product_name }}" class="item-image">
                                        @else
                                            <div class="item-image"
                                                style="background: #f5f5f5; display: flex; align-items: center; justify-content: center; color: #999; font-size: 10px;">
                                                No Image</div>
                                        @endif
                                        <div class="item-details">
                                            <div class="item-name">{{ $item->product_name }}</div>
                                            <div class="item-info">
                                                Qty: {{ $item->kuantitas }}
                                                @if ($item->size)
                                                    • Size: {{ $item->size }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="item-price">IDR {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                                @if ($order->orderItems->count() > 2)
                                    <div class="items-more">
                                        +{{ $order->orderItems->count() - 2 }} more items
                                    </div>
                                @endif
                            </div>

                            <!-- Tracking Timeline -->
                            @if (in_array($order->status, ['processing', 'shipped', 'delivered']))
                                <div class="tracking-timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-dot active"></div>
                                        <span>Confirmed - {{ $order->order_date->format('d M Y') }}</span>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-dot {{ $order->status === 'processing' || $order->status === 'shipped' || $order->status === 'delivered' ? 'active' : 'inactive' }}"></div>
                                        <span>Processing</span>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-dot {{ $order->status === 'shipped' || $order->status === 'delivered' ? 'active' : 'inactive' }}"></div>
                                        <span>Shipped {{ $order->shipped_date ? '- ' . $order->shipped_date->format('d M Y') : '' }}</span>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-dot {{ $order->status === 'delivered' ? 'active' : 'inactive' }}"></div>
                                        <span>Delivered {{ $order->delivered_date ? '- ' . $order->delivered_date->format('d M Y') : '' }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="order-actions">
                            <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-primary">
                                View Details
                            </a>

                            @if ($order->payment_status === 'pending' && $order->payment_method !== 'cod')
                                <a href="#" class="btn btn-warning" onclick="alert('Payment feature will be implemented here for order: {{ $order->order_number }}')">
                                    Complete Payment
                                </a>
                            @endif

                            @if (in_array($order->status, ['pending', 'processing']))
                                <form action="{{ route('orders.cancel', $order) }}" method="POST" class="cancel-form" id="cancel-form-{{ $order->id }}">
                                    @csrf
                                    <button type="button" class="btn btn-danger" onclick="showCancelModal('{{ $order->id }}', '{{ $order->order_number }}')">
                                        Cancel Order
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="pagination-wrapper">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <h2 class="empty-title">No Orders Found</h2>
                <p class="empty-text">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        @endif
    </div>

    <!-- Custom Cancel Confirmation Modal -->
    <div class="modal-overlay" id="cancelModal">
        <div class="modal-content">
            <div class="modal-header">
                <button class="modal-close" onclick="hideCancelModal()">&times;</button>
                <div class="modal-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="modal-title">Cancel order</h3>
                <p class="modal-message">Are you sure you would like to do this?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" onclick="hideCancelModal()">Back</button>
                <button type="button" class="modal-btn modal-btn-delete" onclick="confirmCancel()">Cancel Order</button>
            </div>
        </div>
    </div>

    <script>
        let currentOrderId = null;

        function showCancelModal(orderId, orderNumber) {
            currentOrderId = orderId;
            document.getElementById('cancelModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function hideCancelModal() {
            document.getElementById('cancelModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            currentOrderId = null;
        }

        function confirmCancel() {
            if (currentOrderId) {
                document.getElementById('cancel-form-' + currentOrderId).submit();
            }
        }

        // Close modal on backdrop click
        document.getElementById('cancelModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideCancelModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideCancelModal();
            }
        });

        // Auto refresh order status every 30 seconds
        setInterval(function() {
            const orderCards = document.querySelectorAll('.order-card');
            orderCards.forEach(card => {
                const orderNumber = card.querySelector('h3').textContent;
                if (orderNumber) {
                    fetch(`/orders/${orderNumber}/status`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.is_cancelled || data.is_delivered) {
                                window.location.href = '/order-history';
                                return;
                            }

                            const statusElements = card.querySelectorAll('.status-badge');
                            statusElements.forEach(element => {
                                if (element.classList.contains('status-' + data.status)) {
                                    element.textContent = data.status_label;
                                }
                                if (element.classList.contains('payment-' + data.payment_status)) {
                                    element.textContent = data.payment_status_label;
                                }
                            });
                        })
                        .catch(error => console.log('Status check failed:', error));
                }
            });
        }, 30000);

        // Smooth scroll behavior for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add loading state for buttons
        document.querySelectorAll('.btn').forEach(button => {
            if (button.type !== 'button') {
                button.addEventListener('click', function() {
                    this.disabled = true;
                    this.innerHTML = '<span>Loading...</span>';
                    setTimeout(() => {
                        this.disabled = false;
                        this.innerHTML = this.dataset.originalText || 'Submit';
                    }, 3000);
                });
            }
        });
    </script>
@endsection