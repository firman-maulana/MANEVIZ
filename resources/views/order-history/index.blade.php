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

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 14px;
        }

        .filters {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .filter-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .filter-group input,
        .filter-group select {
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
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s ease;
            height: fit-content;
        }

        .btn-filter:hover {
            background: #0056b3;
        }

        .orders-grid {
            display: grid;
            gap: 20px;
        }

        /* Modern Order Card Design - matching active orders */
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

        .status-delivered {
            background: #f0fdf4;
            color: #16a34a;
        }

        .status-cancelled {
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
            position: relative;
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
            margin-bottom: 4px;
        }

        .item-price {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
        }

        .stars {
            color: #ffc107;
            font-size: 12px;
            margin-top: 2px;
        }

        .review-status {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }

        .review-badge {
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .review-completed {
            background: #f0fdf4;
            color: #16a34a;
        }

        .review-pending {
            background: #fff4e6;
            color: #d97706;
        }

        .review-disabled {
            background: #fef2f2;
            color: #dc2626;
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

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
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

        .btn-sm {
            padding: 6px 12px;
            font-size: 11px;
            border-radius: 6px;
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

        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 8px;
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

        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }

            .page-title {
                font-size: 2rem;
            }

            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-row {
                grid-template-columns: 1fr;
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
                padding: 16px 20px;
            }

            .btn {
                flex: 1;
                justify-content: center;
            }

            .order-main {
                padding: 20px;
            }

            .review-status {
                position: static;
                transform: none;
                margin-top: 8px;
                align-items: flex-start;
            }

            .item-row {
                flex-wrap: wrap;
                padding-bottom: 16px;
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
            <h1 class="page-title">Order History</h1>
            <p class="page-subtitle">View your completed and cancelled orders</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <a href="{{ route('orders.index') }}" class="nav-tab">Active Orders</a>
            <a href="{{ route('order-history.index') }}" class="nav-tab active">Order History</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        <!-- Statistics -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number">{{ $orders->total() }}</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    {{ $orders->where('status', 'delivered')->count() }}
                </div>
                <div class="stat-label">Delivered Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    {{ $orders->where('status', 'cancelled')->count() }}
                </div>
                <div class="stat-label">Cancelled Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">IDR {{ number_format($orders->where('status', 'delivered')->sum('grand_total'), 0, ',', '.') }}</div>
                <div class="stat-label">Total Spent</div>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" action="{{ route('order-history.index') }}" class="filters">
            <div class="filter-row">
                <div class="filter-group">
                    <label for="order_status">Order Status</label>
                    <select name="order_status" id="order_status">
                        <option value="">All Status</option>
                        <option value="delivered" {{ request('order_status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ request('order_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="date_from">From Date</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="filter-group">
                    <label for="date_to">To Date</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="filter-group">
                    <label for="rating">Rating</label>
                    <select name="rating" id="rating">
                        <option value="">All Ratings</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="review_status">Review Status</label>
                    <select name="review_status" id="review_status">
                        <option value="">All Items</option>
                        <option value="reviewed" {{ request('review_status') == 'reviewed' ? 'selected' : '' }}>Reviewed
                        </option>
                        <option value="unreviewed" {{ request('review_status') == 'unreviewed' ? 'selected' : '' }}>
                            Unreviewed</option>
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
                                        @if($order->status === 'delivered')
                                            <div>Delivered: {{ $order->delivered_date->format('d M Y H:i') }}</div>
                                        @elseif($order->status === 'cancelled')
                                            <div>Cancelled: {{ $order->updated_at->format('d M Y H:i') }}</div>
                                        @endif
                                        <div>{{ $order->orderItems->sum('kuantitas') }} items</div>
                                    </div>
                                </div>
                                <div class="order-status">
                                    <div class="status-badges">
                                        @if($order->status === 'delivered')
                                            <span class="status-badge status-delivered">
                                                Delivered
                                            </span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="status-badge status-cancelled">
                                                Cancelled
                                            </span>
                                        @endif
                                    </div>
                                    <div class="order-total">IDR {{ number_format($order->grand_total, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <!-- Order Items with Reviews -->
                            <div class="order-items">
                                @foreach ($order->orderItems as $item)
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
                                            <div class="item-price">IDR {{ number_format($item->subtotal, 0, ',', '.') }}</div>

                                            @if ($item->review)
                                                <div class="stars">
                                                    {{ str_repeat('★', $item->review->rating) }}{{ str_repeat('☆', 5 - $item->review->rating) }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="review-status">
                                            @if($order->status === 'delivered')
                                                @if ($item->review)
                                                    <div class="review-badge review-completed">Reviewed</div>
                                                    <a href="{{ route('order-history.edit-review', $item->review->id) }}"
                                                        class="btn btn-warning btn-sm">Edit Review</a>
                                                @else
                                                    <div class="review-badge review-pending">Not Reviewed</div>
                                                    <a href="{{ route('order-history.review-form', $item->id) }}"
                                                        class="btn btn-success btn-sm">Write Review</a>
                                                @endif
                                            @else
                                                <div class="review-badge review-disabled">Cannot Review</div>
                                                <div style="font-size: 9px; color: #666; margin-top: 2px; text-align: right;">
                                                    Order was cancelled
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="order-actions">
                            <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-primary">
                                View Details
                            </a>
                            @if($order->status === 'delivered')
                                <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-primary">
                                    Order Receipt
                                </a>
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
                <h2 class="empty-title">No Order History</h2>
                <p class="empty-text">You don't have any completed or cancelled orders yet. Complete some orders to see your history here.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
            </div>
        @endif
    </div>
@endsection