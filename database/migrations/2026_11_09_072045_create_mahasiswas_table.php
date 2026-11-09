<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('nrp', 20)->unique();
            $table->string('nama');
            $table->string('departemen')->default('Teknik Informatika');
            $table->string('angkatan', 4);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('nama');
            $table->index('nrp');
            $table->index('departemen');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
