<?php

namespace Database\Seeders;

use App\Models\AsistenDosen;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Nilai;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    public function run(): void
    {
        // Satu semester saja
        $semester = '2024/2025 Ganjil';

        $matkulList = ['PBKK', 'Pemrograman Web', 'Basis Data', 'Algoritma'];

        $dosens = Dosen::all();
        $asdos = AsistenDosen::all();
        $mhs = Mahasiswa::all();

        if ($dosens->isEmpty() || $mhs->isEmpty()) {
            return;
        }

        foreach ($mhs as $m) {
            foreach ($matkulList as $idx => $mk) {
                $dosen = $dosens[$idx % $dosens->count()];
                $asdosItem = $asdos->isNotEmpty() ? $asdos[$idx % $asdos->count()] : null;

                $angka = rand(40, 100);

                Nilai::firstOrCreate(
                    [
                        'mahasiswa_id' => $m->id,
                        'mata_kuliah' => $mk,
                        'semester' => $semester,
                    ],
                    [
                        'dosen_id' => $dosen->id,
                        'asisten_dosen_id' => $asdosItem?->id,
                        'nilai_angka' => $angka,
                        'nilai_huruf' => Nilai::hurufDariAngka($angka),
                    ]
                );
            }
        }
    }
}
