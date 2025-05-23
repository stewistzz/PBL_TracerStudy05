<?php

// database/migrations/2025_05_23_000012_create_pertanyaan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
    Schema::create('pertanyaan', function (Blueprint $table) {
    $table->id('pertanyaan_id');
    $table->enum('role_target', ['alumni', 'pengguna']);
    $table->text('isi_pertanyaan');
    $table->enum('jenis_pertanyaan', ['isian', 'pilihan_ganda', 'skala', 'ya_tidak']);
    $table->foreignId('created_by')->constrained('admin', 'admin_id')->onDelete('cascade');
    $table->string('kode_kategori', 50);
    $table->foreign('kode_kategori')->references('kode_kategori')->on('kategori_pertanyaan')->onDelete('cascade');
    $table->timestamps();
});

    }

    public function down(): void {
        Schema::dropIfExists('pertanyaan');
    }
};
