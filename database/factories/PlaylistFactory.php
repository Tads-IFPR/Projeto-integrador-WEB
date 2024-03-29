<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Playlist;

class PlaylistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Playlist::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'is_public' => $this->faker->boolean(),
            'cover_path' => $this->faker->word(),
            'cover_disk' => $this->faker->word(),
        ];
    }
}
