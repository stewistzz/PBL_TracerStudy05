<?php

// database/migrations/2025_05_23_000010_create_alumni_pengguna_lulusan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alumni_pengguna_lulusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna_lulusan', 'pengguna_id')->onDelete('cascade');

          $table->foreignId('alumni_id')->constrained('alumni', 'alumni_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alumni_pengguna_lulusan');
    }
};
