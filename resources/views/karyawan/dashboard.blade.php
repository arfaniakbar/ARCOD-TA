<x-karyawan-layout>
    {{-- CSS Khusus untuk halaman ini --}}
    <style>
        .stats-grid { display: grid; grid-template-columns: repeat(1, 1fr); gap: 24px; }
        @media (min-width: 768px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }
        .stat-card { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); display: flex; align-items: center; }
        .stat-card .icon { padding: 12px; border-radius: 9999px; margin-right: 16px; }
        .stat-card .icon i { font-size: 1.5rem; color: #fff; width: 28px; height: 28px; text-align: center; line-height: 28px; }
        .stat-card .info h4 { font-size: 0.875rem; font-weight: 500; color: #6b7280; text-transform: uppercase; }
        .stat-card .info p { font-size: 1.875rem; font-weight: 700; color: #1f2937; }
        .icon-total { background-color: #1f2937; }
        .icon-pending { background-color: #f59e0b; }
        .icon-approved { background-color: #10b981; }
        .icon-rejected { background-color: #ef4444; }
        .recent-evidence-card { background-color: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); margin-top: 24px; }
        .recent-evidence-card h3 { font-size: 1.25rem; font-weight: 600; color: #1f2937; padding-bottom: 16px; border-bottom: 1px solid #e5e7eb; margin-bottom: 16px; }
        .styled-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        .styled-table thead tr { text-align: left; color: #374151; font-size: 0.75rem; text-transform: uppercase; }
        .styled-table th, .styled-table td { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; }
        .styled-table tbody tr:last-child td { border-bottom: none; }
        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; text-transform: capitalize; }
        .badge-pending { background-color: #fef9c3; color: #a16207; }
        .badge-approved { background-color: #dcfce7; color: #166534; }
        .badge-rejected { background-color: #fee2e2; color: #991b1b; }
    </style>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon icon-total"><i class="fa-solid fa-file-lines"></i></div>
            <div class="info"><h4>Total Evidence Saya</h4><p>{{ $totalEvidence }}</p></div>
        </div>
        <div class="stat-card">
            <div class="icon icon-pending"><i class="fa-solid fa-clock"></i></div>
            <div class="info"><h4>Menunggu Persetujuan</h4><p>{{ $pendingCount }}</p></div>
        </div>
        <div class="stat-card">
            <div class="icon icon-approved"><i class="fa-solid fa-check-circle"></i></div>
            <div class="info"><h4>Disetujui</h4><p>{{ $approvedCount }}</p></div>
        </div>
        <div class="stat-card">
            <div class="icon icon-rejected"><i class="fa-solid fa-times-circle"></i></div>
            <div class="info"><h4>Ditolak</h4><p>{{ $rejectedCount }}</p></div>
        </div>
    </div>

    <div class="recent-evidence-card">
        <h3>Evidence Terbaru (7 Hari Terakhir)</h3>
        <div style="overflow-x: auto;">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Lokasi</th>
                        <th>Tanggal Upload</th>
                        <th style="text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentEvidences as $evidence)
                        <tr>
                            {{-- PERBAIKAN DI SINI: Menggunakan 'lokasi' bukan 'judul' --}}
                            <td>{{ $evidence->lokasi }}</td>
                            <td>{{ $evidence->created_at->format('d M Y') }}</td>
                            <td style="text-align: center;">
                                <span class="badge badge-{{ $evidence->status }}">
                                    {{ $evidence->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 16px;">
                                Tidak ada evidence yang diupload dalam 7 hari terakhir.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-karyawan-layout>