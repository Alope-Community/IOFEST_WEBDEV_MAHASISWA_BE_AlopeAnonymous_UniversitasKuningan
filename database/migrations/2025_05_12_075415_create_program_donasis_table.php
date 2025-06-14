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
        Schema::create('program_donasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->string('category');
            $table->text('deskripsi');
            $table->string('status');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('kontak');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_donasis');
    }
};
