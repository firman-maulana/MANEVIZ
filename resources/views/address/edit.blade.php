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
        padding: 30px 16px 100px;
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

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-info {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .alert-warning {
        background: #fffbeb;
        border: 1px solid #fed7aa;
        color: #d97706;
    }

    .alert-icon {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }

    .phone-highlight {
        background: rgba(22, 163, 74, 0.1);
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 500;
    }

    .alert-link {
        color: inherit;
        text-decoration: underline;
        font-weight: 500;
    }

    .alert-link:hover {
        text-decoration: none;
    }

    .form-container {
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
        font-weight: 500;
    }

    .optional {
        color: #6b7280;
        font-weight: 400;
        font-size: 13px;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        color: #1f2937;
        background: white;
        transition: all 0.2s ease;
        font-family: 'Arial', sans-serif;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: #2563eb;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 80px;
        line-height: 1.4;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .error-message {
        color: #dc2626;
        font-size: 12px;
        margin-top: 4px;
        line-height: 1.3;
    }

    .checkbox-group {
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-checkbox {
        width: 16px;
        height: 16px;
        accent-color: #2563eb;
    }

    .checkbox-label {
        font-size: 14px;
        color: #1f2937;
        cursor: pointer;
        margin: 0;
        font-weight: 500;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
        margin-top: 24px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 1px solid;
        font-size: 12px;
        transition: all 0.2s ease;
        min-width: 80px;
    }

    .btn-cancel {
        background-color: white;
        color: #6b7280;
        border-color: #d1d5db;
    }

    .btn-cancel:hover {
        background-color: #f9fafb;
        border-color: #9ca3af;
        color: #374151;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #2563eb;
        color: white;
        border-color: #2563eb;
    }

    .btn-primary:hover {
        background-color: #1d4ed8;
        border-color: #1d4ed8;
    }

    @media (max-width: 768px) {
        .container {
            padding: 16px 16px 60px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            margin: 40px 0 24px;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-actions {
            flex-direction: column-reverse;
            gap: 8px;
        }

        .btn {
            width: 100%;
        }
    }

    * {
        transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    }
</style>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">Edit Alamat</h1>
            <p class="page-subtitle">Perbarui detail alamat pengiriman Anda</p>
        </div>
    </div>

    @if($address->user->phone)
    <div class="alert alert-info">
        <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
        </svg>
        <div>
            Alamat ini akan menggunakan nomor telepon dari profil Anda: <span class="phone-highlight">{{ $address->user->phone }}</span>
        </div>
    </div>
    @else
    <div class="alert alert-warning">
        <svg class="alert-icon" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        <div>
            Harap <a href="{{ route('profil') }}" class="alert-link">lengkapi nomor telepon</a> di profil terlebih dahulu
        </div>
    </div>
    @endif

    <div class="form-container">
        <form method="POST" action="{{ route('address.update', $address) }}" id="addressForm">
            @csrf
            @method('PUT')

            <input type="hidden" name="district_id" id="districtIdInput" value="{{ old('district_id', $address->district_id) }}">
            <input type="hidden" name="district_name" id="districtNameInput" value="{{ old('district_name', $address->district_name) }}">

            <div class="form-grid">
                <div class="form-group">
                    <label for="label" class="form-label">
                        Label Alamat <span class="optional">(opsional)</span>
                    </label>
                    <input type="text"
                        name="label"
                        id="label"
                        value="{{ old('label', $address->label) }}"
                        placeholder="Rumah, Kantor, Kos..."
                        class="form-input">
                    @error('label')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="recipient_name" class="form-label">
                        Nama Penerima <span class="required">*</span>
                    </label>
                    <input type="text"
                        name="recipient_name"
                        id="recipient_name"
                        value="{{ old('recipient_name', $address->recipient_name) }}"
                        required
                        class="form-input">
                    @error('recipient_name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="address" class="form-label">
                    Alamat Lengkap <span class="required">*</span>
                </label>
                <textarea name="address"
                    id="address"
                    required
                    placeholder="Jalan, RT/RW, Kelurahan..."
                    class="form-textarea">{{ old('address', $address->address) }}</textarea>
                @error('address')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="province" class="form-label">
                        Provinsi <span class="required">*</span>
                    </label>
                    <select name="province_id" id="provinceSelect" class="form-select" required>
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <input type="hidden" name="province" id="provinceName" value="{{ old('province', $address->province) }}">
                    @error('province')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="city" class="form-label">
                        Kota/Kabupaten <span class="required">*</span>
                    </label>
                    <select name="city_id" id="citySelect" class="form-select" required disabled>
                        <option value="">Pilih Kota/Kabupaten</option>
                    </select>
                    <input type="hidden" name="city" id="cityName" value="{{ old('city', $address->city) }}">
                    @error('city')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label for="district" class="form-label">
                        Kecamatan <span class="required">*</span>
                    </label>
                    <select name="district_select" id="districtSelect" class="form-select" required disabled>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    @error('district_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="postal_code" class="form-label">
                        Kode Pos <span class="required">*</span>
                    </label>
                    <input type="text"
                        name="postal_code"
                        id="postal_code"
                        value="{{ old('postal_code', $address->postal_code) }}"
                        required
                        maxlength="10"
                        class="form-input">
                    @error('postal_code')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="notes" class="form-label">
                    Catatan <span class="optional">(opsional)</span>
                </label>
                <textarea name="notes"
                    id="notes"
                    placeholder="Patokan atau petunjuk tambahan untuk kurir..."
                    class="form-textarea">{{ old('notes', $address->notes) }}</textarea>
                @error('notes')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="checkbox-group">
                <div class="checkbox-wrapper">
                    <input type="checkbox"
                        name="is_default"
                        id="is_default"
                        value="1"
                        {{ old('is_default', $address->is_default) ? 'checked' : '' }}
                        class="form-checkbox">
                    <label for="is_default" class="checkbox-label">
                        Jadikan sebagai alamat utama
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('address.index') }}" class="btn btn-cancel">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    Perbarui Alamat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const existingProvince = "{{ $address->province }}";
    const existingCity = "{{ $address->city }}";
    const existingDistrictId = "{{ $address->district_id }}";
    const existingDistrictName = "{{ $address->district_name }}";

    loadProvinces(existingProvince, existingCity, existingDistrictId, existingDistrictName);
});

function loadProvinces(selectProvince = null, selectCity = null, selectDistrict = null, districtName = null) {
    fetch('/api/rajaongkir/provinces')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('provinceSelect');
                data.data.forEach(province => {
                    const option = new Option(province.province, province.province_id);
                    option.setAttribute('data-name', province.province);
                    if (selectProvince && province.province === selectProvince) {
                        option.selected = true;
                    }
                    select.add(option);
                });
                
                if (selectProvince) {
                    const selectedOption = select.options[select.selectedIndex];
                    const provinceId = selectedOption.value;
                    document.getElementById('provinceName').value = selectProvince;
                    loadCities(provinceId, selectCity, selectDistrict, districtName);
                }
            }
        })
        .catch(error => console.error('Failed to load provinces:', error));
}

