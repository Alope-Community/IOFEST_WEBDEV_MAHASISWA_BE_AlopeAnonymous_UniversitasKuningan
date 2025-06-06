<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramDonasi;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProgramDonasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->warn('Tidak ada user di database. Jalankan seeder user terlebih dahulu.');
            return;
        }

        ProgramDonasi::insert([
            [
                'nama_program' => 'Donasi Pendidikan Anak Yatim',
                'category' => 'Pendidikan',
                'deskripsi' => 'Bantu pendidikan anak-anak yatim dengan donasi terbaik Anda.',
                'status' => 'Berlangsung',
                'tanggal_mulai' => now()->subDays(10)->toDateString(),
                'tanggal_selesai' => now()->addDays(20)->toDateString(),
                'user_id' => $user->id,
                'gambar' => 'gambar_program/default1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_program' => 'Donasi Bencana Alam',
                'category' => 'Kemanusiaan',
                'deskripsi' => 'Donasi untuk membantu korban bencana alam di Indonesia.',
                'status' => 'Belum Mulai',
                'tanggal_mulai' => now()->addDays(5)->toDateString(),
                'tanggal_selesai' => now()->addDays(30)->toDateString(),
                'user_id' => $user->id,
                'gambar' => 'gambar_program/default2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
