<?php

namespace Database\Seeders;

use App\Models\AsistenDosen;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@test.com'],
            ['name' => 'Admin Test', 'password' => bcrypt('password')]
        );
        $admin->assignRole('Admin');

        // 5 Dosen
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Dosen {$i}",
                'email' => "dosen{$i}@its.ac.id",
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('Dosen');
            Dosen::create([
                'user_id' => $user->id,
                'nip' => '1980'.str_pad((string) $i, 14, '0', STR_PAD_LEFT),
                'nama' => $user->name,
                'departemen' => 'Teknik Informatika',
                'jabatan' => 'Lektor',
            ]);
        }

        // 3 Asisten Dosen
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'name' => "Asdos {$i}",
                'email' => "asdos{$i}@student.its.ac.id",
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('Asisten Dosen');
            AsistenDosen::create([
                'user_id' => $user->id,
                'dosen_id' => Dosen::inRandomOrder()->first()?->id,
                'nrp' => '502524'.str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                'nama' => $user->name,
                'mata_kuliah' => 'PBKK',
            ]);
        }

        // 20 Mahasiswa
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => "Mahasiswa {$i}",
                'email' => "mhs{$i}@student.its.ac.id",
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('Mahasiswa');
            Mahasiswa::create([
                'user_id' => $user->id,
                'nrp' => '502525'.str_pad((string) (100 + $i), 4, '0', STR_PAD_LEFT),
                'nama' => $user->name,
                'departemen' => 'Teknik Informatika',
                'angkatan' => '2025',
                'is_active' => $i % 4 !== 0,
            ]);
        }
    }
}
