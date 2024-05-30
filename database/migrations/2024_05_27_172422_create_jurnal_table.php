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
        Schema::create('jurnal', function (Blueprint $table) {
            $table->id();
            $table->integer('id_semester');
            $table->integer('id_kelas');
            $table->integer('id_mapel');
            $table->integer('id_guru');
            $table->enum('keterangan', ['S', 'I', 'A']);
            $table->time('jam_masuk');
            $table->time('jam_keluar');
            $table->string('materi');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal');
    }
};
