<x-admin-layout>
    {{-- CSS Khusus untuk Tampilan Tabel --}}
    <style>
        .card-table {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* Bayangan */
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
            color: #4f46e5; 
            margin-right: 1rem;
            font-weight: 500;
            transition: color 0.15s;
        }
        .action-link:hover {
            color: #3730a3;
        }
        .delete-btn {
            color: #dc2626;
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
        /* Style untuk tombol Tambah Baru */
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
    </style>
    
    <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem;">Kelola Data Waspang</h1>

        {{-- Tempatkan notifikasi di sini --}}

        <!-- Tombol Tambah Pangwas (Menggunakan CSS Murni) -->
        <div style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
            <a href="{{ route('admin.pangwas.create') }}" class="btn-add">
                <i class="fa-solid fa-plus" style="margin-right: 0.5rem;"></i> Tambah Waspang Baru
            </a>
        </div>

        <!-- Tabel Data Pangwas -->
        <div class="card-table">
            <table class="table-data">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Waspang</th>
                        <th>Dibuat Pada</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pangwas_list as $pangwas)
                        <tr>
                            <td>
                                {{ $pangwas_list->firstItem() + $loop->index }} 
                            </td>
                            <td style="font-weight: 500; color: #1f2937;">
                                {{ $pangwas->nama_pangwas }}
                            </td>
                            <td style="color: #6b7280;">
                                {{ $pangwas->created_at ? $pangwas->created_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td style="text-align: center;">
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.pangwas.edit', $pangwas->id) }}" class="action-link">
                                    <i class="fa-solid fa-edit" style="margin-right: 4px;"></i> Edit
                                </a>

                                <!-- Tombol Hapus (Form DELETE) -->
                                <form action="{{ route('admin.pangwas.destroy', $pangwas->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('APAKAH ANDA YAKIN INGIN MENGHAPUS DATA PANGWAS INI?');">
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
                                Data Pangwas masih kosong. Silakan tambahkan Waspang baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if ($pangwas_list->hasPages())
            <div style="margin-top: 1.5rem; text-align: center;">
                {{ $pangwas_list->links() }}
            </div>
        @endif

    </div>
</x-admin-layout>
