<?php

namespace Database\Seeders;

use App\Models\Audio;
use Illuminate\Database\Seeder;

class AudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Audio::factory()->count(5)->create();
    }
}
