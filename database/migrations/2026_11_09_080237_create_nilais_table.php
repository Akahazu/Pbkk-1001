<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('dosen_id')->constrained('dosens')->cascadeOnDelete();
            $table->foreignId('asisten_dosen_id')->nullable()->constrained('asisten_dosens')->nullOnDelete();
            $table->string('mata_kuliah');
            $table->string('semester', 10);
            $table->decimal('nilai_angka', 4, 2);
            $table->string('nilai_huruf', 2); // A, AB, B, BC, C, D, E
            $table->timestamps();

            $table->index('mata_kuliah');
            $table->index('semester');
            $table->unique(['mahasiswa_id', 'mata_kuliah', 'semester'], 'unique_nilai_mhs_mk');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
