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
        background-color: white;
        color: #333;
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        min-height: 100vh;
        padding-top: 30px;
    }

    .page-header {
        margin: 80px 0 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-content {
        flex: 1;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
        letter-spacing: -0.01em;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    .add-address-btn {
        background: transparent;
        color: black;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        border: 1px solid black;
    }

    .success-alert {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
    }

    .address-grid {
        display: grid;
        gap: 16px;
        margin-bottom: 100px;
    }

    .address-card {
        background: white;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
    }

    .address-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        border-color: #e5e7eb;
    }

    /* Border untuk alamat utama */
    .address-card.is-default {
        border: 2px solid black;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.1);
    }

    .address-card.is-default:hover {
        box-shadow: 0 6px 16px rgba(22, 163, 74, 0.15);
        border-color: black;
    }

    /* Border untuk alamat tunggal (hanya ada 1 alamat) */
    .address-card.single-address {
        border: 2px solid #2563eb;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
    }

    .address-card.single-address:hover {
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.15);
        border-color: #2563eb;
    }

    /* Jika alamat adalah default DAN satu-satunya alamat */
    .address-card.is-default.single-address {
        border: 2px solid black;
        box-shadow: 0 4px 12px rgba(22, 163, 74, 0.1);
    }

    .address-card.is-default.single-address:hover {
        box-shadow: 0 6px 16px rgba(22, 163, 74, 0.15);
        border-color: black;
    }

    .address-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .address-info {
        flex: 1;
        min-width: 0;
    }

    .badge-container {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .badge-label {
        background: #f3f4f6;
        color: #374151;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-default {
        background: #f0fdf4;
        color: #16a34a;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .recipient-info {
        margin-bottom: 12px;
    }

    .recipient-name {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .recipient-phone {
        color: #6b7280;
        font-size: 14px;
    }

    .address-details {
        margin-bottom: 12px;
    }

    .address-text {
        color: #1f2937;
        font-size: 14px;
        margin-bottom: 2px;
        line-height: 1.4;
    }

    .address-location {
        color: #6b7280;
        font-size: 13px;
    }

    .address-notes {
        background: #f9fafb;
        padding: 8px 12px;
        border-radius: 6px;
        border-left: 3px solid #e5e7eb;
    }

    .notes-text {
        font-size: 12px;
        color: #6b7280;
        line-height: 1.4;
    }

    .address-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex-shrink: 0;
    }

    .action-btn {
        background: none;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: left;
    }

    .action-primary {
        color: #2563eb;
        background: #eff6ff;
    }

    .action-primary:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .action-secondary {
        color: #6b7280;
        background: #f9fafb;
    }

    .action-secondary:hover {
        background: #f3f4f6;
        color: #374151;
        text-decoration: none;
    }

    .action-danger {
        color: #dc2626;
        background: #fef2f2;
    }

    .action-danger:hover {
        background: #fee2e2;
        color: #b91c1c;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
    }

    .empty-icon {
        width: 64px;
        height: 64px;
        background: #f9fafb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .empty-title {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .empty-description {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .back-to-profile {
        margin-top: 40px;
        text-align: center;
    }

    .back-link {
        color: #6b7280;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .back-link:hover {
        color: #374151;
        text-decoration: none;
    }

    /* Responsive Design */
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

        .address-content {
            flex-direction: column;
            gap: 16px;
        }

        .address-actions {
            flex-direction: row;
            justify-content: flex-start;
        }

        .action-btn {
            flex: 1;
            text-align: center;
        }

        .add-address-btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .badge-container {
            flex-wrap: wrap;
        }

        .address-actions {
            flex-direction: column;
        }

        .action-btn {
            flex: none;
            text-align: left;
        }
    }

    /* Form styling for consistency */
    form {
        display: inline-block;
        width: 100%;
    }

    form .action-btn {
        width: 100%;
    }

    /* Icon styling */
    svg {
        flex-shrink: 0;
    }

    /* Smooth transitions */
    * {
        transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }
</style>

<div class="container">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">Alamat Saya</h1>
            <p class="page-subtitle">Kelola alamat pengiriman Anda</p>
        </div>
        <a href="{{ route('address.create') }}" class="add-address-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Tambah Alamat</span>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="success-alert">
        {{ session('success') }}
    </div>
    @endif

    <!-- Addresses List -->
    @if($addresses->count() > 0)
    <div class="address-grid">
        @foreach($addresses as $address)
        <div class="address-card {{ $address->is_default ? 'is-default' : '' }} {{ $addresses->count() == 1 ? 'single-address' : '' }}">
            <div class="address-content">
                <div class="address-info">
                    <!-- Address Label and Default Badge -->
                    <div class="badge-container">
                        @if($address->label)
                        <span class="badge-label">{{ $address->label }}</span>
                        @endif
                        @if($address->is_default)
                        <span class="badge-default">
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Alamat Utama
                        </span>
                        @endif
                    </div>

                    <!-- Recipient Info -->
                    <div class="recipient-info">
                        <h3 class="recipient-name">{{ $address->recipient_name }}</h3>
                        <p class="recipient-phone">{{ $address->user->phone ?? 'Nomor telepon belum diset' }}</p>
                    </div>

                    <!-- Address -->
                    <div class="address-details">
                        <p class="address-text">{{ $address->address }}</p>
                        <p class="address-location">{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                    </div>

                    <!-- Notes -->
                    @if($address->notes)
                    <div class="address-notes">
                        <p class="notes-text">
                            <strong>Catatan:</strong> {{ $address->notes }}
                        </p>
                    </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="address-actions">
                    @if(!$address->is_default)
                    <form method="POST" action="{{ route('address.set-default', $address) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="action-btn action-primary">
                            Jadikan Utama
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('address.edit', $address) }}" class="action-btn action-secondary">
                        Edit
                    </a>

                    @if(!$address->is_default || $addresses->count() > 1)
                    <form method="POST" action="{{ route('address.destroy', $address) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn action-danger">
                            Hapus
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="32" height="32" fill="none" stroke="#6b7280" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </div>
        <h3 class="empty-title">Belum ada alamat</h3>
        <p class="empty-description">Tambahkan alamat pengiriman untuk memudahkan proses checkout</p>
        <a href="{{ route('address.create') }}" class="add-address-btn">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Alamat Pertama
        </a>
    </div>
    @endif

    <!-- Uncomment if you want the back to profile link -->
    <!--
    <div class="back-to-profile">
        <a href="{{ route('profil') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Profil
        </a>
    </div>
    -->
</div>
@endsection