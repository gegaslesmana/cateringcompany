<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PT. CRAZE INDONESIA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary-green: #1a5928;
            --dark-bg: #f4f7f6;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--dark-bg);
            background-image: radial-gradient(#1a592815 1px, transparent 1px);
            background-size: 20px 20px;
            overflow: hidden; /* Mencegah scroll saat loading */
        }

        /* Loading Overlay */
        .loader-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .spinner-modern {
            width: 60px;
            height: 60px;
            border: 6px solid #f3f3f3;
            border-top: 6px solid var(--primary-green);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        .loading-text {
            margin-top: 20px;
            font-weight: 800;
            color: var(--primary-green);
            letter-spacing: 2px;
            font-size: 0.75rem;
        }

        .main-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
        }

        .login-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: var(--primary-green);
        }

        .card-header { padding: 50px 40px 20px; text-align: center; }

        .logo-wrapper {
            width: 80px; height: 80px;
            background: white;
            margin: 0 auto 20px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .logo-wrapper img { height: 50px; width: auto; }

        .title { font-weight: 800; color: #1e293b; margin: 0; font-size: 1.25rem; letter-spacing: -0.5px; }
        .subtitle { font-size: 0.75rem; font-weight: 700; color: var(--primary-green); text-transform: uppercase; letter-spacing: 2px; margin-top: 5px; }

        .card-body { padding: 20px 40px 40px; }
        .form-group { margin-bottom: 20px; position: relative; }
        .form-label { display: block; font-size: 0.7rem; font-weight: 700; color: #64748b; margin-bottom: 8px; margin-left: 4px; }

        .input-group-custom { position: relative; display: flex; align-items: center; }
        .input-group-custom i.main-icon { position: absolute; left: 16px; color: #94a3b8; font-size: 1.1rem; }
        .input-group-custom input {
            width: 100%; padding: 14px 16px 14px 48px;
            border: 2px solid #f1f5f9; border-radius: 14px;
            font-size: 0.95rem; background: #f8fafc; transition: all 0.3s ease;
        }

        .input-group-custom input:focus {
            outline: none; border-color: var(--primary-green);
            background: white; box-shadow: 0 0 0 4px rgba(26, 89, 40, 0.1);
        }

        /* Password Toggle */
        .toggle-password {
            position: absolute; right: 16px; cursor: pointer; color: #94a3b8; transition: 0.3s;
        }
        .toggle-password:hover { color: var(--primary-green); }

        .btn-submit {
            width: 100%; background: var(--primary-green); color: white; border: none;
            padding: 16px; border-radius: 14px; font-weight: 700; font-size: 0.9rem;
            cursor: pointer; transition: all 0.3s ease; margin-top: 10px;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }

        .btn-submit:hover {
            background: #14461f; transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 89, 40, 0.2);
        }

        .footer-text { text-align: center; margin-top: 30px; font-size: 0.75rem; color: #94a3b8; }
        .error-msg { color: #dc3545; font-size: 0.75rem; margin-top: 5px; list-style: none; padding: 0; font-weight: 600; }
        /* Custom Styling agar SweetAlert matching dengan tema hijau */
    .swal2-styled.swal2-confirm {
        background-color: var(--primary-green) !important;
        border-radius: 12px !important;
        padding: 12px 30px !important;
    }
    .swal2-popup {
        border-radius: 24px !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }
    </style>
</head>
<body>

    <div id="loader" class="loader-overlay">
        <div class="spinner-modern"></div>
        <p class="loading-text animate__animated animate__pulse animate__infinite">AUTHENTICATING...</p>
    </div>

    <div class="main-wrapper">
        <div class="login-card animate__animated animate__zoomIn">
            <div class="card-header">
                <div class="logo-wrapper animate__animated animate__pulse animate__infinite">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo">
                </div>
                <h1 class="title">PT. CRAZE INDONESIA</h1>
                <p class="subtitle">E-Catering System Management</p>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">EMAIL ADDRESS</label>
                        <div class="input-group-custom">
                            <i class="bi bi-envelope-at main-icon"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan email kerja...">
                        </div>
                        @if($errors->has('email'))
                            <ul class="error-msg">
                                @foreach($errors->get('email') as $message) <li><i class="bi bi-exclamation-circle"></i> {{ $message }}</li> @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label">PASSWORD</label>
                        <div class="input-group-custom">
                            <i class="bi bi-lock main-icon"></i>
                            <input type="password" name="password" id="passwordInput" required placeholder="••••••••">
                            <i class="bi bi-eye toggle-password" id="toggleIcon"></i>
                        </div>
                        @if($errors->has('password'))
                            <ul class="error-msg">
                                @foreach($errors->get('password') as $message) <li><i class="bi bi-exclamation-circle"></i> {{ $message }}</li> @endforeach
                            </ul>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span id="btnText">LOG IN TO SYSTEM</span> <i class="bi bi-arrow-right-circle" id="btnIcon"></i>
                    </button>
                </form>

                <div class="footer-text">
                    &copy; 2026 PT. CRAZE INDONESIA. All rights reserved.
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    const loginForm = document.getElementById('loginForm');
    const loader = document.getElementById('loader');
    const passwordInput = document.getElementById('passwordInput');
    const toggleIcon = document.getElementById('toggleIcon');

    // Toggle Password Visibility
    toggleIcon.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });

    // Handle Form Submit Animation
    loginForm.addEventListener('submit', function() {
        loader.style.display = 'flex';
    });

    // --- LOGIKA PESAN ERROR CUSTOM ---
    @if(session('error_type') == 'username_wrong')
        Swal.fire({
            icon: 'error',
            title: 'Akses Ditolak',
            text: 'Maaf, username anda salah. Silahkan periksa kembali email kerja anda.',
            confirmButtonText: 'Coba Lagi'
        });
    @endif

    @if(session('error_type') == 'password_wrong')
        Swal.fire({
            icon: 'warning',
            title: 'Password Salah',
            html: 'Maaf, password anda salah.<br><br><b>Silahkan hubungi tim IT untuk reset password.</b>',
            confirmButtonText: 'Mengerti',
            footer: '<a href="https://wa.me/62812345678" target="_blank">Hubungi IT Support (WhatsApp)</a>'
        });
    @endif
</script>

</body>
</html>