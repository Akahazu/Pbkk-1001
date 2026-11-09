<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'lihat-dashboard',
            'kelola-mahasiswa',
            'kelola-nilai',
            'kelola-dosen',
            'kelola-asdos',
            'hapus-data',
        ];

        foreach ($permissions as $name) {
            Permission::firstOrCreate(['name' => $name]);
        }

        // Admin: akses penuh
        Role::firstOrCreate(['name' => 'Admin'])
            ->syncPermissions($permissions);

        // Dosen: kelola mahasiswa, nilai, dan lihat dosen/asdos (read)
        Role::firstOrCreate(['name' => 'Dosen'])
            ->syncPermissions(['lihat-dashboard', 'kelola-mahasiswa', 'kelola-nilai']);

        // Asisten Dosen: bantu kelola mahasiswa & nilai, tanpa hapus
        Role::firstOrCreate(['name' => 'Asisten Dosen'])
            ->syncPermissions(['lihat-dashboard', 'kelola-mahasiswa', 'kelola-nilai']);

        // Mahasiswa: hanya lihat dashboard
        Role::firstOrCreate(['name' => 'Mahasiswa'])
            ->syncPermissions(['lihat-dashboard']);
    }
}
