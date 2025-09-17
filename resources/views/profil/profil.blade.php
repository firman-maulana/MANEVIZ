@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        background-color: #f8fafc;
        margin: 0;
        padding: 0;
    }

    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        display: flex;
        gap: 40px;
    }

    /* Left Sidebar */
    .profile-sidebar {
        width: 300px;
        background: white;
        border-radius: 12px;
        padding: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        height: fit-content;
        flex-shrink: 0;
    }

    .profile-header {
        text-align: center;
        padding: 40px 30px 30px;
        border-bottom: 1px solid #f1f5f9;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #e2e8f0;
        margin: 0 auto 20px;
        overflow: hidden;
        border: 4px solid #f8fafc;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-name {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }

    .profile-greeting {
        font-size: 16px;
        color: #64748b;
        margin-bottom: 25px;
    }

    .profile-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btn-profile {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-edit-profile {
        background: #ef4444;
        color: white;
    }

    .btn-edit-profile:hover {
        background: #dc2626;
        color: white;
        text-decoration: none;
    }

    .btn-edit-password {
        background: #ef4444;
        color: white;
    }

    .btn-edit-password:hover {
        background: #dc2626;
        color: white;
        text-decoration: none;
    }

    /* Profile Info Sections */
    .profile-info-section {
        padding: 25px 30px;
    }

    .profile-info-section:not(:last-child) {
        border-bottom: 1px solid #f1f5f9;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 15px;
    }

    .info-item {
        margin-bottom: 12px;
    }

    .info-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 15px;
        color: #334155;
        font-weight: 500;
    }

    /* Main Content */
    .profile-main {
        flex: 1;
        background: white;
        border-radius: 12px;
        padding: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .main-header {
        padding: 30px 40px;
        border-bottom: 1px solid #f1f5f9;
    }

    .main-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
    }

    .order-list {
        padding: 0;
    }

    .order-item {
        padding: 20px 40px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s;
        background: #1e293b;
        color: white;
        margin-bottom: 2px;
        cursor: pointer;
    }

    .order-item:hover {
        background: #334155;
    }

    .order-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .order-item.delivered {
        background: #1e293b;
    }

    .order-item.delivered:hover {
        background: #334155;
    }

    .order-info {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
    }

    .product-name {
        font-size: 16px;
        font-weight: 600;
        color: white;
    }

    .order-date {
        font-size: 14px;
        color: #cbd5e1;
    }

    .order-price {
        font-size: 16px;
        font-weight: 600;
        color: white;
        margin-right: 20px;
    }

    .order-status {
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        text-transform: capitalize;
        margin-right: 15px;
    }

    .status-awaiting,
    .status-pending {
        background: #92400e;
        color: #fbbf24;
    }

    .status-delivered {
        background: #15803d;
        color: #22c55e;
    }

    .status-processing,
    .status-shipped {
        background: #1e40af;
        color: #60a5fa;
    }

    .status-cancelled {
        background: #dc2626;
        color: #f87171;
    }

    .order-arrow {
        color: #94a3b8;
        font-size: 18px;
    }

    /* Alert Messages */
    .alert {
        padding: 12px 16px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
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
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 25px 30px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 600;
        color: #1e293b;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #64748b;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .modal-close:hover {
        background: #f1f5f9;
        color: #1e293b;
    }

    .modal-body {
        padding: 30px;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        transition: all 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-input.is-invalid {
        border-color: #ef4444;
    }

    .invalid-feedback {
        display: block;
        font-size: 12px;
        color: #ef4444;
        margin-top: 4px;
    }

    .radio-group {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .radio-option {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .radio-option input[type="radio"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #ef4444;
    }

    .radio-option label {
        font-size: 14px;
        color: #374151;
        cursor: pointer;
        font-weight: 500;
    }

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-row .form-group {
        flex: 1;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid transparent;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #64748b;
        border-color: #e2e8f0;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        color: #475569;
    }

    .btn-primary {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
    }

    .btn-primary:hover {
        background: #dc2626;
        border-color: #dc2626;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-container {
            flex-direction: column;
            gap: 20px;
            padding: 20px 15px;
        }

        .profile-sidebar {
            width: 100%;
        }

        .order-item {
            padding: 15px 20px;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
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
            flex-direction: column;
            gap: 0;
        }

        .modal-content {
            width: 95%;
            margin: 20px;
        }

        .modal-body {
            padding: 20px;
        }
    }
</style>

<div class="profile-container">
    <!-- Left Sidebar -->
    <div class="profile-sidebar">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar">
                <img src="{{ $user->avatar_url }}" alt="Profile Avatar">
            </div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-greeting">Hello, {{ explode(' ', $user->name)[0] }}!</div>
            
            <div class="profile-actions">
                <button class="btn-profile btn-edit-profile" onclick="openModal('profileModal')">Edit Profile</button>
                <button class="btn-profile btn-edit-password" onclick="openModal('passwordModal')">Edit Password</button>
            </div>
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
                <div class="info-value">{{ $user->gender_label }}</div>
            </div>
        </div>

        <!-- Contacts Section -->
        <div class="profile-info-section">
            <div class="section-title">Contacts</div>
            <div class="info-item">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $user->phone ?: 'Belum diatur' }}</div>
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
        <div class="alert alert-success" style="margin: 20px 40px 0;">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error" style="margin: 20px 40px 0;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="main-header">
            <div class="main-title">Order History</div>
        </div>

        <div class="order-list">
            @forelse($orders as $order)
                @foreach($order->orderItems as $orderItem)
                <div class="order-item {{ $order->status == 'delivered' ? 'delivered' : '' }}" onclick="window.location='{{ route('orders.show', $order->order_number) }}'">
                    <div class="order-info">
                        <div>
                            <div class="product-name">{{ $orderItem->product_name }}</div>
                            <div class="order-date">
                                {{ $order->created_at->format('H:i') }} {{ $order->created_at->translatedFormat('M d, Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="order-price">Rp {{ number_format($orderItem->subtotal, 0, ',', '.') }}</div>
                    <div class="order-status status-{{ $order->status }}">
                        @switch($order->status)
                            @case('pending')
                                Menunggu
                                @break
                            @case('processing')
                                Diproses
                                @break
                            @case('shipped')
                                Dikirim
                                @break
                            @case('delivered')
                                Terkirim
                                @break
                            @case('cancelled')
                                Dibatalkan
                                @break
                            @default
                                {{ ucfirst($order->status) }}
                        @endswitch
                    </div>
                    <div class="order-arrow">›</div>
                </div>
                @endforeach
            @empty
                <div style="padding: 40px; text-align: center; color: #64748b;">
                    <div style="font-size: 18px; margin-bottom: 8px;">Belum Ada Order</div>
                    <div style="font-size: 14px;">Mulai berbelanja untuk melihat riwayat pesanan Anda</div>
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
                               {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}>
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
                    <div style="font-size: 12px; color: #64748b; margin-top: 4px;">Password baru minimal harus 8 karakter.</div>
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
        document.getElementById(modalId).classList.add('show');
        document.body.style.overflow = 'hidden';
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

    // Auto hide alert messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }, 5000);
    });
</script>
@endsection