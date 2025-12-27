<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\EvidenceController as AdminEvidenceController;
use App\Http\Controllers\Admin\LaporanController;
// --- START: PENAMBAHAN USE CONTROLLER MASTER DATA ---
use App\Http\Controllers\Admin\PangwasController;
use App\Http\Controllers\Admin\TematikController;
use App\Http\Controllers\Admin\PurchaseOrderController;
// --- END: PENAMBAHAN CONTROLLER MASTER DATA ---
use App\Http\Controllers\Karyawan\DashboardController as KaryawanDashboardController;
use App\Http\Controllers\Karyawan\EvidenceController as KaryawanEvidenceController;

Route::get('/', function () {
    if (Auth::guest()) {
        return redirect()->route('login');
    }
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->role == 'karyawan') {
        return redirect()->route('karyawan.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup Rute untuk Admin (SUDAH DIGABUNG)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Karyawan
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('karyawan', KaryawanController::class);
    
    // --- START: RUTE MASTER DATA BARU ---
  Route::resource('pangwas', PangwasController::class)->parameters([
    'pangwas' => 'pangwas' // Memaksa Laravel agar parameter resource bernama 'pangwas'
]);
    // Menyediakan rute admin.tematik.index, dsb.
    Route::resource('tematik', TematikController::class);

    // Menyediakan rute admin.po.index, dsb.
    Route::resource('po', PurchaseOrderController::class);
    // --- END: RUTE MASTER DATA BARU ---

    // Evidence
    Route::get('evidence', [AdminEvidenceController::class, 'index'])->name('evidence.index');
    Route::patch('evidence/{evidence}/approve', [AdminEvidenceController::class, 'approve'])->name('evidence.approve');
    Route::patch('evidence/{evidence}/reject', [AdminEvidenceController::class, 'reject'])->name('evidence.reject');
    Route::delete('evidence/{evidence}', [AdminEvidenceController::class, 'destroy'])->name('evidence.destroy');

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('laporan/generate', [LaporanController::class, 'generate'])->name('laporan.generate');
});

// Grup Rute untuk Karyawan
Route::middleware(['auth', 'role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
    Route::get('/dashboard', [KaryawanDashboardController::class, 'index'])->name('dashboard');
    Route::resource('evidence', KaryawanEvidenceController::class);
});

// Rute Profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// --- TEMPORARY: Route to run migrations on Vercel ---
Route::get('/migrate-db', function () {
    try {
        // Get all table names
        $tables = Illuminate\Support\Facades\DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
        
        // Drop all tables one by one with CASCADE
        foreach ($tables as $table) {
            Illuminate\Support\Facades\DB::statement("DROP TABLE IF EXISTS \"{$table->tablename}\" CASCADE");
        }
        
        // Now run migrations
        Illuminate\Support\Facades\Artisan::call('migrate', [
            '--force' => true
        ]);
        
        $migrateOutput = Illuminate\Support\Facades\Artisan::output();
        
        // Then seed
        Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--force' => true
        ]);
        
        $seedOutput = Illuminate\Support\Facades\Artisan::output();
        
        return '<h2>✅ Database migrated successfully!</h2>' 
            . '<p>You can now login with your users.</p>'
            . '<p><a href="/">Go to Homepage</a></p>'
            . '<details><summary>Migration Output</summary><pre>' . htmlspecialchars($migrateOutput) . '</pre></details>'
            . '<details><summary>Seed Output</summary><pre>' . htmlspecialchars($seedOutput) . '</pre></details>';
    } catch (\Exception $e) {
        return '<h2>❌ Migration failed</h2>' 
            . '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>'
            . '<p><strong>File:</strong> ' . $e->getFile() . ':' . $e->getLine() . '</p>'
            . '<details><summary>Stack Trace</summary><pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre></details>';
    }
});