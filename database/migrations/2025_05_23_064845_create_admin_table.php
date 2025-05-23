<?php

// database/migrations/2025_05_23_000005_create_admin_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('admin', function (Blueprint $table) {
            $table->id('admin_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->unique()->onDelete('cascade');
            $table->string('nama', 50);
            $table->string('email', 50);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('admin');
    }
};