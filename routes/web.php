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
    $output = '<h2>🔄 Migration Process</h2>';
    
    try {
        // Clear all caches first
        $output .= '<p>✓ Clearing caches...</p>';
        Illuminate\Support\Facades\Artisan::call('config:clear');
        Illuminate\Support\Facades\Artisan::call('cache:clear');
        
        // Get all table names
        $output .= '<p>✓ Fetching existing tables...</p>';
        $tables = Illuminate\Support\Facades\DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public'");
        
        // Drop all tables
        $output .= '<p>✓ Dropping ' . count($tables) . ' existing tables...</p>';
        foreach ($tables as $table) {
            Illuminate\Support\Facades\DB::statement("DROP TABLE IF EXISTS \"{$table->tablename}\" CASCADE");
        }
        
        // Run migrations one by one without transactions
        $output .= '<p>✓ Running migrations individually...</p>';
        
        $migrationFiles = [
            '0001_01_01_000001_create_cache_table.php',
            '0001_01_01_000002_create_jobs_table.php',
            '2025_09_25_015448_create_evidence_table.php',
            '2025_09_25_053205_add_status_to_evidences_table.php',
            '2025_10_23_005048_alter_file_path_column_on_evidences_table.php',
            '2025_10_26_110654_create_sessions_table.php',
        ];
        
        foreach ($migrationFiles as $file) {
            try {
                $output .= "<p>  → Running: {$file}</p>";
                $path = database_path('migrations/' . $file);
                if (file_exists($path)) {
                    $migration = include $path;
                    $migration->up();
                }
            } catch (\Exception $e) {
                $output .= "<p style='color:orange'>  ⚠ Warning in {$file}: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
        
        // Create migrations table manually
        $output .= '<p>✓ Creating migrations tracking table...</p>';
        Illuminate\Support\Facades\DB::statement("
            CREATE TABLE IF NOT EXISTS migrations (
                id SERIAL PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                batch INTEGER NOT NULL
            )
        ");
        
        // Insert migration records
        $batch = 1;
        foreach ($migrationFiles as $file) {
            $migrationName = str_replace('.php', '', $file);
            Illuminate\Support\Facades\DB::table('migrations')->insertOrIgnore([
                'migration' => $migrationName,
                'batch' => $batch
            ]);
        }
        
        // Then seed
        $output .= '<p>✓ Seeding database...</p>';
        Illuminate\Support\Facades\Artisan::call('db:seed', [
            '--force' => true
        ]);
        
        $seedOutput = Illuminate\Support\Facades\Artisan::output();
        
        $output .= '<h2>✅ Database migrated successfully!</h2>' 
            . '<p>You can now login with your users.</p>'
            . '<p><a href="/" style="background:#0070f3;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;display:inline-block;margin-top:10px;">Go to Homepage</a></p>'
            . '<details><summary>Seed Output</summary><pre>' . htmlspecialchars($seedOutput) . '</pre></details>';
            
        return $output;
    } catch (\Exception $e) {
        $output .= '<h2>❌ Migration failed</h2>' 
            . '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>'
            . '<p><strong>File:</strong> ' . $e->getFile() . ':' . $e->getLine() . '</p>'
            . '<details><summary>Stack Trace</summary><pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre></details>';
        return $output;
    }
});