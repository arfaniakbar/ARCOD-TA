<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evidence;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // <-- Penting untuk manipulasi tanggal

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk karyawan.
     */
    public function index()
    {
        $userId = Auth::id();

        // Mengambil semua hitungan status dalam satu query untuk efisiensi
        $stats = Evidence::where('user_id', $userId)
                         ->select('status', DB::raw('count(*) as total'))
                         ->groupBy('status')
                         ->pluck('total', 'status');

        // Memasukkan data ke variabel, dengan nilai default 0 jika status tidak ada
        $totalEvidence = $stats->sum();
        $pendingCount = $stats->get('pending', 0);
        $approvedCount = $stats->get('approved', 0);
        $rejectedCount = $stats->get('rejected', 0);
        
        // Mengambil data evidence yang diupload dalam 7 hari terakhir
        $recentEvidences = Evidence::where('user_id', $userId)
                                   ->where('created_at', '>=', Carbon::now()->subDays(7))
                                   ->latest()
                                   ->get();
        
        return view('karyawan.dashboard', [
            'totalEvidence' => $totalEvidence,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
            'rejectedCount' => $rejectedCount,
            'recentEvidences' => $recentEvidences, // Kirim data baru ke view
        ]);
    }
}