@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('address.index') }}" 
                   class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Alamat</h1>
                    <p class="text-gray-600 mt-1">Perbarui detail alamat pengiriman Anda</p>
                </div>
            </div>
        </div>

        <!-- Phone Number Info -->
        @if($address->user->phone)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-800">
                        Alamat ini menggunakan nomor telepon dari profil Anda: <strong>{{ $address->user->phone }}</strong>
                    </p>
                </div>
            </div>
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-800">
                        Nomor telepon belum diset di profil Anda. Silakan <a href="{{ route('profil') }}" class="underline font-medium">perbarui profil</a> terlebih dahulu.
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('address.update', $address) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Label -->
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                        Label Alamat <span class="text-gray-500">(Opsional)</span>
                    </label>
                    <input type="text" 
                           name="label" 
                           id="label"
                           value="{{ old('label', $address->label) }}"
                           placeholder="Contoh: Rumah, Kantor, Kos"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    @error('label')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recipient Name -->
                <div>
                    <label for="recipient_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Penerima <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="recipient_name" 
                           id="recipient_name"
                           value="{{ old('recipient_name', $address->recipient_name) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    @error('recipient_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="address" 
                              id="address"
                              required
                              rows="3"
                              placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-none">{{ old('address', $address->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City and Province -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            Kota/Kabupaten <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="city" 
                               id="city"
                               value="{{ old('city', $address->city) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                            Provinsi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="province" 
                               id="province"
                               value="{{ old('province', $address->province) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        @error('province')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Postal Code -->
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode Pos <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="postal_code" 
                           id="postal_code"
                           value="{{ old('postal_code', $address->postal_code) }}"
                           required
                           maxlength="10"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    @error('postal_code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan <span class="text-gray-500">(Opsional)</span>
                    </label>
                    <textarea name="notes" 
                              id="notes"
                              rows="2"
                              placeholder="Patokan atau petunjuk tambahan untuk kurir"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 resize-none">{{ old('notes', $address->notes) }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Default Address Checkbox -->
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="is_default" 
                           id="is_default"
                           value="1"
                           {{ old('is_default', $address->is_default) ? 'checked' : '' }}
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="is_default" class="ml-2 text-sm text-gray-700">
                        Jadikan sebagai alamat utama
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('address.index') }}" 
                       class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                        Perbarui Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection