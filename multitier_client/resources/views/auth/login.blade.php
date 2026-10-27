<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · SiAkad-003</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1E88E5;
            --primary-hover: #1565C0;
            --primary-light: #E3F2FD;
            --bg-color: #ECEFF1;
            --card-bg: #FFFFFF;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --border-color: #CFD8DC;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--text-dark);
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background-color: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .card-header {
            background-color: var(--primary-color);
            padding: 22px 24px;
            text-align: center;
        }

        .card-header h2 {
            color: #FFFFFF;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .card-body {
            padding: 32px 30px 36px 30px;
        }

        .alert-error {
            background-color: #FEE2E2;
            border: 1px solid #FCA5A5;
            color: #DC2626;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #DCFCE7;
            border: 1px solid #86EFAC;
            color: #16A34A;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            font-size: 0.925rem;
            color: var(--text-dark);
            background-color: #FFFFFF;
            border: 1.5px solid #CBD5E1;
            border-radius: 8px;
            outline: none;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 136, 229, 0.18);
        }

        .btn-submit {
            width: 100%;
            background-color: var(--primary-color);
            color: #FFFFFF;
            padding: 12px 16px;
            font-size: 0.95rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.2s ease, transform 0.1s ease;
            box-shadow: 0 2px 4px rgba(30, 136, 229, 0.2);
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

        .btn-submit:active {
            transform: scale(0.99);
        }

        .hint {
            font-size: 0.775rem;
            color: var(--text-muted);
            margin-top: 14px;
            text-align: center;
        }

        /* Quick Login Buttons */
        .quick-login {
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid #E2E8F0;
        }

        .quick-login-title {
            font-size: 0.775rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            text-align: center;
        }

        .quick-btn {
            display: block;
            width: 100%;
            padding: 10px 14px;
            margin-bottom: 8px;
            border-radius: 8px;
            border: 1.5px solid #E2E8F0;
            background: #F8FAFC;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
            text-align: left;
        }

        .quick-btn:hover {
            border-color: var(--primary-color);
            background: var(--primary-light);
        }

        .quick-btn .role-badge {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 4px;
            margin-right: 6px;
        }

        .quick-btn .role-admin { background: #DBEAFE; color: #1D4ED8; }
        .quick-btn .role-dosen { background: #EDE9FE; color: #7C3AED; }
        .quick-btn .role-mahasiswa { background: #D1FAE5; color: #059669; }

        .quick-btn .quick-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .quick-btn .quick-detail {
            font-size: 0.75rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="card-header">
            <h2>Login SiAkad-003</h2>
        </div>

        <div class="card-body">
            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form id="loginForm" action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Username / NIM / Email</label>
                    <input 
                        type="text" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="username"
                        placeholder="Masukkan NIM / Email / Username"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="Masukkan password"
                    >
                </div>

                <button type="submit" class="btn-submit">Masuk</button>
            </form>

            <!-- Quick Login Buttons -->
            <div class="quick-login">
                <div class="quick-login-title">Login Cepat (Demo)</div>

                <button type="button" class="quick-btn" onclick="quickLogin('25.K1.0003', 'password')">
                    <span class="role-badge role-admin">Admin</span>
                    <span class="quick-name">Dustin Christian Basuki</span><br>
                    <span class="quick-detail">NIM: 25.K1.0003 · Pass: password</span>
                </button>

                <button type="button" class="quick-btn" onclick="quickLogin('dosen', 'password')">
                    <span class="role-badge role-dosen">Dosen</span>
                    <span class="quick-name">Dr. Budi Santoso, M.Kom</span><br>
                    <span class="quick-detail">Username: dosen · Pass: password</span>
                </button>

                <button type="button" class="quick-btn" onclick="quickLogin('25.K1.0045', 'password')">
                    <span class="role-badge role-mahasiswa">Mahasiswa</span>
                    <span class="quick-name">Parlindungan Sinaga</span><br>
                    <span class="quick-detail">NIM: 25.K1.0045 · Pass: password</span>
                </button>
            </div>

            <p class="hint">UTS PemWeb 2026 · Dustin Christian Basuki — 25.K1.0003</p>
        </div>
    </div>

    <script>
        function quickLogin(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.getElementById('loginForm').submit();
        }
    </script>

</body>
</html>