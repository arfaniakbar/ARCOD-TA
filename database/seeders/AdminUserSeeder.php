<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        // Masukkan akun Admin Default
        DB::table('users')->insert([
            'name' => 'Admin Utama',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin', // Pastikan kolom 'role' sesuai dengan yang ada di migrasi
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Opsional: Buat satu user Karyawan default
        DB::table('users')->insert([
            'name' => 'Karyawan Uji',
            'username' => 'karyawan',
            'email' => 'karyawan@example.com',
            'password' => Hash::make('password'), // Password: password
            'role' => 'karyawan',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        echo "Akun Admin (admin@example.com) dan Karyawan (karyawan@example.com) berhasil dibuat.\n";
    }
}