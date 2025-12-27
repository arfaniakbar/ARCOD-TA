<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('evidences', function (Blueprint $table) {
            // Mengubah tipe kolom dari STRING menjadi TEXT
            // TEXT dapat menampung hingga 65,535 karakter, cukup untuk JSON files
            $table->text('file_path')->change(); 

            // ATAU, jika database Anda mendukungnya (MySQL 5.7+ / PostgreSQL)
            // $table->json('file_path')->change(); 
        });
    }

    /**
     * Mengembalikan migrasi.
     */
    public function down(): void
    {
        Schema::table('evidences', function (Blueprint $table) {
            // Mengembalikan tipe kolom ke string (VARCHAR 255)
            $table->string('file_path')->change();
        });
    }
};