<?php
// database/migrations/2025_05_23_000011_create_survey_tokens_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('survey_tokens', function (Blueprint $table) {
            $table->id('token_id');
            $table->foreignId('pengguna_id')->constrained('pengguna_lulusan', 'pengguna_id')->onDelete('cascade');
            $table->string('token', 255)->unique();
            $table->dateTime('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('survey_tokens');
    }
};