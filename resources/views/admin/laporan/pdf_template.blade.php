<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Evidence</title>
    <style>
        @page {
            margin: 40px;
        }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 11pt; 
            margin: 0;
            padding: 0;
        }
        .header { 
            width: 100%; 
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .header td { 
            vertical-align: middle; 
        }
        .title { 
            text-align: center; 
            font-weight: bold; 
            font-size: 14pt; 
            margin: 10px 0; 
            text-decoration: underline; 
        }
        .info { 
            width: 100%; 
            margin-bottom: 20px; 
            border-collapse: collapse; 
        }
        .info td { 
            padding: 4px 6px; 
            vertical-align: top; 
        }
        .info td:first-child { 
            width: 20%; 
            font-weight: bold; 
        }
        .info td:nth-child(2) { 
            width: 3%; 
        }
        .info td:last-child { 
            width: 77%; 
        }
        .evidence-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px; 
        }
        .evidence-table td { 
            border: 1px solid #000; 
            text-align: center; 
            padding: 8px; 
            vertical-align: top; 
        }
        .caption { 
            font-size: 9pt; 
            margin-top: 5px; 
        }
        .page-break { 
            page-break-after: always; 
        }
    </style>
</head>
<body>
@foreach($evidences as $index => $evidenceData)
    {{-- Header muncul di setiap halaman --}}
    <table class="header">
        <tr>
            <td style="width: 50%; text-align: left;">
                @if($logoAksesBase64)
                    <img src="{{ $logoAksesBase64 }}" alt="Logo Akses" style="height: 50px;">
                @endif
            </td>
            <td style="width: 50%; text-align: right;">
                @if($logoIndonesiaBase64)
                    <img src="{{ $logoIndonesiaBase64 }}" alt="Logo Indonesia" style="height: 60px;">
                @endif
            </td>
        </tr>
    </table>

    <div class="title">EVIDENCE PEKERJAAN</div>

    {{-- Info project - tampil di semua halaman untuk testing --}}
    <table class="info">
        <tr>
            <td>PROYEK</td>
            <td>:</td>
            <td>
                PENGADAAN PEKERJAAN OUTSIDE PLANT FIBER TO THE HOME (OSP - FTTH)<br>
                TAHUN 2025 TELKOM REGIONAL IV KALIMANTAN
            </td>
        </tr>
        <tr><td>KONTRAK</td><td>:</td><td></td></tr>
        <tr><td>AREA</td><td>:</td><td>BANJARMASIN</td></tr>
        <tr><td>LOKASI</td><td>:</td><td>{{ $evidenceData['lokasi'] ?? '-' }}</td></tr>
        <tr><td>PELAKSANA</td><td>:</td><td>PT. TELKOM AKSES</td></tr>
    </table>

    {{-- Tabel gambar (maksimal 6 foto, 3 kolom x 2 baris) --}}
    <table class="evidence-table">
        @foreach(array_chunk($evidenceData['file_path'], 3) as $chunk)
            <tr>
                @foreach($chunk as $fileData)
                    <td>
                        @if(!empty($fileData['base64']))
                            <img src="{{ $fileData['base64'] }}" style="width: 180px; height: auto;">
                        @endif
                    </td>
                @endforeach
                @for($i = count($chunk); $i < 3; $i++)
                    <td></td>
                @endfor
            </tr>
            <tr>
                @foreach($chunk as $fileData)
                    <td class="caption">{{ $fileData['caption'] ?? '' }}</td>
                @endforeach
                @for($i = count($chunk); $i < 3; $i++)
                    <td></td>
                @endfor
            </tr>
        @endforeach
    </table>

    {{-- Page break kecuali halaman terakhir --}}
    @if($index < count($evidences) - 1)
        <div class="page-break"></div>
    @endif
@endforeach
</body>
</html>