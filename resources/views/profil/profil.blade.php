@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        background-color: #ffffff;
        color: #1d1d1f;
        line-height: 1.5;
    }

    .profile-container {
        /* margin-top: 90px; */
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 20px;
        align-items: start;
        padding-top: 80px;
    }

    /* Left Sidebar */
    .profile-sidebar {
        background: transparent;
        position: sticky;
        top: 20px;
    }

    .profile-header {
        padding: 0;
        text-align: left;
        background: transparent;
        margin-bottom: 40px;
    }

    .profile-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: #e5e5e7;
        margin: 0 0 15px 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #86868b;
        font-weight: 600;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
        color: #1d1d1f;
    }

    .profile-greeting {
        display: none;
    }

    .profile-actions {
        display: none;
    }

    .btn-profile {
        display: none;
    }

    /* Profile Info Sections */
    .profile-info-section {
        padding: 0;
        border-bottom: none;
        margin-bottom: 32px;
    }

    .profile-info-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .section-title {
        font-size: 13px;
        font-weight: 600;
        color: #1d1d1f;
        margin-bottom: 15px;
        text-transform: none;
    }

    .info-item {
        margin-bottom: 12px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-label {
        font-size: 11px;
        color: #86868b;
        margin-bottom: 2px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .info-value {
        font-size: 13px;
        color: #1d1d1f;
        font-weight: 400;
    }

    /* Main Content */
    .profile-main {
        /* background: white; */
        border-radius: 12px;
        /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); */
        overflow: hidden;
    }

    .main-header {
        padding: 20px 24px;
        /* border-bottom: 1px solid #f0f0f0; */
        /* background: white; */
    }

    .main-header-greeting {
        font-size: 16px;
        font-weight: 500;
        color: #1d1d1f;
        margin-bottom: 16px;
    }

    .main-header-actions {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }

    .btn-header {
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        border: 1px solid #d2d2d7;
        background: white;
        color: #1d1d1f;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        white-space: nowrap;
    }

    .btn-header:hover {
        background: #f5f5f7;
        border-color: #86868b;
        text-decoration: none;
        color: #1d1d1f;
    }

    .main-title {
        font-size: 16px;
        font-weight: 600;
        color: #1d1d1f;
    }

    .order-list {
    padding: 0;
    margin-top: 20px; /* pisahkan dari main-header */
    display: flex;
    flex-direction: column;
    gap: 12px; /* jarak antar item */
}

.order-item {
    padding: 16px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    background: #2c2c2e;
    border-radius: 12px; /* border radius */
    transition: background-color 0.2s ease, transform 0.2s ease;
}

.order-item:hover {
    background: #3a3a3c;
    transform: translateY(-2px); /* efek hover */
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.order-item:last-child {
    border-bottom: none; /* hilangkan border lama */
}


    .order-info {
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 0;
    }

    .order-details {
        flex: 1;
        min-width: 0;
    }

    .product-name {
        font-size: 14px;
        font-weight: 500;
        color: white;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .order-date {
        font-size: 12px;
        color: #a1a1a6;
    }

    .order-price {
        font-size: 14px;
        font-weight: 500;
        color: white;
        margin: 0 16px;
        white-space: nowrap;
    }

    .order-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        text-transform: capitalize;
        margin-right: 12px;
        white-space: nowrap;
    }

    .status-pending,
    .status-awaiting {
        background: #b8860b;
        color: #fff8dc;
    }

    .status-delivered {
        background: #228b22;
        color: #f0fff0;
    }

    .status-processing,
    .status-shipped {
        background: #4682b4;
        color: #f0f8ff;
    }

    .status-cancelled {
        background: #dc143c;
        color: #ffe4e1;
    }

    .order-arrow {
        color: #86868b;
        font-size: 14px;
        transition: all 0.2s;
        width: 20px;
        text-align: center;
    }

    .order-item:hover .order-arrow {
        color: #a1a1a6;
        transform: translateX(2px);
    }

    /* Empty State */
    .empty-state {
        padding: 60px 24px;
        text-align: center;
        color: #86868b;
    }

    .empty-state-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #1d1d1f;
    }

    .empty-state-text {
        font-size: 14px;
        color: #86868b;
    }

    /* Alert Messages */
    .alert {
        padding: 12px 24px;
        margin: 16px 24px 0;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert ul {
        margin: 0;
        padding-left: 16px;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from { 
            opacity: 0; 
            transform: translateY(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    .modal-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 600;
        color: #1d1d1f;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #86868b;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .modal-close:hover {
        background: #f5f5f7;
        color: #1d1d1f;
    }

    .modal-body {
        padding: 20px 24px 24px;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #1d1d1f;
        margin-bottom: 6px;
    }

    .form-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d2d2d7;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        transition: all 0.2s;
        font-family: inherit;
    }

    .form-input:focus {
        outline: none;
        border-color: #007aff;
        box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.1);
    }

    .form-input.is-invalid {
        border-color: #ff3b30;
    }

    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: #ff3b30;
        margin-top: 4px;
    }

    .radio-group {
        display: flex;
        gap: 20px;
        margin-bottom: 16px;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .radio-option input[type="radio"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: #007aff;
    }

    .radio-option label {
        font-size: 14px;
        color: #1d1d1f;
        cursor: pointer;
        font-weight: 400;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #f0f0f0;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid transparent;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        font-family: inherit;
    }

    .btn-secondary {
        background: #f5f5f7;
        color: #86868b;
        border-color: #d2d2d7;
    }

    .btn-secondary:hover {
        background: #e5e5ea;
        color: #1d1d1f;
    }

    .btn-primary {
        background: #007aff;
        color: white;
        border-color: #007aff;
    }

    .btn-primary:hover {
        background: #0056b3;
        border-color: #0056b3;
    }

    /* Responsive */
            @media (max-width: 768px) {
        .profile-container {
            grid-template-columns: 1fr;
            gap: 16px;
            padding: 16px;
        }

        .profile-sidebar {
            position: static;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .profile-avatar {
            margin: 0 auto 15px;
        }

        .main-header-actions {
            justify-content: center;
        }

        .profile-info-section {
            margin-bottom: 24px;
        }

        .order-item {
            padding: 16px 16px;
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .order-info {
            justify-content: space-between;
        }

        .order-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .modal-content {
            width: 95%;
            margin: 20px;
        }

        .modal-body {
            padding: 16px 20px 20px;
        }

        .main-header,
        .alert {
            padding-left: 16px;
            padding-right: 16px;
        }

        .empty-state {
            padding: 48px 16px;
        }
    }
</style>

<div class="profile-container">
    <!-- Left Sidebar -->
    <div class="profile-sidebar">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                @if($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" alt="Profile Avatar">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            <div class="profile-name">{{ $user->name }}</div>
        </div>

        <!-- Identity Section -->
        <div class="profile-info-section">
            <div class="section-title">Identity</div>
            <div class="info-item">
                <div class="info-label">Birth Date</div>
                <div class="info-value">{{ $user->birth_date ? $user->birth_date->format('j F Y') : 'Belum diatur' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Gender</div>
                <div class="info-value">{{ $user->gender_label ?? 'Male' }}</div>
            </div>
        </div>

        <!-- Contacts Section -->
        <div class="profile-info-section">
            <div class="section-title">Contacts</div>
            <div class="info-item">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $user->phone ?: '+62 812 9245 8877' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">E-Mail</div>
                <div class="info-value">{{ $user->email }}</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="profile-main">
        <!-- Display Alert Messages -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="main-header">
            <div class="main-header-greeting">Hello, {{ explode(' ', $user->name)[0] }}!</div>
            <div class="main-header-actions">
                <button class="btn-header" onclick="openModal('profileModal')">Edit Profile</button>
                <button class="btn-header" onclick="openModal('passwordModal')">Edit Password</button>
            </div>
            <div class="main-title">Order History</div>
        </div>

        <div class="order-list">
            @forelse($orders as $order)
                @foreach($order->orderItems as $orderItem)
                <div class="order-item" onclick="window.location.href='{{ route('orders.show', $order->order_number) }}'">
                    <div class="order-info">
                        <div class="order-details">
                            <div class="product-name">{{ $orderItem->product_name }}</div>
                            <div class="order-date">
                                {{ $order->created_at->format('H:i') }} {{ $order->created_at->translatedFormat('M d, Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="order-price">Rp. {{ number_format($orderItem->subtotal) }}</div>
                    <div class="order-status status-{{ $order->status }}">
                        @switch($order->status)
                            @case('pending')
                                Awaiting
                                @break
                            @case('processing')
                                Processing
                                @break
                            @case('shipped')
                                Shipped
                                @break
                            @case('delivered')
                                Delivered
                                @break
                            @case('cancelled')
                                Cancelled
                                @break
                            @default
                                Awaiting
                        @endswitch
                    </div>
                    <div class="order-arrow">&rsaquo;</div>
                </div>
                @endforeach
            @empty
                <!-- Sample data untuk demo sesuai gambar -->
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-details">
                            <div class="product-name">Kaos Murzan T-Shirt</div>
                            <div class="order-date">06:140 Des 20, 2025</div>
                        </div>
                    </div>
                    <div class="order-price">$ 126.50</div>
                    <div class="order-status status-pending">Awaiting</div>
                    <div class="order-arrow">&rsaquo;</div>
                </div>
                
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-details">
                            <div class="product-name">Kaos Murzan T-Shirt</div>
                            <div class="order-date">06:40 Des 20, 2025</div>
                        </div>
                    </div>
                    <div class="order-price">$ 126.50</div>
                    <div class="order-status status-pending">Awaiting</div>
                    <div class="order-arrow">&rsaquo;</div>
                </div>
                
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-details">
                            <div class="product-name">Kaos Murzan T-Shirt</div>
                            <div class="order-date">06:40 Des 20, 2025</div>
                        </div>
                    </div>
                    <div class="order-price">$ 126.50</div>
                    <div class="order-status status-pending">Awaiting</div>
                    <div class="order-arrow">&rsaquo;</div>
                </div>
                
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-details">
                            <div class="product-name">Kaos Murzan T-Shirt</div>
                            <div class="order-date">06:40 Des 20, 2025</div>
                        </div>
                    </div>
                    <div class="order-price">$ 126.50</div>
                    <div class="order-status status-pending">Awaiting</div>
                    <div class="order-arrow">&rsaquo;</div>
                </div>
                
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-details">
                            <div class="product-name">Kaos Murzan T-Shirt</div>
                            <div class="order-date">06:40 Des 20, 2025</div>
                        </div>
                    </div>
                    <div class="order-price">$ 126.50</div>
                    <div class="order-status status-delivered">Delivered</div>
                    <div class="order-arrow">&rsaquo;</div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Profile Edit Modal -->
<div id="profileModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">Edit Profile</div>
            <button class="modal-close" onclick="closeModal('profileModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('profil.update') }}">
                @csrf
                @method('PUT')

                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="male" name="gender" value="male" 
                               {{ old('gender', $user->gender ?? 'male') == 'male' ? 'checked' : '' }}>
                        <label for="male">Laki-laki</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="female" name="gender" value="female"
                               {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}>
                        <label for="female">Perempuan</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="phone">Nomor Telepon</label>
                        <input type="tel" id="phone" name="phone" class="form-input @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="birth_date">Tanggal Lahir</label>
                        <input type="date" id="birth_date" name="birth_date" class="form-input @error('birth_date') is-invalid @enderror" 
                               value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}">
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('profileModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Edit Modal -->
<div id="passwordModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">Edit Password</div>
            <button class="modal-close" onclick="closeModal('passwordModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('profil.update-password') }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="current_password">Password Lama</label>
                    <input type="password" id="current_password" name="current_password" 
                           class="form-input @error('current_password') is-invalid @enderror" 
                           placeholder="••••••••" required>
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="new_password">Password Baru</label>
                    <input type="password" id="new_password" name="new_password" 
                           class="form-input @error('new_password') is-invalid @enderror" 
                           placeholder="••••••••" required>
                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div style="font-size: 12px; color: #86868b; margin-top: 4px;">Password baru minimal harus 8 karakter.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="new_password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" 
                           class="form-input" placeholder="••••••••" required>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('passwordModal')">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Focus first input in modal
        setTimeout(() => {
            const firstInput = modal.querySelector('input:not([type="radio"])');
            if (firstInput) firstInput.focus();
        }, 300);
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('show');
            document.body.style.overflow = 'auto';
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const openModals = document.querySelectorAll('.modal.show');
            openModals.forEach(modal => {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            });
        }
    });

    // Auto hide alert messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        if (alerts.length > 0) {
            setTimeout(() => {
                alerts.forEach(alert => {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.3s ease-out';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                });
            }, 5000);
        }
    });

    // Form validation feedback
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.form-input');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.hasAttribute('required') && !this.value.trim()) {
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                }
            });

            input.addEventListener('input', function() {
                if (this.classList.contains('is-invalid') && this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    });
</script>
@endsection