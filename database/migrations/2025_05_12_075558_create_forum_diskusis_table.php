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
        Schema::create('forum_diskusis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program_relawans', 'id')->onDelete('cascade');
            $table->string('judul');
            $table->text('konten');
            $table->dateTime('tanggal_dibuat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_diskusis');
    }
};
