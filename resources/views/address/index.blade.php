@extends('layouts.app2')

@section('content')
<style>
    .address-container {
        margin-top: 50px;
        margin-bottom: 20px;
        min-height: 100vh;
        /* background-color: #f8f9fa; */
        padding: 2rem 1rem; /* Reduced horizontal padding */
    }
    .address-wrapper {
        max-width: 1150px; /* Increased max-width */
        margin: 0 auto;
        /* padding: 0 1rem; */
    }
    .header-section {
        margin-bottom: 3rem;
    }
    .header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .header-title {
        font-size: 2rem;
        font-weight: bold;
        color: #212529;
        margin-bottom: 0.25rem;
    }
    .header-subtitle {
        color: #6c757d;
        margin: 0;
    }
    .add-address-btn {
        background-color: white;
        color: #000000;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: background-color 0.2s;
        border: 1px solid #000000;
    }
    .add-address-btn:hover {
        background-color: #000000;
        color: white;
    }
    .success-alert {
        background-color: #d1e7dd;
        border: 1px solid #badbcc;
        color: #0f5132;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .address-grid {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    .address-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        padding: 1.5rem;
    }
    .address-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .address-info {
        flex-grow: 1;
    }
    .badge-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    .badge-label {
        background-color: #6c757d;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .badge-default {
        background-color: #198754;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .recipient-info {
        margin-bottom: 1rem;
    }
    .recipient-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
    }
    .recipient-phone {
        color: #6c757d;
        margin: 0;
    }
    .address-details {
        margin-bottom: 1rem;
    }
    .address-text {
        color: #212529;
        margin-bottom: 0.25rem;
    }
    .address-location {
        color: #6c757d;
        margin: 0;
    }
    .address-notes {
        margin-bottom: 1rem;
    }
    .notes-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin: 0;
    }
    .address-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-left: 1rem;
    }
    .action-btn {
        background: none;
        border: none;
        padding: 0;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
    }
    .action-primary {
        color: #0d6efd;
    }
    .action-secondary {
        color: #6c757d;
    }
    .action-danger {
        color: #dc3545;
    }
    .action-btn:hover {
        opacity: 0.8;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 0;
    }
    .empty-icon {
        width: 96px;
        height: 96px;
        background-color: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    .empty-title {
        font-size: 1.125rem;
        font-weight: 500;
        color: #212529;
        margin-bottom: 0.5rem;
    }
    .empty-description {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    .back-to-profile {
        margin-top: 3rem;
        text-align: center;
    }
    .back-link {
        color: #6c757d;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: #495057;
    }

    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
        .address-container {
            padding: 1rem 0.5rem; /* Even less padding on mobile */
        }
        .address-wrapper {
            max-width: 100%; /* Full width on mobile */
        }
        .header-flex {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        .add-address-btn {
            justify-content: center;
        }
        .address-content {
            flex-direction: column;
            gap: 1rem;
        }
        .address-actions {
            margin-left: 0;
            flex-direction: row;
            gap: 1rem;
        }
    }
</style>

<div class="address-container">
    <div class="address-wrapper">
        <!-- Header -->
        <div class="header-section">
            <div class="header-flex">
                <div>
                    <h1 class="header-title">Alamat Saya</h1>
                    <p class="header-subtitle">Kelola alamat pengiriman Anda</p>
                </div>
                <a href="{{ route('address.create') }}" class="add-address-btn">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Tambah Alamat</span>
                </a>
            </div>
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
                <div class="address-card">
                    <div class="address-content">
                        <div class="address-info">
                            <!-- Address Label and Default Badge -->
                            <div class="badge-container">
                                @if($address->label)
                                    <span class="badge-label">{{ $address->label }}</span>
                                @endif
                                @if($address->is_default)
                                    <span class="badge-default">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
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
                    <svg width="48" height="48" fill="none" stroke="#6c757d" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="empty-title">Belum ada alamat</h3>
                <p class="empty-description">Tambahkan alamat pengiriman untuk memudahkan proses checkout</p>
                <a href="{{ route('address.create') }}" class="add-address-btn">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Alamat Pertama
                </a>
            </div>
        @endif

        <!-- Back to Profile -->
        <!-- <div class="back-to-profile">
            <a href="{{ route('profil') }}" class="back-link">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Profil
            </a>
        </div> -->
    </div>
</div>
@endsection