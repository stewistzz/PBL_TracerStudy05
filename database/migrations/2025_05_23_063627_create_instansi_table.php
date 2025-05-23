<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('instansi', function (Blueprint $table) {
            $table->id('instansi_id');
            $table->string('nama_instansi', 50);
            $table->enum('jenis_instansi', ['Pendidikan Tinggi', 'Pemerintah', 'Swasta', 'BUMN']);
            $table->enum('skala', ['nasional', 'internasional', 'wirausaha']);
            $table->string('lokasi', 100);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('instansi');
    }
};