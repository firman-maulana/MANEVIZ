@extends('layouts.app2')

@section('content')
<style>
    .address-container {
        margin-top: 50px;
        min-height: 100vh;
        background-color: #f8f9fa;
        padding: 2rem 0;
    }
    .address-wrapper {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .header-section {
        margin-bottom: 3rem;
    }
    .header-flex {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .back-button {
        background: white;
        border: 1px solid #dee2e6;
        color: #6c757d;
        padding: 0.5rem;
        border-radius: 8px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        transition: all 0.2s ease;
    }
    .back-button:hover {
        background-color: #f8f9fa;
        color: #495057;
        border-color: #adb5bd;
    }
    .header-title {
        font-size: 2rem;
        font-weight: bold;
        color: #212529;
        margin: 0;
    }
    .header-subtitle {
        color: #6c757d;
        margin: 0;
        font-size: 1rem;
    }
    .info-alert, .warning-alert {
        background-color: #cff4fc;
        border: 1px solid #b6effb;
        color: #055160;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .warning-alert {
        background-color: #fff3cd;
        border-color: #ffecb5;
        color: #664d03;
    }
    .alert-icon {
        width: 24px;
        height: 24px;
        flex-shrink: 0;
    }
    .phone-number {
        background: rgba(0, 0, 0, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 600;
    }
    .alert-link {
        color: inherit;
        text-decoration: underline;
        font-weight: 600;
    }
    .alert-link:hover {
        opacity: 0.8;
    }
    .form-card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    .required {
        color: #dc3545;
    }
    .optional {
        color: #6c757d;
        font-weight: 400;
    }
    .form-input, .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        border-radius: 8px;
        font-size: 1rem;
        color: #212529;
        background: white;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-input:focus, .form-textarea:focus {
        border-color: #86b7fe;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    .checkbox-container {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-checkbox {
        width: 18px;
        height: 18px;
    }
    .checkbox-label {
        font-weight: 500;
        color: #212529;
        cursor: pointer;
        margin: 0;
    }
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid #dee2e6;
        margin-top: 1.5rem;
    }
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        border: 1px solid transparent;
        font-size: 1rem;
        transition: all 0.2s ease;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border-color: #6c757d;
    }
    .btn-secondary:hover {
        background-color: #5c636a;
        border-color: #565e64;
        color: white;
    }
    .btn-primary {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        color: white;
    }
    @media (max-width: 768px) {
        .address-wrapper {
            padding: 0 0.5rem;
        }
        .form-card {
            padding: 1.5rem;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
        .form-actions {
            flex-direction: column;
        }
        .header-flex {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>

<div class="address-container">
    <div class="address-wrapper">
        <!-- Header -->
        <div class="header-section">
            <div class="header-flex">
                <a href="{{ route('address.index') }}" class="back-button">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="header-title">Tambah Alamat Baru</h1>
                    <p class="header-subtitle">Masukkan detail alamat pengiriman Anda</p>
                </div>
            </div>
        </div>

        <!-- Phone Number Info -->
        @if(auth()->user()->phone)
        <div class="info-alert">
            <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                Alamat ini akan menggunakan nomor telepon dari profil Anda: 
                <span class="phone-number">{{ auth()->user()->phone }}</span>
            </div>
        </div>
        @else
        <div class="warning-alert">
            <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            <div>
                Nomor telepon belum diset di profil Anda. Silakan 
                <a href="{{ route('profil') }}" class="alert-link">perbarui profil</a> 
                terlebih dahulu.
            </div>
        </div>
        @endif

        <!-- Form -->
        <div class="form-card">
            <form method="POST" action="{{ route('address.store') }}">
                @csrf

                <!-- Label -->
                <div class="form-group">
                    <label for="label" class="form-label">
                        Label Alamat <span class="optional">(Opsional)</span>
                    </label>
                    <input type="text" 
                           name="label" 
                           id="label"
                           value="{{ old('label') }}"
                           placeholder="Contoh: Rumah, Kantor, Kos"
                           class="form-input">
                    @error('label')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Recipient Name -->
                <div class="form-group">
                    <label for="recipient_name" class="form-label">
                        Nama Penerima <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="recipient_name" 
                           id="recipient_name"
                           value="{{ old('recipient_name', auth()->user()->name) }}"
                           required
                           class="form-input">
                    @error('recipient_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address" class="form-label">
                        Alamat Lengkap <span class="required">*</span>
                    </label>
                    <textarea name="address" 
                              id="address"
                              required
                              placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan"
                              class="form-textarea">{{ old('address') }}</textarea>
                    @error('address')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- City and Province -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="city" class="form-label">
                            Kota/Kabupaten <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="city" 
                               id="city"
                               value="{{ old('city') }}"
                               required
                               class="form-input">
                        @error('city')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="province" class="form-label">
                            Provinsi <span class="required">*</span>
                        </label>
                        <input type="text" 
                               name="province" 
                               id="province"
                               value="{{ old('province') }}"
                               required
                               class="form-input">
                        @error('province')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Postal Code -->
                <div class="form-group">
                    <label for="postal_code" class="form-label">
                        Kode Pos <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="postal_code" 
                           id="postal_code"
                           value="{{ old('postal_code') }}"
                           required
                           maxlength="10"
                           class="form-input">
                    @error('postal_code')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes" class="form-label">
                        Catatan <span class="optional">(Opsional)</span>
                    </label>
                    <textarea name="notes" 
                              id="notes"
                              placeholder="Patokan atau petunjuk tambahan untuk kurir"
                              class="form-textarea">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="error-message">{{ $message }}</div>
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
                            Jadikan sebagai alamat utama
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('address.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection