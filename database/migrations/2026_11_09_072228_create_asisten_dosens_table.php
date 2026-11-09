<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asisten_dosens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('dosen_id')->nullable()->constrained('dosens')->nullOnDelete();
            $table->string('nrp', 20)->unique();
            $table->string('nama');
            $table->string('mata_kuliah')->nullable();
            $table->timestamps();

            $table->index('nama');
            $table->index('nrp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asisten_dosens');
    }
};
