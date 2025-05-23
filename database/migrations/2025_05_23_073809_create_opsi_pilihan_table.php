<?php

// database/migrations/2025_05_23_000013_create_opsi_pilihan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('opsi_pilihan', function (Blueprint $table) {
            $table->id('opsi_id');
            $table->foreignId('pertanyaan_id')->constrained('pertanyaan', 'pertanyaan_id')->onDelete('cascade');
            $table->string('isi_opsi', 255);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('opsi_pilihan');
    }
};
