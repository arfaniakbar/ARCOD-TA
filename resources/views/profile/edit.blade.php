@php
    $layout = auth()->user()->role === 'karyawan' 
        ? 'karyawan-layout' 
        : 'admin-layout';
@endphp

<x-dynamic-component :component="$layout">

    <style>
        .container-wrapper { 
            max-width: 1400px;
            width: 95%;
            margin: 0 auto; 
            padding: 20px; 
        } 
        .page-title { font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; }

        .card-container { display: flex; gap: 20px; }
        .card { flex: 1; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); padding: 30px; }
        .card-title { font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 10px; }
        
        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; font-weight: 500; color: #374151; margin-bottom: 0.25rem; }
        .form-input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; transition: border-color 0.2s; }
        .form-input:focus { border-color: #dc2626; outline: none; box-shadow: 0 0 0 1px #dc2626; }
        .form-error { color: red; font-size: 0.8rem; margin-top: 4px; }
        
        .btn-submit { background-color: #dc2626; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.2s; margin-top: 1rem; }
        .btn-submit:hover { background-color: #b91c1c; }
        .alert-success { color: #065f46; background-color: #d1fae5; border: 1px solid #10b981; padding: 10px; border-radius: 4px; margin-bottom: 15px; }

        @media (max-width: 768px) {
            .card-container { flex-direction: column; }
        }
    </style>

    <div class="container-wrapper">
        <h1 class="page-title">
            <i class="fa-solid fa-user-circle" style="margin-right: 0.5rem; color: #dc2626;"></i> Kelola Profil Saya
        </h1>

        @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
            <div class="alert-success">
                @if (session('status') === 'profile-updated')
                    Profil berhasil diperbarui.
                @else
                    Kata sandi berhasil diperbarui.
                @endif
            </div>
        @endif

        <div class="card-container">
            
            <div class="card">
                <h2 class="card-title">Perbarui Informasi Dasar</h2>
                
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="form-group">
                        <label for="name" class="form-label">Nama</label>
                        <input id="name" name="name" type="text" value="{{ old('name', Auth::user()->name) }}" required autofocus class="form-input">
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input id="username" name="username" type="text" value="{{ old('username', Auth::user()->username) }}" required class="form-input">
                        @error('username') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" required class="form-input">
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        Simpan Perubahan Profil
                    </button>
                </form>
            </div>

            <div class="card">
                <h2 class="card-title">Perbarui Kata Sandi</h2>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="current_password" class="form-label">Kata Sandi Saat Ini</label>
                        <input id="current_password" name="current_password" type="password" class="form-input">
                        @error('current_password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi Baru</label>
                        <input id="password" name="password" type="password" class="form-input">
                        @error('password') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-input">
                        @error('password_confirmation') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        Ubah Kata Sandi
                    </button>
                </form>
            </div>
            
        </div>
    </div>

</x-dynamic-component>
