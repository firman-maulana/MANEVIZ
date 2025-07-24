@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .signup-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        position: relative;
        overflow: hidden;
    }

    .signup-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover;
        opacity: 0.1;
        z-index: -1;
    }

    .signup-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 1200px;
        width: 100%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 24px;
        box-shadow: 0 32px 64px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .signup-visual {
        background: linear-gradient(45deg, #2c3e50, #34495e);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 3rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .signup-visual::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .brand-logo {
        font-size: 3rem;
        font-weight: 900;
        letter-spacing: -2px;
        margin-bottom: 1rem;
        background: linear-gradient(45deg, #fff, #f8f9fa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        z-index: 1;
    }

    .brand-tagline {
        font-size: 1.2rem;
        opacity: 0.9;
        text-align: center;
        line-height: 1.6;
        margin-bottom: 2rem;
        position: relative;
        z-index: 1;
    }

    .fashion-icons {
        display: flex;
        gap: 1.5rem;
        opacity: 0.7;
        position: relative;
        z-index: 1;
    }

    .fashion-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .signup-form {
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-title {
        color: #2c3e50;
        font-weight: 800;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
        letter-spacing: -1px;
    }

    .form-subtitle {
        color: #64748b;
        font-size: 1rem;
        line-height: 1.5;
    }

    .form-grid {
        display: grid;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group {
        position: relative;
    }

    .form-label {
        display: block;
        color: #374151;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 1rem 1.2rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fafafa;
        font-family: inherit;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
    }

    .form-control::placeholder {
        color: #9ca3af;
        font-weight: 400;
    }

    .btn-signup {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 1rem 2rem;
        font-weight: 700;
        font-size: 1.1rem;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
    }

    .btn-signup::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-signup:hover::before {
        left: 100%;
    }

    .btn-signup:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(102, 126, 234, 0.3);
    }

    .btn-signup:active {
        transform: translateY(0);
    }

    .form-footer {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .login-link {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .login-link:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .alert-danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }

    .alert-danger ul {
        margin: 0;
        padding-left: 1rem;
    }

    .alert-danger li {
        margin-bottom: 0.25rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .signup-container {
            grid-template-columns: 1fr;
            max-width: 600px;
        }

        .signup-visual {
            order: -1;
            padding: 2rem;
        }

        .brand-logo {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .signup-wrapper {
            padding: 1rem;
        }

        .signup-form {
            padding: 2rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-title {
            font-size: 1.8rem;
        }

        .brand-logo {
            font-size: 2rem;
        }

        .brand-tagline {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .signup-form {
            padding: 1.5rem;
        }

        .form-title {
            font-size: 1.6rem;
        }
    }
</style>

<div class="signup-wrapper">
    <div class="signup-container">
        <!-- Visual Side -->
        <div class="signup-visual">
            <div class="brand-logo">MANEVIZ</div>
            <p class="brand-tagline">
                Bergabunglah dengan komunitas fashion terdepan.
                Temukan gaya terbaikmu dengan koleksi eksklusif kami.
            </p>
            <div class="fashion-icons">
                <div class="fashion-icon">👔</div>
                <div class="fashion-icon">👕</div>
                <div class="fashion-icon">🧥</div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="signup-form">
            <div class="form-header">
                <h2 class="form-title">Buat Akun Baru</h2>
                <p class="form-subtitle">Mulai perjalanan fashion Anda bersama kami</p>
            </div>

            {{-- Display validation errors --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('signUp') }}">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required
                            value="{{ old('name') }}" autofocus
                            placeholder="Masukkan nama lengkap Anda">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required
                            value="{{ old('email') }}"
                            placeholder="your.email@example.com">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="tel" name="phone" class="form-control"
                                value="{{ old('phone') }}"
                                placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="gender" class="form-select">
                                <option value="">Pilih Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control"
                            value="{{ old('birth_date') }}">
                    </div>

                    <div class="form-row">
                        <input type="password" name="password" required>
                        <input type="password" name="password_confirmation" required>

                    </div>
                </div>

                <button type="submit" class="btn-signup w-100">
                    Buat Akun Sekarang
                </button>

                <div class="form-footer">
                    <p class="text-muted">
                        Sudah memiliki akun?
                        <a href="{{ route('signIn') }}" class="login-link">Masuk di sini</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection