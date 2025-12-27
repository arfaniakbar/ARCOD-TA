<x-admin-layout>
    {{-- Ganti 'x-admin-layout' jika nama komponen layout Anda berbeda --}}

    <style>
        .form-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* shadow-xl */
            padding: 40px;
            max-width: 500px; /* max-w-lg */
            margin-left: auto;
            margin-right: auto;
        }
        .error-alert {
            background-color: #fee2e2; /* red-100 */
            border: 1px solid #f87171; /* red-400 */
            color: #b91c1c; /* red-700 */
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            color: #374151; /* gray-700 */
            font-size: 0.875rem; /* text-sm */
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db; /* border-gray-300 */
            border-radius: 0.375rem; /* rounded-lg */
            font-size: 1rem;
            color: #374151;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-input:focus {
            outline: none;
            border-color: #dc2626; /* red-600 */
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.5); /* focus:ring-2 focus:ring-red-500 */
        }
        .error-text {
            color: #dc2626; /* red-600 */
            font-size: 0.75rem; /* text-xs */
            font-style: italic;
            margin-top: 0.25rem;
        }
        .btn-submit {
            background-color: #dc2626; /* red-600 */
            color: white;
            font-weight: 700;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
        }
        .btn-submit:hover {
            background-color: #b91c1c; /* hover:bg-red-700 */
        }
        .btn-cancel {
            display: inline-block;
            font-weight: 700;
            font-size: 0.875rem;
            color: #6b7280; /* gray-500 */
            text-decoration: none;
            transition: color 0.2s;
        }
        .btn-cancel:hover {
            color: #1f2937; /* gray-800 */
        }
    </style>
    
    <div class="container" style="max-width: 900px; margin: 0 auto; padding: 20px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">Tambah Pangwas Baru</h1>

        @if ($errors->any())
            <div class="error-alert">
                <strong style="font-weight: 700; display: block; margin-bottom: 4px;">Gagal Menyimpan Data!</strong>
                <span style="display: block; font-size: 0.875rem;">Mohon periksa kembali input Anda:</span>
                <ul style="margin-top: 0.5rem; list-style-type: disc; margin-left: 20px; font-size: 0.875rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form action="{{ route('admin.pangwas.store') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="nama_pangwas" class="form-label">Nama Pangwas:</label>
                    <input type="text" 
                           name="nama_pangwas" 
                           id="nama_pangwas" 
                           value="{{ old('nama_pangwas') }}"
                           class="form-input" 
                           style="{{ $errors->has('nama_pangwas') ? 'border-color: #dc2626;' : '' }}"
                           required 
                           autofocus>
                    @error('nama_pangwas')
                        <p class="error-text">{{ $message }}</p>
                    @enderror
                </div>
                
                <div style="display: flex; align-items: center; justify-content: flex-end; border-top: 1px solid #e5e7eb; padding-top: 1.5rem; margin-top: 1.5rem;">
                    <a href="{{ route('admin.pangwas.index') }}" 
                       class="btn-cancel" style="margin-right: 1rem;">
                        Batal
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fa-solid fa-save" style="margin-right: 0.5rem;"></i> Simpan Pangwas
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>