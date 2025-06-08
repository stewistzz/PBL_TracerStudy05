<?php

// database/migrations/2025_05_23_000008_create_tracer_study_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tracer_study', function (Blueprint $table) {
            $table->id('tracer_id');
            $table->foreignId('alumni_id')->constrained('alumni', 'alumni_id')->onDelete('cascade');
            $table->date('tanggal_pengisian');
            $table->date('tanggal_pertama_kerja')->nullable();
            $table->date('tanggal_mulai_kerja_instansi_saat_ini')->nullable();
            $table->foreignId('instansi_id')->constrained('instansi', 'instansi_id')->onDelete('cascade');
            $table->foreignId('kategori_profesi_id')->constrained('kategori_profesi', 'kategori_id')->onDelete('cascade');
            $table->foreignId('profesi_id')->constrained('profesi', 'profesi_id')->onDelete('cascade');
            $table->string('nama_atasan_langsung', 50);
            $table->string('jabatan_atasan_langsung', 100);
            $table->string('no_hp_atasan_langsung', 20)->nullable();
            $table->string('email_atasan_langsung', 255);
            $table->enum('status', ['draft', 'completed'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tracer_study');
    }
};