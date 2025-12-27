<?php

use Illuminate\Support\Facades\Route;

// Temporary route to drop cache tables
Route::get('/fix-cache', function () {
    try {
        // Clear config cache first
        Illuminate\Support\Facades\Artisan::call('config:clear');
        Illuminate\Support\Facades\Artisan::call('cache:clear');
        
        // Drop cache tables
        Illuminate\Support\Facades\DB::statement('DROP TABLE IF EXISTS cache CASCADE');
        Illuminate\Support\Facades\DB::statement('DROP TABLE IF EXISTS cache_locks CASCADE');
        
        return '<h2>✅ Cache fixed successfully!</h2>'
            . '<p>Config cleared and cache tables dropped.</p>'
            . '<p>Cache is now using array driver (in-memory).</p>'
            . '<p><a href="/login" style="background:#0070f3;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;">Go to Login</a></p>';
    } catch (\Exception $e) {
        return '<h2>❌ Error</h2><p>' . $e->getMessage() . '</p>';
    }
});

require __DIR__.'/auth.php';