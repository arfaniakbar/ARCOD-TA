<?php

use Illuminate\Support\Facades\Route;

// Temporary route to drop cache tables
Route::get('/fix-cache', function () {
    try {
        Illuminate\Support\Facades\DB::statement('DROP TABLE IF EXISTS cache CASCADE');
        Illuminate\Support\Facades\DB::statement('DROP TABLE IF EXISTS cache_locks CASCADE');
        
        return '<h2>✅ Cache tables dropped successfully!</h2>'
            . '<p>Cache is now using array driver.</p>'
            . '<p><a href="/login">Go to Login</a></p>';
    } catch (\Exception $e) {
        return '<h2>❌ Error</h2><p>' . $e->getMessage() . '</p>';
    }
});

require __DIR__.'/auth.php';