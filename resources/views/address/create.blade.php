@extends('layouts.app')

@section('content')
<style>
    .address-create-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem 0;
        position: relative;
        overflow: hidden;
    }

    .address-create-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.1"><circle cx="36" cy="34" r="3"/><circle cx="6" cy="6" r="3"/><circle cx="36" cy="6" r="3"/><circle cx="6" cy="36" r="3"/></g></svg>') repeat;
        opacity: 0.3;
    }

    .create-wrapper {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1.5rem;
        position: relative;
        z-index: 1;
    }

    .create-header {
        margin-bottom: 2rem;
        position: relative;
    }

    .header-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .back-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 15px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: white;
    }

    .header-content {
        flex: 1;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        margin: 0 0 0.5rem 0;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header-subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.1rem;
        margin: 0;
        font-weight: 500;
    }

    .header-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 30px rgba(255, 107, 107, 0.3);
        color: white;
    }

    .info-alert {
        background: linear-gradient(135deg, #74b9ff, #0984e3);
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(116, 185, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    .warning-alert {
        background: linear-gradient(135deg, #fdcb6e, #e17055);
        border: none;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(253, 203, 110, 0.2);
        backdrop-filter: blur(10px);
    }

    .alert-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-icon {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .alert-text {
        color: white;
        font-weight: 500;
        margin: 0;
        line-height: 1.5;
    }

    .phone-number {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        margin: 0 0.25rem;
    }

    .alert-link {
        color: white;
        text-decoration: underline;
        font-weight: 700;
        transition: opacity 0.3s ease;
    }

    .alert-link:hover {
        color: white;
        opacity: 0.8;
    }

    .form-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 25px;
        padding: 3rem;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), transparent);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }

    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .form-label:hover {
        color: #667eea;
    }

    .form-label svg {
        width: 18px;
        height: 18px;
        color: #a0aec0;
    }

    .required {
        color: #e53e3e;
    }

    .optional {
        color: #718096;
        font-weight: 400;
        font-size: 0.9rem;
    }

    .form-input, .form-textarea {
        width: 100%;
        padding: 1rem 1.5rem;
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        font-size: 1rem;
        font-weight: 500;
        color: #2d3748;
        background: white;
        transition: all 0.3s ease;
        outline: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .form-input:focus, .form-textarea:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .form-input:hover, .form-textarea:hover {
        border-color: #cbd5e0;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .form-textarea {
        resize: none;
        min-height: 120px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .error-message {
        color: #e53e3e;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .error-message svg {
        width: 16px;
        height: 16px;
    }

    .checkbox-container {
        background: linear-gradient(135deg, #f7fafc, #edf2f7);
        padding: 1.5rem;
        border-radius: 15px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .checkbox-container:hover {
        background: linear-gradient(135deg, #edf2f7, #e2e8f0);
        border-color: #cbd5e0;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .form-checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid #cbd5e0;
        border-radius: 6px;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        accent-color: #667eea;
    }

    .form-checkbox:checked {
        background: #667eea;
        border-color: #667eea;
    }

    .checkbox-label {
        font-weight: 600;
        color: #2d3748;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        user-select: none;
    }

    .checkbox-label svg {
        width: 18px;
        height: 18px;
        color: #f6ad55;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 2px solid #f7fafc;
        margin-top: 2rem;
    }

    .btn {
        padding: 1rem 2rem;
        border-radius: 15px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
        border: none;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-secondary {
        background: linear-gradient(135deg, #e2e8f0, #cbd5e0);
        color: #4a5568;
        border: 2px solid transparent;
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #cbd5e0, #a0aec0);
        color: #2d3748;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a67d8, #6b46c1);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
    }

    .btn svg {
        transition: transform 0.3s ease;
    }

    .btn:hover svg {
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .create-wrapper {
            padding: 0 1rem;
        }
        
        .header-card {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .header-icon {
            display: none;
        }
        
        .header-title {
            font-size: 2rem;
        }
        
        .form-card {
            padding: 2rem;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    .animate-pulse {
        animation: pulse 2s ease-in-out infinite;
    }
</style>

<div class="address-create-container">
    <div class="create-wrapper">
        <!-- Header -->
        <div class="create-header animate-fade-in">
            <div class="header-card">
                <a href="{{ route('address.index') }}" class="back-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div class="header-content">
                    <h1 class="header-title">Tambah Alamat Baru</h1>
                    <p class="header-subtitle">Masukkan detail alamat pengiriman Anda</p>
                </div>
                <div class="header-icon animate-float">
                    <svg width="35" height="35" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Phone Number Info -->
        @if(auth()->user()->phone)
        <div class="info-alert animate-fade-in">
            <div class="alert-content">
                <div class="alert-icon">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <p class="alert-text">
                    Alamat ini akan menggunakan nomor telepon dari profil Anda: 
                    <span class="phone-number">{{ auth()->user()->phone }}</span>
                </p>
            </div>
        </div>
        @else
        <div class="warning-alert animate-fade-in animate-pulse">
            <div class="alert-content">
                <div class="alert-icon">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <p class="alert-text">
                    Nomor telepon belum diset di profil Anda. Silakan 
                    <a href="{{ route('profil') }}" class="alert-link">perbarui profil</a> 
                    terlebih dahulu.
                </p>
            </div>
        </div>
        @endif

        <!-- Form -->
        <div class="form-card animate-fade-in">
            <form method="POST" action="{{ route('address.store') }}">
                @csrf

                <!-- Label -->
                <div class="form-group">
                    <label for="label" class="form-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Label Alamat 
                        <span class="optional">(Opsional)</span>
                    </label>
                    <input type="text" 
                           name="label" 
                           id="label"
                           value="{{ old('label') }}"
                           placeholder="Contoh: Rumah, Kantor, Kos"
                           class="form-input">
                    @error('label')
                        <p class="error-message">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Recipient Name -->
                <div class="form-group">
                    <label for="recipient_name" class="form-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Nama Penerima 
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="recipient_name" 
                           id="recipient_name"
                           value="{{ old('recipient_name', auth()->user()->name) }}"
                           required
                           class="form-input">
                    @error('recipient_name')
                        <p class="error-message">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address" class="form-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Alamat Lengkap 
                        <span class="required">*</span>
                    </label>
                    <textarea name="address" 
                              id="address"
                              required
                              placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan"
                              class="form-textarea">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="error-message">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- City and Province -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="city" class="form-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Kota/Kabupaten 
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="city" 
                               id="city"
                               value="{{ old('city') }}"
                               required
                               class="form-input">
                        @error('city')
                            <p class="error-message">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="province" class="form-label">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            Provinsi 
                            <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="province" 
                               id="province"
                               value="{{ old('province') }}"
                               required
                               class="form-input">
                        @error('province')
                            <p class="error-message">
                                <svg fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Postal Code -->
                <div class="form-group">
                    <label for="postal_code" class="form-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                        Kode Pos 
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="postal_code" 
                           id="postal_code"
                           value="{{ old('postal_code') }}"
                           required
                           maxlength="10"
                           class="form-input">
                    @error('postal_code')
                        <p class="error-message">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes" class="form-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Catatan 
                        <span class="optional">(Opsional)</span>
                    </label>
                    <textarea name="notes" 
                              id="notes"
                              placeholder="Patokan atau petunjuk tambahan untuk kurir"
                              class="form-textarea">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="error-message">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Default Address Checkbox -->
                <div class="checkbox-container">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" 
                               name="is_default" 
                               id="is_default"
                               value="1"
                               {{ old('is_default') ? 'checked' : '' }}
                               class="form-checkbox">
                        <label for="is_default" class="checkbox-label">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            Jadikan sebagai alamat utama
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('address.index') }}" class="btn btn-secondary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="18" height="18">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection