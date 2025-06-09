<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogArtikel;
use App\Models\User;
use Illuminate\Support\Str;

class BlogArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        for ($i = 1; $i <= 5; $i++) {
            BlogArtikel::create([
                'judul' => 'Judul Artikel ' . $i,
                'lokasi' => 'Kuningan, Jawa Barat',
                'konten' => Str::random(200),
                'user_id' => $user->id,
                'tanggal_diterbitkan' => now()->subDays($i),
                'gambar' => 'image/artikel/sample' . $i . '.jpg',
            ]);
        }
    }
}