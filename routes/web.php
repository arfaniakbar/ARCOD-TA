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
    $output = '<h2>🔄 Manual Migration Process</h2>';
    
    try {
        $output .= '<p>✓ Reading SQL file...</p>';
        $sqlFile = database_path('manual_migration.sql');
        $sql = file_get_contents($sqlFile);
        
        // Better SQL parsing: remove comments first, then split by semicolon
        $output .= '<p>✓ Parsing SQL statements...</p>';
        $lines = explode("\n", $sql);
        $cleanedLines = [];
        foreach ($lines as $line) {
            $line = trim($line);
            // Skip empty lines and comment-only lines
            if (empty($line) || str_starts_with($line, '--')) {
                continue;
            }
            $cleanedLines[] = $line;
        }
        $cleanSql = implode(' ', $cleanedLines);
        
        // Split by semicolon
        $statements = array_filter(array_map('trim', explode(';', $cleanSql)));
        
        $output .= '<p>  → Found ' . count($statements) . ' SQL statements</p>';
        $output .= '<p>✓ Executing SQL statements...</p>';
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($statements as $index => $statement) {
            if (empty($statement)) {
                continue;
            }
            
            try {
                Illuminate\Support\Facades\DB::statement($statement);
                $successCount++;
                
                // Log first 50 chars of successful statements
                $preview = substr($statement, 0, 50);
                $output .= "<p style='font-size:0.9em;color:green'>  ✓ [{$index}] " . htmlspecialchars($preview) . "...</p>";
            } catch (\Exception $e) {
                $errorCount++;
                $preview = substr($statement, 0, 50);
                $output .= "<p style='font-size:0.9em;color:orange'>  ✗ [{$index}] " . htmlspecialchars($preview) . "... - " . htmlspecialchars(substr($e->getMessage(), 0, 80)) . "</p>";
            }
        }
        
        $output .= "<p>✓ Executed {$successCount} statements successfully ({$errorCount} errors)</p>";
        
        // Check what tables were created
        $output .= '<p>✓ Checking created tables...</p>';
        $createdTables = Illuminate\Support\Facades\DB::select("SELECT tablename FROM pg_tables WHERE schemaname = 'public' ORDER BY tablename");
        $tableNames = array_map(fn($t) => $t->tablename, $createdTables);
        
        if (empty($tableNames)) {
            $output .= '<p style="color:red">  → No tables created!</p>';
        } else {
            $output .= '<p>  → Tables: ' . implode(', ', $tableNames) . '</p>';
        }
        
        // Then seed
        $output .= '<p>✓ Seeding database...</p>';
        try {
            Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--force' => true
            ]);
            $seedOutput = Illuminate\Support\Facades\Artisan::output();
            $output .= '<p>✓ Seeding completed</p>';
        } catch (\Exception $e) {
            $output .= "<p style='color:orange'>⚠ Seeding warning: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        
        $output .= '<h2>✅ Database setup completed!</h2>' 
            . '<p>You can now login with your users.</p>'
            . '<p><a href="/" style="background:#0070f3;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;display:inline-block;margin-top:10px;">Go to Homepage</a></p>';
            
        return $output;
    } catch (\Exception $e) {
        $output .= '<h2>❌ Migration failed</h2>' 
            . '<p><strong>Error:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>'
            . '<p><strong>File:</strong> ' . $e->getFile() . ':' . $e->getLine() . '</p>';
        return $output;
    }
});