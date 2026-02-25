<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | PT. CRAZE INDONESIA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        :root {
            --primary-green: #1a5928;
            --dark-bg: #f4f7f6;
        }

        body, html {
            margin: 0; padding: 0;
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--dark-bg);
            background-image: radial-gradient(#1a592815 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .main-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .register-card {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
        }

        .register-card::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: var(--primary-green);
        }

        .card-header {
            padding: 40px 40px 10px;
            text-align: center;
        }

        .logo-wrapper {
            width: 60px; height: 60px;
            background: white;
            margin: 0 auto 15px;
            display: flex;
            align-items: center; justify-content: center;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.05);
        }

        .logo-wrapper img { height: 35px; }

        .title { font-weight: 800; color: #1e293b; margin: 0; font-size: 1.2rem; }
        .subtitle { font-size: 0.7rem; font-weight: 700; color: var(--primary-green); text-transform: uppercase; letter-spacing: 1.5px; }

        .card-body { padding: 30px 40px 40px; }

        .form-label {
            display: block;
            font-size: 0.65rem;
            font-weight: 800;
            color: #64748b;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 18px;
        }

        .input-group-custom i {
            position: absolute;
            left: 16px; top: 13px;
            color: #94a3b8;
            font-size: 1rem;
            z-index: 10;
        }

        .input-group-custom input, .input-group-custom select {
            width: 100%;
            padding: 12px 16px 12px 48px;
            border: 2px solid #f1f5f9;
            border-radius: 12px;
            font-size: 0.9rem;
            background: #f8fafc;
            transition: all 0.3s ease;
            box-sizing: border-box;
            color: #1e293b;
        }

        .input-group-custom select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2364748b' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 12px;
        }

        .input-group-custom input:focus, .input-group-custom select:focus {
            outline: none;
            border-color: var(--primary-green);
            background: white;
            box-shadow: 0 0 0 4px rgba(26, 89, 40, 0.1);
        }

        .grid-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-register {
            width: 100%;
            background: var(--primary-green);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            display: flex;
            align-items: center; justify-content: center;
            gap: 10px;
        }

        .btn-register:hover {
            background: #14461f;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 89, 40, 0.2);
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 0.8rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link span { color: var(--primary-green); font-weight: 800; }

        .error-text { color: #ef4444; font-size: 0.7rem; margin-top: -12px; margin-bottom: 12px; display: block; font-weight: 600; list-style: none; padding: 0; }
    </style>
</head>
<body>

    <div class="main-wrapper">
        <div class="register-card animate__animated animate__fadeInDown">
            <div class="card-header">
                <div class="logo-wrapper animate__animated animate__pulse animate__infinite">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo">
                </div>
                <h1 class="title">CREATE ACCOUNT</h1>
                <p class="subtitle">Join PT. Craze Indonesia System</p>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <label class="form-label">Full Name</label>
                    <div class="input-group-custom">
                        <i class="bi bi-person"></i>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama Lengkap">
                    </div>
                    @error('name') <span class="error-text">{{ $message }}</span> @enderror

                    <label class="form-label">Email Address</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope-at"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@company.com">
                    </div>
                    @error('email') <span class="error-text">{{ $message }}</span> @enderror

                    <div class="grid-inputs">
                        <div>
                            <label class="form-label">Assign Role</label>
                            <div class="input-group-custom">
                                <i class="bi bi-shield-lock"></i>
                                <select name="role" required>
                                    <option value="" disabled selected>Role...</option>
                                    <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                                    <option value="hrd" {{ old('role') == 'hrd' ? 'selected' : '' }}>HRD</option>
                                    <option value="security" {{ old('role') == 'security' ? 'selected' : '' }}>Security</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Department</label>
                            <div class="input-group-custom">
                                <i class="bi bi-building"></i>
                                <select name="division_id" required>
                                    <option value="" disabled selected>Pilih Unit...</option>
                                    @foreach($divisions as $div)
                                        <option value="{{ $div->id }}" {{ old('division_id') == $div->id ? 'selected' : '' }}>
                                            {{ $div->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @error('role') <span class="error-text">{{ $message }}</span> @enderror
                    @error('division_id') <span class="error-text">{{ $message }}</span> @enderror

                    <div class="grid-inputs">
                        <div>
                            <label class="form-label">Password</label>
                            <div class="input-group-custom">
                                <i class="bi bi-key"></i>
                                <input type="password" name="password" required placeholder="••••••••">
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Confirm</label>
                            <div class="input-group-custom">
                                <i class="bi bi-check2-circle"></i>
                                <input type="password" name="password_confirmation" required placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                    @error('password') <span class="error-text">{{ $message }}</span> @enderror

                    <button type="submit" class="btn-register">
                        REGISTER ACCOUNT <i class="bi bi-person-plus-fill"></i>
                    </button>

                    <a href="{{ route('login') }}" class="login-link">
                        Already have an account? <span>Sign In Here</span>
                    </a>
                </form>
            </div>
        </div>
    </div>

</body>
</html>