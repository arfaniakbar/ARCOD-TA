<x-admin-layout>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }
        @media (min-width: 1024px) {
            .grid-container {
                grid-template-columns: 320px 1fr; /* Kolom filter 320px, sisanya tabel */
            }
        }
        .card {
            background-color: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .card-header {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            padding-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 24px;
        }
        .form-section {
            margin-bottom: 20px;
        }
        .form-section strong {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 12px;
        }
        .form-section select, .form-section label {
            display: block;
            width: 100%;
        }
        .form-section select {
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }
        .form-section .radio-group label {
            display: flex;
            align-items: center;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
        }
        .form-section .radio-group input {
            margin-right: 10px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
        }
        .btn-red { background-color: #dc2626; color: white; }
        .btn-red:hover { background-color: #b91c1c; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); }
        .btn-secondary { background-color: #e5e7eb; color: #1f2937; text-align: center; }
        .btn-secondary:hover { background-color: #d1d5db; }
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
        }
        .styled-table th, .styled-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }
        .alert-danger { background-color: #fee2e2; border-left: 4px solid #ef4444; color: #991b1b; padding: 16px; margin-bottom: 16px; border-radius: 6px; }
    </style>

    <div class="grid-container">
        <!-- Kolom Filter & Generate -->
        <div class="card">
            <h2 class="card-header" style="margin-bottom: 0; border-bottom: none;">Opsi Laporan</h2>
            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 24px 0;">

            <!-- Form untuk filter data (method GET) -->
            <form id="filter-form" method="GET" action="{{ route('admin.laporan.index') }}">
                <div class="form-section">
                    <strong>1. Filter Data</strong>
                    <div style="display: grid; gap: 1rem;">
                        <select name="month_year">
                            <option value="">Semua Periode</option>
                            @foreach($availableFilters as $filter)
                                @php
                                    $date = \Carbon\Carbon::createFromDate($filter->year, $filter->month, 1);
                                    $value = $filter->month . '-' . $filter->year;
                                    $isSelected = ($selectedMonth == $filter->month && $selectedYear == $filter->year);
                                @endphp
                                <option value="{{ $value }}" {{ $isSelected ? 'selected' : '' }}>
                                    {{ $date->translatedFormat('F Y') }}
                                </option>
                            @endforeach
                        </select>
                        <select name="user_id">
                            <option value="">Semua Karyawan</option>
                            @foreach($karyawanList as $karyawan)
                                <option value="{{ $karyawan->id }}" {{ $selectedUserId == $karyawan->id ? 'selected' : '' }}>
                                    {{ $karyawan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 1rem;">
                        {{-- DIUBAH DI SINI DARI btn-blue MENJADI btn-red --}}
                        <button type="submit" class="btn btn-red" style="width: 100%;">Filter</button>
                        <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary" style="width: auto;">Reset</a>
                    </div>
                </div>
            </form>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 24px 0;">

            <!-- Form untuk generate laporan (method POST) -->
            <form id="generate-form" action="{{ route('admin.laporan.generate') }}" method="POST">
                @csrf
                <div class="form-section">
                    <strong>2. Pilih Format Output</strong>
                    <div class="radio-group">
                        <label><input type="radio" name="format" value="pdf" checked> PDF</label>
                        <label><input type="radio" name="format" value="word"> Word (.docx)</label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-red">
                    <i class="fa-solid fa-download" style="margin-right: 8px;"></i>
                    Generate Laporan
                </button>
            </form>
        </div>

        <!-- Kolom Tabel Evidence -->
        <div class="card">
            <h2 class="card-header">Pilih Evidence (Approved)</h2>

            @if ($errors->any())
                <div class="alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div style="overflow-x: auto;">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;"><input type="checkbox" onclick="toggle(this);"></th>
                            <th>Karyawan</th>
                            <th>Lokasi</th>
                            <th>Tanggal Disetujui</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($approvedEvidences as $evidence)
                        <tr>
                            {{-- Checkbox ini terhubung ke form "generate-form" --}}
                            <td><input type="checkbox" name="evidence_ids[]" value="{{ $evidence->id }}" form="generate-form"></td>
                            <td>{{ $evidence->user->name }}</td>
                            <td>{{ $evidence->lokasi }}</td>
                            <td>{{ $evidence->updated_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 16px;">
                                Tidak ada evidence yang disetujui pada periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggle(source) {
            // Targetkan checkbox yang ada di dalam form "generate-form"
            checkboxes = document.querySelectorAll('form#generate-form input[name="evidence_ids[]"]');
            for(var i=0, n=checkboxes.length; i<n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
</x-admin-layout>