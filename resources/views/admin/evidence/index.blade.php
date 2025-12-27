<x-admin-layout>
    <style>
        /* =========================================
           🔹 GAYA DASAR CARD & TABEL
        ========================================= */
        .card {
            background-color: #fff;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
        }
        .card-title h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        .card-title span {
            font-size: 0.9rem;
            color: #6b7280;
        }
        .alert-success {
            background-color: #d1fae5;
            border-left: 4px solid #34d399;
            color: #065f46;
            padding: 14px;
            margin-top: 18px;
            border-radius: 6px;
        }

        /* =========================================
           🔹 TABEL DATA EVIDENCE
        ========================================= */
        .table-wrapper {
            overflow-x: auto;
            margin-top: 24px;
        }
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }
        .styled-table thead tr {
            background-color: #f3f4f6;
            text-align: left;
            color: #374151;
            font-weight: 600;
        }
        .styled-table th,
        .styled-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        .styled-table tbody tr:hover {
            background-color: #f9fafb;
        }

        /* =========================================
           🔹 BADGE STATUS
        ========================================= */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .badge-pending { background-color: #fef9c3; color: #a16207; }
        .badge-approved { background-color: #dcfce7; color: #166534; }
        .badge-rejected { background-color: #fee2e2; color: #991b1b; }

        /* =========================================
           🔹 BUTTON STYLE
        ========================================= */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-green { background-color: #16a34a; }
        .btn-green:hover { background-color: #15803d; }
        .btn-red { background-color: #dc2626; }
        .btn-red:hover { background-color: #b91c1c; }
        .btn-blue { background-color: #2563eb; }
        .btn-blue:hover { background-color: #1d4ed8; }
        .btn-gray { background-color: #6b7280; }
        .btn-gray:hover { background-color: #4b5563; }
        .btn-secondary {
            background-color: #e5e7eb;
            color: #1f2937;
        }
        .btn-secondary:hover { background-color: #d1d5db; }

        /* =========================================
           🔹 PAGINATION
        ========================================= */
        .pagination {
            margin-top: 24px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 8px;
        }
        .pagination nav a,
        .pagination nav span {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid #d1d5db;
        }
        .pagination nav span[aria-current="page"] {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        /* =========================================
           🔹 MODAL PREVIEW FOTO (SAMA KAYAK KARYAWAN)
        ========================================= */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }
        .modal-content {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            height: 90%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .modal-header-clean {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .modal-header-clean h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #1f2937;
        }
        .modal-content-body {
            flex-grow: 1;
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 10px;
        }
        .image-preview-item {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 220px;
            overflow: hidden;
        }
        .image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 6px;
        }
        .image-caption {
            margin-top: 10px;
            text-align: center;
            font-size: 0.9rem;
            color: #374151;
            font-weight: 600;
            border-top: 1px dashed #e5e7eb;
            padding-top: 6px;
        }
    </style>

    <div class="card" x-data="{ modalOpen: false, rejectModalOpen: false, evidenceFiles: [], rejectAction: '' }">
        <div class="card-header">
            <div class="card-title">
                <h2>Kelola Evidence</h2>
                <span>Total {{ $evidences->total() }} data ditemukan</span>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left" style="margin-right: 6px;"></i> Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-wrapper">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>No. PO</th>
                        <th>Tematik</th>
                        <th>Waspang</th>
                        <th>Lokasi / Tanggal</th>
                        <th>Detail Foto</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($evidences as $evidence)
                        @php
                            $files = $evidence->file_path ?? [];
                            $filesJson = json_encode($files);
                        @endphp
                        <tr>
                            <td>{{ $evidence->user->name ?? 'N/A' }}</td>
                            <td>{{ $evidence->po->no_po ?? 'N/A' }}</td>
                            <td>{{ $evidence->tematik->nama_tematik ?? 'N/A' }}</td>
                            <td>{{ $evidence->pangwas->nama_pangwas ?? 'N/A' }}</td>
                            <td>
                                <div style="font-weight: 600;">{{ $evidence->lokasi }}</div>
                                <div style="font-size: 0.8rem; color: #6b7280;">
                                    {{ $evidence->created_at->format('d M Y H:i') }}
                                </div>
                            </td>
                            <td>
                                <button
                                    @click="modalOpen = true; evidenceFiles = {{ $filesJson }}"
                                    class="btn btn-blue">
                                    <i class="fa-solid fa-images" style="margin-right: 6px;"></i>
                                    Lihat ({{ count($files) }})
                                </button>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge badge-{{ $evidence->status }}">{{ $evidence->status }}</span>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                @if ($evidence->status == 'pending')
                                    <form action="{{ route('admin.evidence.approve', $evidence) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-green">Approve</button>
                                    </form>
                                    <button @click="rejectModalOpen = true; rejectAction = '{{ route('admin.evidence.reject', $evidence) }}'" class="btn btn-red" style="margin-left:8px;">
                                        Reject
                                    </button>
                                @else
                                    <span class="btn btn-gray">Selesai</span>
                                @endif
                                <form action="{{ route('admin.evidence.destroy', $evidence) }}" method="POST" style="display:inline; margin-left:8px;" onsubmit="return confirm('Yakin ingin MENGHAPUS PERMANEN evidence ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-red">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center; padding:20px;">Tidak ada data evidence.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $evidences->links() }}</div>

        {{-- ===================== 🔹 MODAL DETAIL FOTO ===================== --}}
        <div x-show="modalOpen" class="modal-overlay" style="display:none;">
            <div class="modal-content" @click.away="modalOpen = false">
                <div class="modal-header-clean">
                    <h3>Detail File Evidence</h3>
                    <span style="color:#6b7280;">Total <span x-text="evidenceFiles.length">0</span> Foto</span>
                </div>

                <div class="modal-content-body">
                    <template x-if="evidenceFiles && evidenceFiles.length > 0">
                        <template x-for="(fileData, index) in evidenceFiles" :key="index">
                            <div class="image-preview-item">
                                <div class="image-container">
                                    <img :src="'{{ asset('storage') }}/' + (fileData.file_path || fileData.path || fileData)" :alt="'Evidence ' + (index + 1)" loading="lazy">
                                </div>
                                <p class="image-caption" x-text="fileData.caption || (typeof fileData === 'string' ? 'ODP-' + (index + 1) : (fileData.file_path || fileData.path))"></p>
                            </div>
                        </template>
                    </template>
                    <template x-if="!evidenceFiles || evidenceFiles.length === 0">
                        <p style="text-align:center; font-size:0.9rem; color:#6b7280;">Tidak ada file untuk ditampilkan.</p>
                    </template>
                </div>

                <div style="text-align:right; margin-top:15px;">
                    <button @click="modalOpen = false" class="btn btn-red">Tutup</button>
                </div>
            </div>
        </div>

        {{-- ===================== 🔹 MODAL REJECT ===================== --}}
        <div x-show="rejectModalOpen" class="modal-overlay" style="display:none;">
            <div class="modal-content" @click.away="rejectModalOpen = false" style="max-width:450px; height:auto;">
                <h3 style="font-size:1.2rem; font-weight:700; color:#1f2937; margin-bottom:10px;">Alasan Penolakan</h3>
                <form :action="rejectAction" method="POST">
                    @csrf
                    @method('PATCH')
                    <textarea name="catatan_admin" rows="3" class="w-full border rounded p-2" style="width:100%; border-color:#d1d5db;" placeholder="Tulis alasan penolakan..." required></textarea>
                    <div style="margin-top:15px; text-align:right;">
                        <button type="button" @click="rejectModalOpen = false" class="btn btn-gray">Batal</button>
                        <button type="submit" class="btn btn-red" style="margin-left:8px;">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
