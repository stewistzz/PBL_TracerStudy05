<?php

// database/migrations/2025_05_23_000003_create_kategori_profesi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kategori_profesi', function (Blueprint $table) {
            $table->id('kategori_id');
            $table->string('nama_kategori', 100);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kategori_profesi');
    }
};
