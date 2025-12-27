<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LegacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data dari project_magang.sql (Users)
        DB::table('users')->insertOrIgnore([
            [
                'id' => 1,
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => null,
                'password' => '$2y$12$IxZpWPWS6OnIyVNq4oTQheUQnw58OFBm8LCi44Xzv3V5JBo0nfC3q', // admin
                'role' => 'admin',
                'created_at' => '2025-10-09 18:32:43',
                'updated_at' => '2025-10-09 18:32:43',
            ],
            [
                'id' => 2,
                'name' => 'Budi Karyawan',
                'username' => 'budi',
                'email' => 'budi@telkom.co.id',
                'email_verified_at' => null,
                'password' => '$2y$12$8frjFPX8iZbD2FBwWmBdIuZ63KTFBBOYupkSeSw7ctsEXyXN6BvNi',
                'role' => 'karyawan',
                'created_at' => '2025-10-09 18:32:44',
                'updated_at' => '2025-10-09 18:32:44',
            ],
            [
                'id' => 3,
                'name' => 'Muhammad Riza',
                'username' => 'riza',
                'email' => 'muhammadrizaaa594@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$IRnPuhrdur94FbghckclWuSccBRKlwml0AKMULcmHXNmP6abcZdXC',
                'role' => 'karyawan',
                'created_at' => '2025-10-09 18:40:23',
                'updated_at' => '2025-10-09 18:40:23',
            ],
            [
                'id' => 4,
                'name' => 'Lionel Messi',
                'username' => 'goat',
                'email' => 'messi@telkom.com',
                'email_verified_at' => null,
                'password' => '$2y$12$GeYg8LwjHu8vmOFqdk6om.T/t2k5.mUnRpX2jqbAMSwIqlkvHFs9O',
                'role' => 'karyawan',
                'created_at' => '2025-10-21 18:54:48',
                'updated_at' => '2025-10-21 18:54:48',
            ],
            [
                'id' => 5,
                'name' => 'Ahmad Fikriannor',
                'username' => 'Fikri',
                'email' => 'ahmadfikriannor@gmail.com',
                'email_verified_at' => null,
                'password' => '$2y$12$TI7hgBWZJ4ylrqyk0PWQEOlPhIE9EL2grgn2gM1fDdvm68n6l/.yW',
                'role' => 'karyawan',
                'created_at' => '2025-11-11 23:24:53',
                'updated_at' => '2025-11-11 23:24:53',
            ],
        ]);
        
        // Anda bisa menambahkan tabel lain di sini jika perlu
    }
}
