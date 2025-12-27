<x-admin-layout>
    {{-- Ganti 'x-admin-layout' jika nama komponen layout Anda berbeda --}}
    
    <style>
        /* CSS KHUSUS UNTUK TAMPILAN TABEL (CSS MURNI) */
        .card-table { 
            background-color: #ffffff; 
            border-radius: 8px; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* Bayangan modern */
            overflow-x: auto; 
            border: 1px solid #e5e7eb; 
        }
        .table-data { 
            width: 100%; 
            border-collapse: collapse; 
            line-height: 1.5; 
        }
        .table-data thead tr { 
            background-color: #f9fafb; 
            border-bottom: 2px solid #e5e7eb; 
        }
        .table-data th { 
            padding: 12px 20px; 
            text-align: left; 
            font-size: 0.75rem; 
            font-weight: 600; 
            color: #4b5563; 
            text-transform: uppercase; 
            letter-spacing: 0.05em; 
        }
        .table-data td { 
            padding: 16px 20px; 
            border-bottom: 1px solid #e5e7eb; 
            font-size: 0.875rem; 
            color: #374151; 
        }
        .table-data tbody tr:hover { 
            background-color: #f3f4f6; 
        }
        .action-link { 
            text-decoration: none; 
            color: #4f46e5; /* Warna Edit */
            margin-right: 1rem; 
            font-weight: 500; 
            transition: color 0.15s; 
        }
        .action-link:hover { 
            color: #3730a3; 
        }
        .delete-btn { 
            color: #dc2626; /* Warna Hapus */
            font-weight: 500; 
            cursor: pointer; 
            border: none; 
            background: none; 
            padding: 0; 
            transition: color 0.15s; 
        }
        .delete-btn:hover { 
            color: #b91c1c; 
        }
        .btn-add { 
            background-color: #dc2626; 
            color: white; 
            font-weight: 600; 
            padding: 8px 16px; 
            border-radius: 8px; 
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1); 
            text-decoration: none; 
            display: flex; 
            align-items: center; 
            transition: background-color 0.2s; 
        }
        .btn-add:hover { 
            background-color: #b91c1c; 
        }
        .alert-box { 
            background-color: #d1fae5; 
            border-left: 4px solid #10b981; 
            color: #065f46; 
            padding: 1rem; 
            margin-bottom: 1.5rem; 
        }
        .alert-error {
             background-color: #fee2e2; border-left: 4px solid #ef4444; color: #b91c1c; padding: 1rem; margin-bottom: 1.5rem;
        }
    </style>
    
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">Kelola Data Tematik</h1>

        @if (session('success'))
            <div class="alert-box" role="alert">
                <p style="font-weight: 700;">Berhasil! 🎉</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="alert-error" role="alert">
                <p style="font-weight: 700;">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
            <a href="{{ route('admin.tematik.create') }}" class="btn-add">
                <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i> Tambah Tematik Baru
            </a>
        </div>

        <div class="card-table">
            <table class="table-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tematik</th>
                        <th>Dibuat Pada</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tematik_list as $tematik)
                        <tr>
                            <td>
                                {{ $tematik_list->firstItem() + $loop->index }} 
                            </td>
                            <td style="font-weight: 500; color: #1f2937;">
                                {{ $tematik->nama_tematik }}
                            </td>
                            <td style="color: #6b7280;">
                                {{ $tematik->created_at ? $tematik->created_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.tematik.edit', $tematik->id) }}" class="action-link">
                                    <i class="fa-solid fa-edit" style="margin-right: 4px;"></i> Edit
                                </a>

                                <form action="{{ route('admin.tematik.destroy', $tematik->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('APAKAH ANDA YAKIN INGIN MENGHAPUS DATA TEMATIK INI?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">
                                        <i class="fa-solid fa-trash-alt" style="margin-right: 4px;"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 40px; color: #6b7280;">
                                Data Tematik masih kosong. Silakan tambahkan Tematik baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if ($tematik_list->hasPages())
            <div style="margin-top: 1.5rem; text-align: center;">
                {{ $tematik_list->links() }}
            </div>
        @endif

    </div>
</x-admin-layout>