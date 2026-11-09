<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsistenDosen;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // ADMIN — statistik global
        if ($user->hasRole('Admin')) {
            $stats = [
                'total_mahasiswa' => Mahasiswa::count(),
                'total_dosen' => Dosen::count(),
                'total_asdos' => AsistenDosen::count(),
            ];

            return view('admin.dashboard.admin', compact('stats'));
        }

        // DOSEN — nilai yang ia ampu
        if ($user->hasRole('Dosen')) {
            $dosen = $user->dosen;
            $nilais = Nilai::with(['mahasiswa', 'asistenDosen'])
                ->where('dosen_id', $dosen?->id)
                ->orderByDesc('semester')
                ->orderBy('mahasiswa_id')
                ->paginate(15);

            $stats = [
                'total_mahasiswa_dinilai' => $nilais->total(),
                'rata_rata' => round((clone $nilais)->avg('nilai_angka') ?? 0, 2),
                'jumlah_matkul' => Nilai::where('dosen_id', $dosen?->id)
                    ->distinct('mata_kuliah')
                    ->count('mata_kuliah'),
            ];

            return view('admin.dashboard.dosen', compact('nilais', 'stats', 'dosen'));
        }

        // ASISTEN DOSEN — nilai yang ia bantu ampu
        if ($user->hasRole('Asisten Dosen')) {
            $asdos = $user->asistenDosen;
            $nilais = Nilai::with(['mahasiswa', 'dosen'])
                ->where('asisten_dosen_id', $asdos?->id)
                ->orderByDesc('semester')
                ->orderBy('mahasiswa_id')
                ->paginate(15);

            $stats = [
                'total_mahasiswa_dinilai' => $nilais->total(),
                'rata_rata' => round((clone $nilais)->avg('nilai_angka') ?? 0, 2),
                'jumlah_matkul' => Nilai::where('asisten_dosen_id', $asdos?->id)
                    ->distinct('mata_kuliah')
                    ->count('mata_kuliah'),
            ];

            return view('admin.dashboard.asdos', compact('nilais', 'stats', 'asdos'));
        }

        // MAHASISWA — nilai milik sendiri
        $mahasiswa = $user->mahasiswa;
        $nilais = Nilai::with(['dosen', 'asistenDosen'])
            ->where('mahasiswa_id', $mahasiswa?->id)
            ->orderByDesc('semester')
            ->orderBy('mata_kuliah')
            ->get();

        $stats = [
            'total_matkul' => $nilais->count(),
            'ipk' => $this->hitungIpk($nilais),
            'rata_rata' => $nilais->avg('nilai_angka') !== null
                                ? round($nilais->avg('nilai_angka'), 2)
                                : 0,
        ];

        return view('admin.dashboard.mahasiswa', compact('nilais', 'stats', 'mahasiswa'));
    }

    public function hapusDemo(): RedirectResponse
    {
        $target = Mahasiswa::latest()->first();

        if (! $target) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Tidak ada data mahasiswa untuk dihapus.');
        }

        $target->user?->delete();
        $target->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', "Mahasiswa \"{$target->nama}\" berhasil dihapus.");
    }

    /** Hitung IPK sederhana: rata-rata bobot huruf. */
    private function hitungIpk($nilais): float
    {
        if ($nilais->isEmpty()) {
            return 0.0;
        }

        $bobot = [
            'A' => 4.0, 'AB' => 3.5, 'B' => 3.0,
            'BC' => 2.5, 'C' => 2.0, 'D' => 1.0, 'E' => 0.0,
        ];

        $total = 0.0;
        foreach ($nilais as $n) {
            $total += $bobot[$n->nilai_huruf] ?? 0.0;
        }

        return round($total / $nilais->count(), 2);
    }
}
