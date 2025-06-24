{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - SPK CPI PAUDQU</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #ededee 0%, #d2d8e0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .login-container {
            max-width: 380px;
            width: 100%;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            padding: 40px 32px;
            border: 1px solid #f1f5f9;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .logo-icon i {
            color: white;
            font-size: 20px;
        }

        .app-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 4px 0;
        }

        .app-subtitle {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            color: #1e293b;
            background: #fafafa;
            transition: all 0.2s ease;
            width: 100%;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-control::placeholder {
            color: #9ca3af;
            font-size: 13px;
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 14px;
        }

        .input-icon .form-control {
            padding-left: 44px;
        }

        .remember-section {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .form-check-input {
            margin-right: 8px;
            border: 1.5px solid #d1d5db;
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .form-check-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 400;
        }

        .btn-login {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 500;
            color: white;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 3px solid #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border-left: 3px solid #16a34a;
        }

        .demo-accounts {
            margin-top: 24px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .demo-title {
            font-size: 12px;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 12px;
            text-align: center;
        }

        .demo-item {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 12px;
        }

        .demo-item:hover {
            border-color: #3b82f6;
            background: #f8faff;
        }

        .demo-item:last-child {
            margin-bottom: 0;
        }

        .demo-role {
            font-weight: 500;
            color: #374151;
        }

        .demo-email {
            color: #6b7280;
            font-size: 11px;
        }

        .loading-spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        .btn-login.loading .loading-spinner {
            display: inline-block;
            margin: 0 auto;
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 11px;
            color: #9ca3af;
        }

        /* Mobile responsiveness */
        @media (max-width: 480px) {
            body {
                padding: 16px;
            }

            .login-card {
                padding: 32px 24px;
            }

            .login-container {
                max-width: 100%;
            }
        }

        /* Focus states for accessibility */
        .form-control:focus,
        .btn-login:focus,
        .form-check-input:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* Animation for form appearance */
        .login-card {
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1 class="app-title">SPK CPI</h1>
                <p class="app-subtitle">PAUDQU QURROTA A'YUN</p>
            </div>

            <!-- Error/Success Messages -->
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div><i class="fas fa-exclamation-triangle me-1"></i>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Masukkan email Anda" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Masukkan password Anda" required autocomplete="current-password">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="remember-section">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text">
                        <i class="fas fa-sign-in-alt me-1"></i>Masuk
                    </span>
                    <div class="loading-spinner"></div>
                </button>
            </form>


            <!-- Footer -->
            <div class="footer-text">
                Sistem Pendukung Keputusan CPI &copy; 2024
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Fill login form with demo credentials
        function fillLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;

            // Visual feedback
            const inputs = [document.getElementById('email'), document.getElementById('password')];
            inputs.forEach(input => {
                input.style.borderColor = '#10b981';
                setTimeout(() => {
                    input.style.borderColor = '#e2e8f0';
                }, 1000);
            });
        }

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;

            // Fallback to re-enable button
            setTimeout(() => {
                loginBtn.classList.remove('loading');
                loginBtn.disabled = false;
            }, 5000);
        });

        // Auto-hide alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => alert.remove(), 300);
            });
        }, 4000);

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.altKey && e.key === 'a') {
                e.preventDefault();
                fillLogin('admin@paudqu.com', 'admin123');
            } else if (e.altKey && e.key === 'g') {
                e.preventDefault();
                fillLogin('guru1@paudqu.com', 'guru123');
            }
        });
    </script>
</body>

</html>
