@extends('layouts.app2')

@section('content')
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: white;
        color: #333;
        line-height: 1.6;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 30px 16px 100px;
    }

    .page-header {
        margin: 80px 0 40px;
    }

    .page-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
    }

    .alert-info {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 6px;
        font-size: 14px;
    }

    .required {
        color: #dc2626;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
    }

    .form-input:focus,
    .form-select:focus {
        border-color: #2563eb;
        outline: none;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        border: 1px solid;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-primary {
        background-color: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .btn-cancel {
        background-color: white;
        color: #6b7280;
        border-color: #d1d5db;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">Tambah Alamat</h1>
        <p class="page-subtitle">Tambahkan alamat pengiriman baru</p>
    </div>

    @if(auth()->user()->phone)
    <div class="alert alert-info">
        Alamat ini akan menggunakan nomor telepon: <strong>{{ auth()->user()->phone }}</strong>
    </div>
    @else
    <div class="alert alert-warning">
        Harap <a href="{{ route('profil') }}">lengkapi nomor telepon</a> di profil terlebih dahulu
    </div>
    @endif

    <form method="POST" action="{{ route('address.store') }}" id="addressForm">
        @csrf

        <input type="hidden" name="district_id" id="district_id">
        <input type="hidden" name="district_name" id="district_name">

        <div class="form-grid">
            <div class="form-group">
                <label for="label" class="form-label">Label Alamat</label>
                <input type="text" name="label" id="label" value="{{ old('label') }}"
                    placeholder="Rumah, Kantor, Kos..." class="form-input">
            </div>

            <div class="form-group">
                <label for="recipient_name" class="form-label">
                    Nama Penerima <span class="required">*</span>
                </label>
                <input type="text" name="recipient_name" id="recipient_name"
                    value="{{ old('recipient_name', auth()->user()->name) }}"
                    required class="form-input">
            </div>
        </div>

        <!-- RajaOngkir Location Selector -->
        <div class="form-group">
            <label for="province_select" class="form-label">
                Provinsi <span class="required">*</span>
            </label>
            <select name="province" id="province_select" class="form-select" required>
                <option value="">Pilih Provinsi</option>
            </select>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="city_select" class="form-label">
                    Kota/Kabupaten <span class="required">*</span>
                </label>
                <select name="city" id="city_select" class="form-select" required disabled>
                    <option value="">Pilih Kota</option>
                </select>
            </div>

            <div class="form-group">
                <label for="district_select" class="form-label">
                    Kecamatan <span class="required">*</span>
                </label>
                <select id="district_select" class="form-select" required disabled>
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="address" class="form-label">
                Alamat Lengkap <span class="required">*</span>
            </label>
            <textarea name="address" id="address" required class="form-input"
                style="min-height: 100px;"
                placeholder="Jalan, RT/RW, Kelurahan...">{{ old('address') }}</textarea>
        </div>

        <div class="form-group">
            <label for="postal_code" class="form-label">
                Kode Pos <span class="required">*</span>
            </label>
            <input type="text" name="postal_code" id="postal_code"
                value="{{ old('postal_code') }}" required class="form-input">
        </div>

        <div class="form-group">
            <label for="notes" class="form-label">Catatan (Opsional)</label>
            <textarea name="notes" id="notes" class="form-input" style="min-height: 80px;"
                placeholder="Patokan atau petunjuk untuk kurir...">{{ old('notes') }}</textarea>
        </div>

        <div style="margin: 20px 0;">
            <label style="display: flex; align-items: center; gap: 8px;">
                <input type="checkbox" name="is_default" value="1"
                    {{ old('is_default') ? 'checked' : '' }}>
                <span>Jadikan sebagai alamat utama</span>
            </label>
        </div>

        <div class="form-actions">
            <a href="{{ route('address.index') }}" class="btn btn-cancel">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Alamat</button>
        </div>
    </form>
</div>

<script>
    // Load provinces on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadProvinces();
    });

    function loadProvinces() {
        fetch('/api/rajaongkir/provinces')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const select = document.getElementById('province_select');
                    data.data.forEach(province => {
                        const option = new Option(province.name, province.name);
                        option.dataset.provinceId = province.id;
                        select.add(option);
                    });
                } else {
                    console.error('Failed to load provinces:', data.message);
                }
            })
            .catch(err => console.error('Error loading provinces:', err));
    }


    // Province change
    document.getElementById('province_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const provinceId = selectedOption.dataset.provinceId;

        const citySelect = document.getElementById('city_select');
        const districtSelect = document.getElementById('district_select');

        citySelect.innerHTML = '<option value="">Pilih Kota</option>';
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        citySelect.disabled = true;
        districtSelect.disabled = true;

        if (provinceId) {
            fetch(`/api/rajaongkir/cities/${provinceId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        data.data.forEach(city => {
                            const option = new Option(city.name, city.name);
                            option.dataset.cityId = city.id;
                            citySelect.add(option);
                        });
                        citySelect.disabled = false;
                    }
                });
        }
    });

    // City change
    document.getElementById('city_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const cityId = selectedOption.dataset.cityId;

        const districtSelect = document.getElementById('district_select');
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        districtSelect.disabled = true;

        if (cityId) {
            fetch(`/api/rajaongkir/districts/${cityId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        data.data.forEach(district => {
                            const option = new Option(district.name, district.name);
                            option.dataset.districtId = district.id;
                            districtSelect.add(option);
                        });
                        districtSelect.disabled = false;
                    }
                });
        }
    });

    // District change
    document.getElementById('district_select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const districtId = selectedOption.dataset.districtId;
        const districtName = selectedOption.text;

        document.getElementById('district_id').value = districtId;
        document.getElementById('district_name').value = districtName;
    });

    // Form validation
    document.getElementById('addressForm').addEventListener('submit', function(e) {
        const districtId = document.getElementById('district_id').value;

        if (!districtId) {
            e.preventDefault();
            alert('Mohon pilih kecamatan terlebih dahulu');
            return false;
        }
    });
</script>
@endsection
