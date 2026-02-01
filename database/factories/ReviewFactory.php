<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for Review model.
 *
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(1, 5),
            'approved' => $this->faker->boolean(70),
            'user_id' => User::factory(),
            'vacation_id' => Vacation::factory(),
        ];
    }

    /**
     * Set review as approved.
     *
     * @return static
     */
    public function approved(): static
    {
        return $this->state(fn(array $attributes) => [
            'approved' => true,
        ]);
    }

    /**
     * Set review as pending approval.
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'approved' => false,
        ]);
    }
}
