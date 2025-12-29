<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evidence;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\SimpleType\Jc;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan admin
     */
    public function index(Request $request)
    {
        $karyawanList = User::where('role', 'karyawan')->orderBy('name')->get();

        $query = Evidence::with('user')->where('status', 'approved');

        $selectedMonthYear = $request->input('month_year');
        $selectedUserId = $request->input('user_id');
        $selectedMonth = null;
        $selectedYear = null;

        if ($selectedMonthYear) {
            list($selectedMonth, $selectedYear) = explode('-', $selectedMonthYear);
            $query->whereMonth('updated_at', $selectedMonth)
                ->whereYear('updated_at', $selectedYear);
        }

        if ($selectedUserId) {
            $query->where('user_id', $selectedUserId);
        }

        $approvedEvidences = $query->latest('updated_at')->get();

        $availableFilters = Evidence::select(
            DB::raw('EXTRACT(YEAR FROM updated_at) as year'),
            DB::raw('EXTRACT(MONTH FROM updated_at) as month')
        )
            ->where('status', 'approved')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.laporan.index', compact(
            'approvedEvidences',
            'availableFilters',
            'selectedMonth',
            'selectedYear',
            'karyawanList',
            'selectedUserId'
        ));
    }

    /**
     * Generate laporan
     */
    public function generate(Request $request)
    {
        $request->validate([
            'evidence_ids' => 'required|array|min:1',
            'evidence_ids.*' => 'exists:evidences,id',
            'format' => 'required|in:word,pdf'
        ], [
            'evidence_ids.required' => 'Mohon pilih minimal satu evidence untuk digenerate.'
        ]);

        $evidenceIds = $request->input('evidence_ids');
        $evidences = Evidence::with('user')->whereIn('id', $evidenceIds)->get();
        $format = $request->input('format');

        try {
            if ($format === 'word') {
                return $this->generateWord($evidences);
            }

            if ($format === 'pdf') {
                return $this->generatePdf($evidences);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * Generate Word (docx)
     */
    private function generateWord($evidences)
    {
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        foreach ($evidences as $evidence) {
            $filesData = $this->normalizeFilesData($evidence->file_path);
            
            // Batasi 6 foto per halaman
            $imageChunks = array_chunk($filesData, 6);

            foreach ($imageChunks as $chunkIndex => $pageImages) {
                $section = $phpWord->addSection([
                    'marginTop' => 1000,
                    'marginBottom' => 1000,
                    'marginLeft' => 1000,
                    'marginRight' => 1000
                ]);

                // Header Logo - di setiap halaman
                $header = $section->addHeader();
                $headerTable = $header->addTable(['alignment' => Jc::CENTER]);
                $headerTable->addRow();
                
                // Logo kiri
                $cellLeft = $headerTable->addCell(4500);
                if (file_exists(public_path('images/logo-kiri.png'))) {
                    $cellLeft->addImage(public_path('images/logo-kiri.png'), [
                        'width' => 120,
                        'height' => 50
                    ]);
                }
                
                // Logo kanan
                $cellRight = $headerTable->addCell(4500);
                if (file_exists(public_path('images/logo-kanan.png'))) {
                    $cellRight->addImage(public_path('images/logo-kanan.png'), [
                        'width' => 100,
                        'height' => 60,
                        'alignment' => Jc::END
                    ]);
                }

                // Title
                $section->addTextBreak(1);
                $section->addText(
                    'EVIDENCE PEKERJAAN',
                    ['bold' => true, 'size' => 14, 'underline' => 'single'],
                    ['alignment' => Jc::CENTER, 'spaceAfter' => 240]
                );

                // Info Project - pakai TABEL tanpa border
                $infoTableStyle = [
                    'borderSize' => 0,
                    'borderColor' => 'FFFFFF',
                    'cellMargin' => 0,
                    'alignment' => Jc::START
                ];
                
                $cellStyle = [
                    'borderSize' => 0,
                    'borderColor' => 'FFFFFF',
                    'valign' => 'top'
                ];
                
                $infoTable = $section->addTable($infoTableStyle);
                
                // PROYEK
                $infoTable->addRow();
                $infoTable->addCell(1800, $cellStyle)->addText('PROYEK', ['bold' => true, 'size' => 11]);
                $infoTable->addCell(200, $cellStyle)->addText(':', ['size' => 11]);
                $cell = $infoTable->addCell(7000, $cellStyle);
                $cell->addText('PENGADAAN PEKERJAAN OUTSIDE PLANT FIBER TO THE HOME (OSP - FTTH)', ['size' => 11]);
                $cell->addText('TAHUN 2025 TELKOM REGIONAL IV KALIMANTAN', ['size' => 11]);
                
                // KONTRAK
                $infoTable->addRow();
                $infoTable->addCell(1800, $cellStyle)->addText('KONTRAK', ['bold' => true, 'size' => 11]);
                $infoTable->addCell(200, $cellStyle)->addText(':', ['size' => 11]);
                $infoTable->addCell(7000, $cellStyle)->addText('', ['size' => 11]);
                
                // AREA
                $infoTable->addRow();
                $infoTable->addCell(1800, $cellStyle)->addText('AREA', ['bold' => true, 'size' => 11]);
                $infoTable->addCell(200, $cellStyle)->addText(':', ['size' => 11]);
                $infoTable->addCell(7000, $cellStyle)->addText('BANJARMASIN', ['size' => 11]);
                
                // LOKASI
                $infoTable->addRow();
                $infoTable->addCell(1800, $cellStyle)->addText('LOKASI', ['bold' => true, 'size' => 11]);
                $infoTable->addCell(200, $cellStyle)->addText(':', ['size' => 11]);
                $infoTable->addCell(7000, $cellStyle)->addText($evidence->lokasi ?? '-', ['size' => 11]);
                
                // PELAKSANA
                $infoTable->addRow();
                $infoTable->addCell(1800, $cellStyle)->addText('PELAKSANA', ['bold' => true, 'size' => 11]);
                $infoTable->addCell(200, $cellStyle)->addText(':', ['size' => 11]);
                $infoTable->addCell(7000, $cellStyle)->addText('PT. TELKOM AKSES', ['size' => 11]);

                $section->addTextBreak(1);

                // Tabel Gambar - maksimal 6 foto (3 kolom x 2 baris)
                $imageRows = array_chunk($pageImages, 3);
                
                foreach ($imageRows as $row) {
                    $imageTable = $section->addTable([
                        'borderSize' => 6,
                        'borderColor' => '000000',
                        'cellMargin' => 80,
                        'alignment' => Jc::CENTER
                    ]);

                    // Row gambar
                    $imageTable->addRow(2000);
                    foreach ($row as $fileData) {
                        $cell = $imageTable->addCell(3000, ['valign' => 'center']);
                        $safePath = ltrim($fileData['path'], '/');
                        $fullPath = storage_path('app/public/' . $safePath);

                        if (file_exists($fullPath)) {
                            $cell->addImage($fullPath, [
                                'width' => 150,
                                'height' => 150,
                                'alignment' => Jc::CENTER
                            ]);
                        }
                    }
                    
                    // Isi cell kosong
                    for ($i = count($row); $i < 3; $i++) {
                        $imageTable->addCell(3000);
                    }

                    // Row caption
                    $imageTable->addRow();
                    foreach ($row as $fileData) {
                        $imageTable->addCell(3000, ['valign' => 'center'])->addText(
                            $fileData['caption'] ?? '',
                            ['size' => 9],
                            ['alignment' => Jc::CENTER]
                        );
                    }
                    
                    // Isi cell caption kosong
                    for ($i = count($row); $i < 3; $i++) {
                        $imageTable->addCell(3000);
                    }
                }
            }
        }

        $fileName = 'Laporan-Evidence-' . now()->format('d-m-Y') . '.docx';
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path($fileName));

        return response()->download(storage_path($fileName))->deleteFileAfterSend(true);
    }

    /**
     * Generate PDF
     */
    private function generatePdf($evidences)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(0);

        $logoAksesBase64 = file_exists(public_path('images/logo-kiri.png'))
            ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo-kiri.png')))
            : null;

        $logoIndonesiaBase64 = file_exists(public_path('images/logo-kanan.png'))
            ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo-kanan.png')))
            : null;

        // Normalisasi file evidence menjadi Base64 DAN pecah per 6 foto
        $processedEvidences = [];
        foreach ($evidences as $evidence) {
            $normalizedFiles = [];
            if (is_array($evidence->file_path)) {
                foreach ($evidence->file_path as $file) {
                    $path = is_array($file) ? $file['path'] : $file;
                    $caption = is_array($file) && isset($file['caption']) ? $file['caption'] : '';

                    $safePath = ltrim($path, '/');
                    $fullPath = storage_path('app/public/' . $safePath);

                    if (file_exists($fullPath)) {
                        $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));
                        $normalizedFiles[] = [
                            'base64' => 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($fullPath)),
                            'caption' => $caption
                        ];
                    }
                }
            }

            // Pecah menjadi page (maksimal 6 foto per page)
            if (count($normalizedFiles) > 0) {
                $pages = array_chunk($normalizedFiles, 6);
                foreach ($pages as $pageIndex => $pageFiles) {
                    $processedEvidences[] = [
                        'lokasi' => $evidence->lokasi,
                        'file_path' => $pageFiles,
                        'is_first_page' => ($pageIndex === 0) ? true : false // Untuk info project
                    ];
                }
            } else {
                // Jika tidak ada gambar, tetap tampilkan info
                $processedEvidences[] = [
                    'lokasi' => $evidence->lokasi,
                    'file_path' => [],
                    'is_first_page' => true
                ];
            }
        }

        $data = [
            'evidences' => $processedEvidences,
            'logoAksesBase64' => $logoAksesBase64,
            'logoIndonesiaBase64' => $logoIndonesiaBase64
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf_template', $data)
            ->setPaper('A4', 'portrait')
            ->setOption([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        $fileName = 'Laporan-Evidence-' . now()->format('d-m-Y') . '.pdf';
        return $pdf->download($fileName);
    }

    /**
     * Normalisasi file evidence
     */
    private function normalizeFilesData($files)
    {
        if (!is_array($files)) {
            return [];
        }

        $normalized = [];
        foreach ($files as $file) {
            if (is_array($file) && isset($file['path'])) {
                $normalized[] = ['path' => $file['path'], 'caption' => $file['caption'] ?? ''];
            } elseif (is_string($file)) {
                $normalized[] = ['path' => $file, 'caption' => ''];
            }
        }
        return $normalized;
    }
}