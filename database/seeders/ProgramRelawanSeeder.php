<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramRelawan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProgramRelawanSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user dulu
        $user = User::first() ?? User::factory()->create();

        // Simulasi 5 program relawan
        for ($i = 1; $i <= 5; $i++) {
            ProgramRelawan::create([
                'nama_program' => 'Program Relawan ' . $i,
                'category' => 'Kemanusiaan, Banjir',
                'deskripsi' => 'Deskripsi lengkap untuk program relawan ' . $i . '. ' . Str::random(100),
                'status' => ['Belum Mulai', 'Berlangsung', 'Selesai'][rand(0, 2)],
                'tanggal_mulai' => now()->addDays($i),
                'tanggal_selesai' => now()->addDays($i + 7),
                'user_id' => $user->id,
                'kontak' => '@pendidikan',
                'gambar' => 'image/relawan/sample' . $i . '.jpg',
            ]);
        }
    }
}
