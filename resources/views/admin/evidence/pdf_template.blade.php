<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Evidence Pekerjaan</title>
    <style>
        @page { margin: 25px; }
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; color: #333; }
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .header-table td { vertical-align: top; }
        .logo-akses { width: 120px; }
        .logo-indonesia { width: 100px; text-align: right; }
        .title { text-align: center; font-size: 14px; font-weight: bold; text-decoration: underline; margin-bottom: 25px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 3px 0; }
        .info-table .label { width: 100px; font-weight: bold; }
        .info-table .separator { width: 10px; text-align: center; }
        .image-container { border: 1px solid #000; padding: 10px; margin-top: 15px; text-align: center; page-break-inside: avoid; }
        .evidence-image { max-width: 90%; max-height: 400px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td><img src="{{ $logoAksesBase64 }}" class="logo-akses"></td>
            <td class="logo-indonesia"><img src="{{ $logoIndonesiaBase64 }}" class="logo-indonesia"></td>
        </tr>
    </table>

    <div class="title">EVIDENCE PEKERJAAN</div>

    <table class="info-table">
        <tr>
            <td class="label">PROYEK</td>
            <td class="separator">:</td>
            <td>{{ $evidence->judul ?? 'PENGADAAN PEKERJAAN OUTSIDE PLANT FIBER TO THE HOME (OSP - FTTH)' }}</td>
        </tr>
        <tr>
            <td class="label">KONTRAK</td>
            <td class="separator">:</td>
            <td>TAHUN 2025 TELKOM REGIONAL IV KALIMANTAN</td>
        </tr>
        <tr>
            <td class="label">AREA</td>
            <td class="separator">:</td>
            <td>BANJARMASIN</td>
        </tr>
        <tr>
            <td class="label">LOKASI</td>
            <td class="separator">:</td>
            <td>poliban</td>
        </tr>
        <tr>
            <td class="label">PELAKSANA</td>
            <td class="separator">:</td>
            <td>PT. TELKOM AKSES</td>
        </tr>
    </table>

    @if(is_array($evidence->file_path))
        @foreach($evidence->file_path as $imagePath)
            <div class="image-container">
                <img src="{{ public_path('storage/' . $imagePath) }}" class="evidence-image">
            </div>
        @endforeach
    @endif

</body>
</html>