<?php

// database/migrations/2025_05_23_000014_create_jawaban_alumni_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jawaban_alumni', function (Blueprint $table) {
            $table->id('jawaban_id');
            $table->foreignId('alumni_id')->constrained('alumni', 'alumni_id')->onDelete('cascade');
            $table->foreignId('pertanyaan_id')->constrained('pertanyaan', 'pertanyaan_id')->onDelete('cascade');
            $table->text('jawaban');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('jawaban_alumni');
    }
};
