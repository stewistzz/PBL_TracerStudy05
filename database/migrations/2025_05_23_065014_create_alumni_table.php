<?php

// database/migrations/2025_05_23_000006_create_alumni_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id('alumni_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->unique()->onDelete('cascade');
            $table->string('nama', 50)->nullable(); // nullable
            $table->string('nim', 50)->unique()->nullable(); // nullable
            $table->string('email', 20);
            $table->string('no_hp', 20);
            $table->string('program_studi', 20)->nullable(); // nullable
            $table->date('tahun_lulus')->nullable(); // nullable
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('alumni');
    }
};

