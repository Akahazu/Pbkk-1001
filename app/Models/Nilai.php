<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'asisten_dosen_id',
        'mata_kuliah',
        'semester',
        'nilai_angka',
        'nilai_huruf',
    ];

    protected $casts = [
        'nilai_angka' => 'float',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class);
    }

    public function asistenDosen(): BelongsTo
    {
        return $this->belongsTo(AsistenDosen::class);
    }

    /** Konversi angka ke huruf. */
    public static function hurufDariAngka(float $angka): string
    {
        return match (true) {
            $angka >= 85 => 'A',
            $angka >= 75 => 'AB',
            $angka >= 70 => 'B',
            $angka >= 60 => 'BC',
            $angka >= 55 => 'C',
            $angka >= 40 => 'D',
            default => 'E',
        };
    }
}
