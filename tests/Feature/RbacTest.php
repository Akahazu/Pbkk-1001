<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);
    }

    /** @test */
    public function admin_bisa_mengakses_dashboard(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Total Mahasiswa');
    }

    /** @test */
    public function mahasiswa_tidak_bisa_hapus(): void
    {
        $mhs = User::factory()->create();
        $mhs->assignRole('Mahasiswa');

        $target = User::factory()->create();
        $target->assignRole('Mahasiswa');
        $m = Mahasiswa::create([
            'user_id' => $target->id,
            'nrp' => '502512340001',
            'nama' => 'Test Mhs',
            'departemen' => 'Teknik Informatika',
            'angkatan' => '2024',
            'is_active' => true,
        ]);

        $this->actingAs($mhs)
            ->delete("/admin/mahasiswa/{$m->id}")
            ->assertForbidden();
    }

    /** @test */
    public function admin_bisa_hapus_mahasiswa(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $target = User::factory()->create();
        $target->assignRole('Mahasiswa');
        $m = Mahasiswa::create([
            'user_id' => $target->id,
            'nrp' => '502512340002',
            'nama' => 'Target Mhs',
            'departemen' => 'Teknik Informatika',
            'angkatan' => '2024',
            'is_active' => true,
        ]);

        $this->actingAs($admin)
            ->delete("/admin/mahasiswa/{$m->id}")
            ->assertRedirect('/admin/mahasiswa');

        $this->assertDatabaseMissing('mahasiswas', ['id' => $m->id]);
    }

    /** @test */
    public function mahasiswa_yang_dihapus_tidak_bisa_login(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $target = User::factory()->create([
            'email' => 'target@test.com',
            'password' => bcrypt('password'),
        ]);
        $target->assignRole('Mahasiswa');

        $mhs = Mahasiswa::create([
            'user_id' => $target->id,
            'nrp' => '502599990001',
            'nama' => 'Target',
            'departemen' => 'Teknik Informatika',
            'angkatan' => '2024',
            'is_active' => true,
        ]);

        // Admin hapus
        $this->actingAs($admin)->delete("/admin/mahasiswa/{$mhs->id}");

        // Pastikan baris user hilang
        $this->assertDatabaseMissing('users', ['id' => $target->id]);
        $this->assertDatabaseMissing('mahasiswas', ['id' => $mhs->id]);

        // Coba login — harus gagal
        $this->post('/login', [
            'email' => 'target@test.com',
            'password' => 'password',
        ])->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function seeder_membuat_semua_role_dan_permission(): void
    {
        $this->seed(RoleAndPermissionSeeder::class);

        $this->assertDatabaseHas('roles', ['name' => 'Admin']);
        $this->assertDatabaseHas('roles', ['name' => 'Dosen']);
        $this->assertDatabaseHas('roles', ['name' => 'Asisten Dosen']);
        $this->assertDatabaseHas('roles', ['name' => 'Mahasiswa']);

        $this->assertDatabaseHas('permissions', ['name' => 'hapus-data']);
        $this->assertDatabaseHas('permissions', ['name' => 'kelola-mahasiswa']);

        // Admin punya semua
        $admin = Role::where('name', 'Admin')->first();
        $this->assertCount(6, $admin->permissions);
    }
}
