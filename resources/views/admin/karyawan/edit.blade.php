<x-admin-layout>
    <style>
        .card { background-color: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .card-header { font-size: 1.25rem; font-weight: 600; color: #1f2937; border-bottom: 1px solid #e5e7eb; padding-bottom: 16px; margin-bottom: 24px; }
        .form-grid { display: grid; grid-template-columns: 1fr; gap: 24px; }
        @media (min-width: 768px) { .form-grid { grid-template-columns: repeat(2, 1fr); } }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #374151; }
        .form-group input { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); box-sizing: border-box; }
        .form-group input:focus { outline: 2px solid transparent; outline-offset: 2px; border-color: #ef4444; box-shadow: 0 0 0 2px #ef4444; }
        .col-span-2 { grid-column: span 2 / span 2; }
        .form-footer { margin-top: 24px; display: flex; justify-content: flex-end; gap: 12px; }
        .btn { display: inline-flex; align-items: center; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
        .btn-red { background-color: #dc2626; color: white; }
        .btn-red:hover { background-color: #b91c1c; }
        .btn-secondary { background-color: #e5e7eb; color: #1f2937; }
        .btn-secondary:hover { background-color: #d1d5db; }
        .error-text { color: #dc2626; font-size: 0.875rem; margin-top: 4px; }
    </style>
    
    <div class="card">
        <h2 class="card-header">Edit Data Karyawan</h2>
        <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $karyawan->name) }}" required>
                    @error('name') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $karyawan->username) }}" required>
                    @error('username') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-span-2">
                    <label for="email">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $karyawan->email) }}" required>
                    @error('email') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password Baru (Opsional)</label>
                    <input type="password" name="password" id="password">
                    @error('password') <span class="error-text">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                </div>
            </div>
            
            <div class="form-footer">
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-red">Update Karyawan</button>
            </div>
        </form>
    </div>
</x-admin-layout>