<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Paul Burdick',
            'email' => 'paul@reedmaniac.com',
            'password' => Hash::make('whatever'),
        ]);

        $this->call([
            TagsSeeder::class,
            CorporationSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
