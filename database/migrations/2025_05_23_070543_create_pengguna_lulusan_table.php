<?php

// database/migrations/2025_05_23_000009_create_pengguna_lulusan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengguna_lulusan', function (Blueprint $table) {
            $table->id('pengguna_id');
            $table->string('nama', 50);
            $table->string('instansi', 255);
            $table->string('jabatan', 100);
            $table->string('no_hp', 20);
            $table->string('email', 255);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengguna_lulusan');
    }
};
