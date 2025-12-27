<?php

namespace Database\Seeders; // <-- PASTIKAN BARIS INI ADA DAN BENAR

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder // <-- PASTIKAN NAMA CLASS-NYA BENAR
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Admin
        User::create([
            'name' => 'Admin Telkom',
            'username' => 'admin',
            'email' => 'admin@telkom.co.id',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'admin',
        ]);

        // User Karyawan
        User::create([
            'name' => 'Budi Karyawan',
            'username' => 'budi',
            'email' => 'budi@telkom.co.id',
            'password' => Hash::make('password'), // passwordnya: password
            'role' => 'karyawan',
        ]);
    }
}