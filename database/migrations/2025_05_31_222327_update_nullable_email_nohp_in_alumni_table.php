<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('alumni', function (Blueprint $table) {
            $table->string('email', 20)->nullable()->change();
            $table->string('no_hp', 20)->nullable()->change();
        });
    }

    public function down(): void {
        Schema::table('alumni', function (Blueprint $table) {
            $table->string('email', 20)->nullable(false)->change();
            $table->string('no_hp', 20)->nullable(false)->change();
        });
    }
};

