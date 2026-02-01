<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\Vacation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for Photo model.
 *
 * @extends Factory<Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Photo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => 'vacations/' . $this->faker->uuid() . '.jpg',
            'original_name' => $this->faker->word() . '.jpg',
            'is_main' => false,
            'vacation_id' => Vacation::factory(),
        ];
    }

    /**
     * Set photo as main image.
     *
     * @return static
     */
    public function main(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_main' => true,
        ]);
    }
}
