<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Audio;
use App\Models\User;

class AudioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Audio::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'path' => $this->faker->word(),
            'disk' => $this->faker->word(),
            'author' => $this->faker->word(),
            'duration' => $this->faker->randomNumber(),
            'cover_path' => $this->faker->word(),
            'cover_disk' => $this->faker->word(),
            'is_public' => $this->faker->boolean(),
            'user_id' => User::factory(),
        ];
    }
}
