<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - MANEVIZ</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }
        .login-card {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
            border-radius: 10px;
            overflow: hidden;
            max-width: 960px;
            width: 100%;
        }
        .login-left {
            background-color: #0d6efd;
            color: #fff;
            padding: 40px 30px;
        }
        .login-left h5 {
            font-weight: bold;
        }
        .login-right {
            padding: 40px 30px;
        }
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }
        .divider::before,
        .divider::after {
            content: "";
            height: 1px;
            background: #dee2e6;
            position: absolute;
            top: 50%;
            width: 40%;
        }
        .divider::before {
            left: 0;
        }
        .divider::after {
            right: 0;
        }
        .divider span {
            padding: 0 10px;
            background: #fff;
            position: relative;
            z-index: 1;
            font-size: 14px;
            color: #6c757d;
        }
        .btn-login {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card row g-0">
            <!-- Left Side - Branding -->
            <div class="col-md-6 login-left d-flex flex-column justify-content-center text-center">
                <div>
                    <div class="mb-4">
                        <img src="{{ asset('storage/image/maneviz-white.png') }}" alt="MANEVIZ Logo" height="80">
                    </div>
                    <p class="mb-4">Platform fashion terpercaya dengan koleksi premium dan berkualitas tinggi</p>
                    <div class="mb-3">
                        <i class="bi bi-shield-check fs-2 mb-2"></i>
                        <h5>Aman & Terpercaya</h5>
                        <p class="mb-0">Transaksi Anda dijamin aman dengan sistem keamanan terdepan</p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="col-md-6 login-right">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-dark">Selamat Datang!</h2>
                    <p class="text-muted">Silakan masuk ke akun Anda</p>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('signIn') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="Masukkan email Anda"
                                   required autofocus>
                        </div>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="Masukkan password Anda"
                                   required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none">Lupa password?</a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider"><span>atau</span></div>

                <!-- Google Login Button -->
                <a href="{{ route('login.google') }}" class="btn btn-outline-danger w-100 mb-3 d-flex align-items-center justify-content-center">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo" width="20" class="me-2">
                    Masuk dengan Google
                </a>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="mb-0">Belum punya akun? 
                        <a href="{{ route('signUp') }}" class="fw-semibold text-decoration-none">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Password Script -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            const isPassword = password.type === 'password';
            password.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !isPassword);
            icon.classList.toggle('bi-eye-slash', isPassword);
        });
    </script>
</body>
</html>
