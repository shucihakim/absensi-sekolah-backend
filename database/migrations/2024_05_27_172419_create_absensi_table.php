<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_murid');
            $table->integer('id_jurnal');
            $table->integer('id_kelas');
            $table->enum('keterangan', ['H', 'S', 'I', 'A'])->default('H');
            $table->string('foto');
            $table->timestamp('waktu')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
