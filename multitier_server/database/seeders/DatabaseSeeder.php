<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Utama dengan Username = NIM (Ketentuan No. 4)
        $adminUser = User::updateOrCreate(
            ['email' => '25k10003@student.unika.ac.id'],
            [
                'name' => 'Dustin Christian Basuki',
                'username' => '25.K1.0003',
                'nim' => '25.K1.0003',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'avatar' => 'uploads/profile_dustin.png',
            ],
        );

      

        // Akun admin@pos.test untuk backward compatibility
        User::updateOrCreate(
            ['email' => 'admin@pos.test'],
            [
                'name' => 'Dustin Christian Basuki',
                'username' => 'admin',
                'nim' => '25.K1.0003',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'avatar' => 'uploads/profile_dustin.png',
            ],
        );
        
        $userMhs2 = User::updateOrCreate(
            ['email' => '25k10045@student.unika.ac.id'],
            [
                'name' => 'Parlindungan Sinaga',
                'username' => '25.K1.0045',
                'nim' => '25.K1.0045',
                'password' => Hash::make('password'),
                'role' => 'mahasiswa',
                'avatar' => 'uploads/profile_dustin.png',
            ]
        );

        User::updateOrCreate(
            ['email' => 'dosen@unika.ac.id'],
            [
                'name'     => 'Dr. Budi Santoso, M.Kom',
                'username' => 'dosen',
                'nim'      => 'DOSEN001',
                'password' => Hash::make('password'),
                'role'     => 'dosen',
                'avatar'   => 'uploads/profile_dustin.png',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@pos.test'],
            ['name' => 'Kasir 1', 'username' => 'kasir', 'nim' => 'kasir', 'password' => Hash::make('password'), 'role' => 'operator', 'avatar' => 'uploads/profile_dustin.png'],
        );

        $items = [
            ['nama' => 'Indomie Goreng', 'qty' => 100, 'price' => 3500],
            ['nama' => 'Aqua 600ml', 'qty' => 50, 'price' => 4000],
            ['nama' => 'Kopi Kapal Api Sachet', 'qty' => 80, 'price' => 2000],
            ['nama' => 'Roti Tawar Sari Roti', 'qty' => 20, 'price' => 17000],
            ['nama' => 'Gula Pasir 1kg', 'qty' => 30, 'price' => 18000],
        ];

        foreach ($items as $item) {
            Barang::updateOrCreate(['nama' => $item['nama']], $item);
        }

        // SiAkad - Matakuliah
        $mk1 = \App\Models\Matakuliah::updateOrCreate(
            ['kode_mk' => 'MK001'],
            ['nama_mk' => 'Pemrograman Web', 'sks' => 3, 'semester' => 3]
        );
        $mk2 = \App\Models\Matakuliah::updateOrCreate(
            ['kode_mk' => 'MK002'],
            ['nama_mk' => 'Basis Data Lanjut', 'sks' => 3, 'semester' => 3]
        );
        $mk3 = \App\Models\Matakuliah::updateOrCreate(
            ['kode_mk' => 'MK003'],
            ['nama_mk' => 'Arsitektur Komputer', 'sks' => 3, 'semester' => 3]
        );

        // SiAkad - Mahasiswa (Ketentuan No. 5: path foto profil string tersimpan di DB)
        $mhs1 = \App\Models\Mahasiswa::updateOrCreate(
            ['nim' => '25.K1.0003'],
            [
                'user_id' => $adminUser->id,
                'nama' => 'Dustin Christian Basuki',
                'angkatan' => 2025,
                'email' => '25k10003@student.unika.ac.id',
                'foto' => 'uploads/profile_dustin.png',
            ]
        );
        $mhs2 = \App\Models\Mahasiswa::updateOrCreate(
            ['nim' => '25.K1.0045'],
            [
                'user_id' => $userMhs2->id,
                'nama' => 'Parlindungan Sinaga',
                'angkatan' => 2025,
                'email' => '25k10045@student.unika.ac.id',
                'foto' => 'uploads/profile_dustin.png',
            ]
        );

        // SiAkad - Nilai
        \App\Models\Nilai::updateOrCreate(
            ['mahasiswa_id' => $mhs1->id, 'matakuliah_id' => $mk1->id],
            ['nilai_angka' => 95.0, 'nilai_huruf' => 'A']
        );
        \App\Models\Nilai::updateOrCreate(
            ['mahasiswa_id' => $mhs1->id, 'matakuliah_id' => $mk2->id],
            ['nilai_angka' => 90.0, 'nilai_huruf' => 'A']
        );
        \App\Models\Nilai::updateOrCreate(
            ['mahasiswa_id' => $mhs2->id, 'matakuliah_id' => $mk1->id],
            ['nilai_angka' => 88.0, 'nilai_huruf' => 'A-']
        );
    }
}
