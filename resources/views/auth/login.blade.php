<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PT Telkom Akses</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        * {margin: 0; padding: 0; box-sizing: border-box;}
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            /* **CATATAN:** Hapus background color dari sini, karena sudah dipindah ke body tag */
        }
        .login-container {
            background: rgba(255,255,255,0.15); 
            border-radius: 22px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            backdrop-filter: blur(12px); 
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            animation: fadeIn 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.3); 
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 90px;
            filter: drop-shadow(0 0 5px rgba(0,0,0,0.2)); 
        }
        h2 {
            text-align: center;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: #fff; 
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #f9fafb; 
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: rgba(255,255,255,0.95); 
            font-size: 0.95rem;
            outline: none;
            color: #333; 
            transition: box-shadow 0.3s;
        }
        .form-group input:focus {
            box-shadow: 0 0 0 3px #E4002B; 
            background: #fff;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 35px;
            background: linear-gradient(90deg, #E4002B, #ff3344, #ff6673);
            color: #fff;
            font-size: 1rem;
            font-weight: 700; 
            cursor: pointer;
            transition: 0.35s ease;
            box-shadow: 0 8px 20px rgba(228,0,43,0.5); 
            display: flex;
            align-items: center;
            justify-content: center;
            letter-spacing: 1px;
        }
        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 28px rgba(228,0,43,0.7);
        }
        .btn-login i {
            margin-right: 8px;
        }
        .note {
            margin-top: 18px;
            font-size: 0.85rem;
            text-align: center;
            color: #f1f5f9;
        }
        .alert {
            background: #E4002B; 
            color: #fff;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 18px;
            font-size: 0.9rem;
            font-weight: 500;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body style="
    /* Solusi 1: Menggunakan fungsi asset() */
    background-image: url('{{ asset('images/homepage.jpg') }}'); 
    
    /* Solusi 2: JALUR RELATIF LANGSUNG (Pastikan file ada di public/images/) */
    background-image: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.8)), url('/images/homepage.jpg'); 
    
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat;
    
    /* Fallback dan Style Body Dasar */
    background-color: #34495e; /* Warna solid jika gambar gagal */
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
">
    <div class="login-container">
        <img src="{{ asset('images/logo-kanan.png') }}" alt="Logo Telkom Akses" class="logo">
        
        <h2>PORTAL LOGIN</h2>

        {{-- Pesan Error Validasi dari Laravel --}}
        @error('username')
            <div class="alert">
                {{ $message }}
            </div>
        @enderror

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" value="{{ old('username') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            </button><button type="submit" class="btn-login">🚀Login</button>
        </form>
        <p class="note">© {{ date('Y') }} PT Telkom Akses Banjarmasin</p>
    </div>
</body>
</html>