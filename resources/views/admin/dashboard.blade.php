<x-admin-layout>
    {{-- CSS Khusus untuk halaman ini --}}
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(1, 1fr); gap: 24px; }
        @media (min-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
        .stat-card { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); display: flex; align-items: center; }
        .stat-card .icon { padding: 12px; border-radius: 9999px; margin-right: 16px; }
        .stat-card .icon i { font-size: 1.5rem; color: #fff; width: 28px; height: 28px; text-align: center; line-height: 28px; }
        .stat-card .info h4 { font-size: 0.875rem; font-weight: 500; color: #6b7280; text-transform: uppercase; }
        .stat-card .info p { font-size: 1.875rem; font-weight: 700; color: #1f2937; }
        .icon-karyawan { background-color: #3b82f6; }   /* Biru */
        .icon-pending { background-color: #f59e0b; }    /* Kuning */
        .icon-approved { background-color: #10b981; }   /* Hijau */
        .card { background-color: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .card h3 { font-size: 1.25rem; font-weight: 600; color: #1f2937; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb; margin-bottom: 16px; }
        .styled-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        .styled-table thead tr { text-align: left; color: #374151; font-size: 0.75rem; text-transform: uppercase; }
        .styled-table th, .styled-table td { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; }
        .styled-table tbody tr:last-child td { border-bottom: none; }
        
        /* CSS untuk layout grid diagram dan tabel */
        .dashboard-grid { display: grid; grid-template-columns: 1fr; gap: 24px; margin-top: 24px;}
        @media (min-width: 1024px) { .dashboard-grid { grid-template-columns: repeat(12, 1fr); } }
        .chart-container { grid-column: span 12; }
        .pending-container { grid-column: span 12; }
        @media (min-width: 1024px) {
            .chart-container { grid-column: span 7 / span 7; }
            .pending-container { grid-column: span 5 / span 5; }
        }
        .pending-table-container { max-height: 280px; overflow-y: auto; }
    </style>

    <!-- Kartu Statistik -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon icon-karyawan"><i class="fa-solid fa-users"></i></div>
            <div class="info"><h4>Total Karyawan</h4><p>{{ $totalKaryawan }}</p></div>
        </div>
        <div class="stat-card">
            <div class="icon icon-pending"><i class="fa-solid fa-clock"></i></div>
            <div class="info"><h4>Menunggu Persetujuan</h4><p>{{ $pendingCount }}</p></div>
        </div>
        <div class="stat-card">
            <div class="icon icon-approved"><i class="fa-solid fa-check-circle"></i></div>
            <div class="info"><h4>Disetujui Bulan Ini</h4><p>{{ $approvedThisMonthCount }}</p></div>
        </div>
    </div>

    <!-- Layout Grid untuk Diagram dan Tabel Pending -->
    <div class="dashboard-grid">
        <!-- Diagram -->
        <div class="card chart-container">
            <h3>Aktivitas Persetujuan (7 Hari Terakhir)</h3>
            <div style="height: 300px; position: relative;">
                <canvas id="progressChart"></canvas>
            </div>
        </div>

        <!-- Daftar Evidence Pending -->
        <div class="card pending-container">
            <h3>Menunggu Persetujuan</h3>
            <div class="pending-table-container">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>lokasi</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendingEvidences as $evidence)
                            <tr>
                                <td>{{ $evidence->user->name }}</td>
                                <td>{{ $evidence->lokasi }}</td>
                                <td style="text-align: center;">
                                    <a href="{{ route('admin.evidence.index') }}" style="font-weight: 500; color: #2563eb; text-decoration: none;">
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 16px;">
                                    Tidak ada evidence yang menunggu persetujuan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('progressChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! $chartData['labels'] !!},
                    datasets: [{
                        label: 'Disetujui',
                        data: {!! $chartData['approved'] !!},
                        backgroundColor: '#22c55e',
                        borderRadius: 5,
                    },{
                        label: 'Ditolak',
                        data: {!! $chartData['rejected'] !!},
                        backgroundColor: '#ef4444',
                        borderRadius: 5,
                    }]
                },
                options: { 
                    responsive: true, 
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }, 
                    scales: { y: { beginAtZero: true } } 
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>