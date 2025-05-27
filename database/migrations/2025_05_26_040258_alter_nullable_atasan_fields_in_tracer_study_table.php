<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNullableAtasanFieldsInTracerStudyTable extends Migration
{
    public function up()
    {
        Schema::table('tracer_study', function (Blueprint $table) {
            $table->string('nama_atasan_langsung')->nullable()->change();
            $table->string('jabatan_atasan_langsung')->nullable()->change();
            $table->string('no_hp_atasan_langsung')->nullable()->change();
            $table->string('email_atasan_langsung')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tracer_study', function (Blueprint $table) {
            $table->string('nama_atasan_langsung')->nullable(false)->change();
            $table->string('jabatan_atasan_langsung')->nullable(false)->change();
            $table->string('no_hp_atasan_langsung')->nullable(false)->change();
            $table->string('email_atasan_langsung')->nullable(false)->change();
        });
    }
}
