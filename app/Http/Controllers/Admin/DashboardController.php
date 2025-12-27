<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evidence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Kartu Statistik
        $totalKaryawan = User::where('role', 'karyawan')->count();
        $pendingCount = Evidence::where('status', 'pending')->count();
        $approvedThisMonthCount = Evidence::where('status', 'approved')
                                          ->whereMonth('updated_at', Carbon::now()->month)
                                          ->whereYear('updated_at', Carbon::now()->year)
                                          ->count();

        // Data untuk Grafik (7 Hari Terakhir)
        $chartLabels = [];
        $approvedData = [];
        $rejectedData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M'); // Format tanggal (e.g., 26 Sep)

            $approvedData[] = Evidence::where('status', 'approved')
                                      ->whereDate('updated_at', $date)
                                      ->count();
            
            $rejectedData[] = Evidence::where('status', 'rejected')
                                      ->whereDate('updated_at', $date)
                                      ->count();
        }

        $chartData = [
            'labels' => json_encode($chartLabels),
            'approved' => json_encode($approvedData),
            'rejected' => json_encode($rejectedData),
        ];

        // Data untuk Tabel (5 Evidence Pending Terbaru)
        $pendingEvidences = Evidence::with('user')
                                    ->where('status', 'pending')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        return view('admin.dashboard', [
            'totalKaryawan' => $totalKaryawan,
            'pendingCount' => $pendingCount,
            'approvedThisMonthCount' => $approvedThisMonthCount,
            'chartData' => $chartData,
            'pendingEvidences' => $pendingEvidences,
        ]);
    }
}