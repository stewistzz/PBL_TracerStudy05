<?php

// database/migrations/2025_05_23_000004_create_kategori_pertanyaan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kategori_pertanyaan', function (Blueprint $table) {
            $table->string('kode_kategori', 50)->primary();
            $table->string('nama_kategori', 100);
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kategori_pertanyaan');
    }
};