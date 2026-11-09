<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleAndPermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleAndPermissionSeeder::class);

        $admin = User::factory()->create(['email' => 'root@test.com']);
        $admin->assignRole('Admin');

        User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@test.com',
        ])->assignRole('Staf');

        User::factory()->create([
            'name' => 'Siti Aminah',
            'email' => 'siti@test.com',
        ])->assignRole('Staf');

        $this->actingAs($admin);
    }

    /** @test */
    public function pencarian_nama_menyaring_hasil(): void
    {
        $this->get('/admin/users?search=Budi')
            ->assertOk()
            ->assertSee('Budi Santoso')
            ->assertDontSee('Siti Aminah');
    }

    /** @test */
    public function pencarian_email_menyaring_hasil(): void
    {
        $this->get('/admin/users?search=siti@test.com')
            ->assertOk()
            ->assertSee('Siti Aminah')
            ->assertDontSee('Budi Santoso');
    }

    /** @test */
    public function filter_role_menyaring_hasil(): void
    {
        $this->get('/admin/users?role=Admin')
            ->assertOk()
            ->assertSee('root@test.com')
            ->assertDontSee('budi@test.com');
    }

    /** @test */
    public function pagination_mempertahankan_query_string(): void
    {
        // Buat banyak user agar paginasi aktif (10 per halaman)
        User::factory()->count(15)->create()->each(
            fn (User $u) => $u->assignRole('Staf')
        );

        $response = $this->get('/admin/users?search=test&page=2');
        $response->assertOk();
        // Pastikan link paginasi memuat parameter search=test
        $response->assertSee('search=test', false);
    }
}
