<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('jawaban_pengguna', function (Blueprint $table) {
            $table->foreign('alumni_id')
                ->references('alumni_id')
                ->on('alumni')
                ->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('jawaban_pengguna', function (Blueprint $table) {
            $table->dropForeign(['alumni_id']);
        });
    }
};
