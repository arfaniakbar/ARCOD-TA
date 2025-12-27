<x-admin-layout>
    <style>
        .card { 
            background-color: #fff; 
            padding: 24px; 
            border-radius: 12px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08); 
            margin-bottom: 24px;
        }
        .card-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding-bottom: 16px; 
            border-bottom: 2px solid #e5e7eb; 
        }
        .card-title h2 { 
            font-size: 1.5rem; 
            font-weight: 700; 
            color: #1f2937; 
            margin: 0;
        }
        .card-title span { 
            font-size: 0.875rem; 
            color: #6b7280; 
        }
        .btn { 
            display: inline-flex; 
            align-items: center; 
            padding: 8px 16px; 
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 0.875rem; 
            text-decoration: none; 
            color: white; 
            border: none; 
            cursor: pointer; 
            transition: all 0.2s; 
        }
        .btn i { margin-right: 6px; }
        .btn-red { 
            background-color: #dc2626; 
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2);
        }
        .btn-red:hover { 
            background-color: #b91c1c; 
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3);
        }
        .btn-blue { 
            background-color: #2563eb; 
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }
        .btn-blue:hover { 
            background-color: #1d4ed8; 
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }
        .btn-green {
            background-color: #16a34a;
            box-shadow: 0 2px 4px rgba(22, 163, 74, 0.2);
        }
        .btn-green:hover {
            background-color: #15803d;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(22, 163, 74, 0.3);
        }
        .btn-sm { padding: 6px 12px; font-size: 0.8rem; }
        .alert-success { 
            background-color: #d1fae5; 
            border-left: 4px solid #34d399; 
            color: #065f46; 
            padding: 16px; 
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
        }
        .alert-success i { margin-right: 10px; font-size: 1.2rem; }
        .table-wrapper { overflow-x: auto; margin-top: 20px; }
        .styled-table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 0.875rem; 
        }
        .styled-table thead tr { 
            background-color: #f9fafb; 
            text-align: left; 
            color: #374151; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        .styled-table th, .styled-table td { 
            padding: 14px 16px; 
            border-bottom: 1px solid #e5e7eb; 
            vertical-align: middle;
        }
        .styled-table tbody tr { transition: background-color 0.15s; }
        .styled-table tbody tr:hover { background-color: #f9fafb; }
        .pagination { margin-top: 20px; }
        
        .activity-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            gap: 4px;
        }
        .activity-badge.profile-update {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .activity-badge.password-change {
            background-color: #fef3c7;
            color: #92400e;
        }
        .activity-badge i {
            font-size: 0.7rem;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h2><i class="fa-solid fa-users" style="color: #2563eb; margin-right: 10px;"></i>Daftar Karyawan</h2>
                <span>Total {{ $karyawan->total() }} karyawan terdaftar</span>
            </div>
            <div>
                <a href="{{ route('admin.karyawan.create') }}" class="btn btn-red">
                    <i class="fa-solid fa-plus"></i> Tambah Karyawan
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                <i class="fa-solid fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="table-wrapper">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Aktivitas Terakhir</th>
                        <th>Terdaftar</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyawan as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="user-avatar">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span style="font-weight: 600;">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->updated_at->gt($user->created_at->addMinutes(5)))
                                <span class="activity-badge profile-update">
                                    <i class="fa-solid fa-user-edit"></i>
                                    Update Profil
                                </span>
                                <div style="font-size: 0.75rem; color: #6b7280; margin-top: 4px;">
                                    {{ $user->updated_at->diffForHumans() }}
                                </div>
                            @else
                                <span style="font-size: 0.8rem; color: #9ca3af;">Belum ada aktivitas</span>
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 0.8rem; color: #6b7280;">
                                <i class="fa-solid fa-calendar-alt"></i>
                                {{ $user->created_at->format('d M Y') }}
                            </div>
                        </td>

                        {{-- ====================== A K S I  (BUTTON LOG SUDAH DIHAPUS) ====================== --}}
                        <td style="text-align: center; white-space: nowrap;">

                            <a href="{{ route('admin.karyawan.edit', $user->id) }}" class="btn btn-blue btn-sm">
                                <i class="fa-solid fa-edit"></i> Edit
                            </a>

                            <form action="{{ route('admin.karyawan.destroy', $user->id) }}" method="POST" style="display: inline; margin-left: 6px;" onsubmit="return confirm('Yakin ingin menghapus karyawan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-red btn-sm">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>

                        </td>
                        {{-- ======================================================================================= --}}

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #6b7280;">
                            <i class="fa-solid fa-users" style="font-size: 3rem; margin-bottom: 16px; opacity: 0.3;"></i>
                            <p style="font-size: 1.1rem; font-weight: 600;">Belum ada data karyawan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $karyawan->links() }}
        </div>

    </div>
</x-admin-layout>
