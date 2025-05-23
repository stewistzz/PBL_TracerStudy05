<?php

// database/migrations/2025_05_23_000007_create_profesi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('profesi', function (Blueprint $table) {
            $table->id('profesi_id');
            $table->string('nama_profesi', 50);
            $table->foreignId('kategori_id')->constrained('kategori_profesi', 'kategori_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('profesi');
    }
};