function loadCities(provinceId, selectCity = null, selectDistrict = null, districtName = null) {
    const citySelect = document.getElementById('citySelect');
    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
    citySelect.disabled = true;
    
    fetch(`/api/rajaongkir/cities/${provinceId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                citySelect.disabled = false;
                data.data.forEach(city => {
                    const option = new Option(city.city_name, city.city_id);
                    option.setAttribute('data-name', city.city_name);
                    if (selectCity && city.city_name === selectCity) {
                        option.selected = true;
                    }
                    citySelect.add(option);
                });
                
                if (selectCity) {
                    const selectedOption = citySelect.options[citySelect.selectedIndex];
                    const cityId = selectedOption.value;
                    document.getElementById('cityName').value = selectCity;
                    loadDistricts(cityId, selectDistrict, districtName);
                }
            }
        })
        .catch(error => console.error('Failed to load cities:', error));
}

function loadDistricts(cityId, selectDistrict = null, districtName = null) {
    const districtSelect = document.getElementById('districtSelect');
    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
    districtSelect.disabled = true;
    
    fetch(`/api/rajaongkir/districts/${cityId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                districtSelect.disabled = false;
                data.data.forEach(district => {
                    const option = new Option(district.subdistrict_name, district.subdistrict_id);
                    option.setAttribute('data-name', district.subdistrict_name);
                    if (selectDistrict && district.subdistrict_id == selectDistrict) {
                        option.selected = true;
                    }
                    districtSelect.add(option);
                });
                
                if (selectDistrict) {
                    document.getElementById('districtIdInput').value = selectDistrict;
                    document.getElementById('districtNameInput').value = districtName;
                }
            }
        })
        .catch(error => console.error('Failed to load districts:', error));
}

document.getElementById('provinceSelect').addEventListener('change', function() {
    const provinceId = this.value;
    const provinceName = this.options[this.selectedIndex].getAttribute('data-name');
    document.getElementById('provinceName').value = provinceName;
    
    document.getElementById('citySelect').innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
    document.getElementById('citySelect').disabled = !provinceId;
    document.getElementById('districtSelect').innerHTML = '<option value="">Pilih Kecamatan</option>';
    document.getElementById('districtSelect').disabled = true;
    document.getElementById('districtIdInput').value = '';
    document.getElementById('districtNameInput').value = '';
    
    if (provinceId) {
        loadCities(provinceId);
    }
});

document.getElementById('citySelect').addEventListener('change', function() {
    const cityId = this.value;
    const cityName = this.options[this.selectedIndex].getAttribute('data-name');
    document.getElementById('cityName').value = cityName;
    
    document.getElementById('districtSelect').innerHTML = '<option value="">Pilih Kecamatan</option>';
    document.getElementById('districtSelect').disabled = !cityId;
    document.getElementById('districtIdInput').value = '';
    document.getElementById('districtNameInput').value = '';
    
    if (cityId) {
        loadDistricts(cityId);
    }
});

document.getElementById('districtSelect').addEventListener('change', function() {
    const districtId = this.value;
    const districtName = this.options[this.selectedIndex].getAttribute('data-name');
    document.getElementById('districtIdInput').value = districtId;
    document.getElementById('districtNameInput').value = districtName;
});
</script>
@endsection