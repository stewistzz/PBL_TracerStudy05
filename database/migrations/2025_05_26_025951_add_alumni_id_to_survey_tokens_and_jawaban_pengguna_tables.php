<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tambah kolom alumni_id ke survey_tokens
        if (!Schema::hasColumn('survey_tokens', 'alumni_id')) {
            Schema::table('survey_tokens', function (Blueprint $table) {
                $table->unsignedBigInteger('alumni_id')->after('pengguna_id');
                $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');
            });
        }

        // Tambah kolom alumni_id ke jawaban_pengguna
        if (!Schema::hasColumn('jawaban_pengguna', 'alumni_id')) {
            Schema::table('jawaban_pengguna', function (Blueprint $table) {
                $table->unsignedBigInteger('alumni_id')->after('pengguna_id');
                $table->foreign('alumni_id')->references('alumni_id')->on('alumni')->onDelete('cascade');
            });
        }
    }

    public function down(): void {
        Schema::table('survey_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('survey_tokens', 'alumni_id')) {
                $table->dropForeign(['alumni_id']);
                $table->dropColumn('alumni_id');
            }
        });

        Schema::table('jawaban_pengguna', function (Blueprint $table) {
            if (Schema::hasColumn('jawaban_pengguna', 'alumni_id')) {
                $table->dropForeign(['alumni_id']);
                $table->dropColumn('alumni_id');
            }
        });
    }
};
