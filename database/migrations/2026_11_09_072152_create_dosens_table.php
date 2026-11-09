<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('nip', 30)->unique();
            $table->string('nama');
            $table->string('departemen')->default('Teknik Informatika');
            $table->string('jabatan')->default('Dosen');
            $table->timestamps();

            $table->index('nama');
            $table->index('nip');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
