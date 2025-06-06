<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        User::create([
            'name' => 'admin',
            'email' => 'admin@alope.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'point' => 0,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Komunitas Peduli Alam',
            'email' => 'komunitas@pijarnusantara.com',
            'password' => Hash::make('komunitas123'),
            'role' => 'komunitas',
            'point' => 120,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // 10 user biasa dengan data acak
        foreach (range(1, 10) as $i) {
            User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('user123'),
                'role' => 'user',
                'point' => $faker->numberBetween(0, 100),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
