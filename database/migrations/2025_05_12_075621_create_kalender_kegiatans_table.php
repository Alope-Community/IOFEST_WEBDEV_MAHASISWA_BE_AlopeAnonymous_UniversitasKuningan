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
        Schema::create('kalender_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program_relawans', 'id')->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->dateTime('tanggal');
            $table->string('lokasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kalender_kegiatans');
    }
};
