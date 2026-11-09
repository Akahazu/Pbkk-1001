<?php

use App\Http\Controllers\Admin\AsistenDosenController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:Admin|Dosen|Asisten Dosen|Mahasiswa'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::delete('/hapus-demo', [DashboardController::class, 'hapusDemo'])
            ->name('hapus-demo')
            ->middleware('permission:hapus-data');

        // Mahasiswa: Admin, Dosen, Asdos boleh lihat; hanya Admin hapus
        Route::middleware('permission:kelola-mahasiswa')->group(function () {
            Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        });
        Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])
            ->name('mahasiswa.destroy')
            ->middleware('permission:hapus-data');

        // Dosen: hanya Admin
        Route::middleware('permission:kelola-dosen')->group(function () {
            Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
        });
        Route::delete('/dosen/{dosen}', [DosenController::class, 'destroy'])
            ->name('dosen.destroy')
            ->middleware('permission:hapus-data');

        // Asdos: hanya Admin
        Route::middleware('permission:kelola-asdos')->group(function () {
            Route::get('/asdos', [AsistenDosenController::class, 'index'])->name('asdos.index');
        });
        Route::delete('/asdos/{asdos}', [AsistenDosenController::class, 'destroy'])
            ->name('asdos.destroy')
            ->middleware('permission:hapus-data');
    });

// Auto-login demo
Route::post('/demo-login/{role}', function (string $role) {
    $emails = [
        'admin' => 'admin@test.com',
        'dosen' => 'dosen1@its.ac.id',
        'asdos' => 'asdos1@student.its.ac.id',
        'mhs' => 'mhs1@student.its.ac.id',
    ];

    abort_unless(isset($emails[$role]), 404);

    $user = User::where('email', $emails[$role])->firstOrFail();
    Auth::login($user);
    request()->session()->regenerate();

    return redirect()->route('admin.dashboard');
})->name('demo.login');

require __DIR__.'/auth.php';
