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
        Schema::create('blog_artikels', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('lokasi');
            $table->text('konten');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->dateTime('tanggal_diterbitkan');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_artikels');
    }
};
