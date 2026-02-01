<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for Vacation model.
 *
 * @extends Factory<Vacation>
 */
class VacationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vacation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 week', '+3 months');
        $endDate = $this->faker->dateTimeBetween($startDate, '+6 months');

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'location' => $this->faker->city() . ', ' . $this->faker->country(),
            'price' => $this->faker->randomFloat(2, 200, 5000),
            'duration_days' => $this->faker->numberBetween(3, 21),
            'available_slots' => $this->faker->numberBetween(5, 50),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'featured' => $this->faker->boolean(20),
            'active' => $this->faker->boolean(90),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Set vacation as featured.
     *
     * @return static
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'featured' => true,
        ]);
    }

    /**
     * Set vacation as inactive.
     *
     * @return static
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'active' => false,
        ]);
    }
}
