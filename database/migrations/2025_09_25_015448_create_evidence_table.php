<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidences', function (Blueprint $table) {
            $table->id();
            // 💡 PERBAIKAN: Gunakan kolom biasa (foreignId) dulu tanpa constraint.
            $table->foreignId('user_id'); 
            
            $table->string('lokasi');
            $table->text('deskripsi')->nullable();
            
            // 💡 PERBAIKAN: Mengubah tipe data kolom file_path ke TEXT
            $table->text('file_path'); 
            
            $table->timestamps();
            
            // 💡 CATATAN: foreign key akan ditambahkan di migrasi terpisah jika diperlukan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidences');
    }
};