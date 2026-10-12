<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BlokAsrama;
use App\Models\Kamar;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Buat Blok
        $blokA = BlokAsrama::create([
            'nama_blok' => 'Blok A (Reguler)',
            'deskripsi' => 'Blok asrama utama mahasiswi putri'
        ]);
        
        $blokB = BlokAsrama::create([
            'nama_blok' => 'Blok B (Senior)',
            'deskripsi' => 'Blok asrama mahasiswi senior'
        ]);

        // 2. Buat Kamar
        $kamar1 = Kamar::create([
            'blok_asrama_id' => $blokA->id,
            'nomor_kamar' => '101',
            'kapasitas' => 4
        ]);
        
        $kamar2 = Kamar::create([
            'blok_asrama_id' => $blokB->id,
            'nomor_kamar' => '201',
            'kapasitas' => 4
        ]);

        // 3. Buat Users
        // Admin / Pengurus
        User::create([
            'nama_lengkap' => 'Pengurus Asrama',
            'nomor_identitas' => 'PENGURUS-AMPT',
            'username' => 'admin',
            'password' => Hash::make('pengurus2026'),
            'role' => 'pengurus',
        ]);

        // Keamanan
        User::create([
            'nama_lengkap' => 'Petugas Keamanan',
            'nomor_identitas' => 'KEAMANAN-AMPT',
            'username' => 'keamanan',
            'password' => Hash::make('asrama2026'),
            'role' => 'keamanan',
        ]);

        // Penghuni Putri
        User::create([
            'nama_lengkap' => 'Nelice',
            'nomor_identitas' => 'MHS-001-TLK',
            'username' => 'nelice',
            'password' => Hash::make('asputri123'),
            'role' => 'penghuni',
            'kamar_id' => $kamar1->id,
            'status' => 'di_asrama'
        ]);
    }
}
