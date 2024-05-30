<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('logo')->nullable();
            $table->decimal('garis_lintang', 10, 7)->nullable();
            $table->decimal('garis_bujur', 10, 7)->nullable();
            $table->string('penanda')->nullable();
            $table->integer('jarak')->nullable();
            $table->integer('id_semester_aktif')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};
