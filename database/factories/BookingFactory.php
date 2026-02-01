<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Vacation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory for Booking model.
 *
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $numGuests = $this->faker->numberBetween(1, 6);
        $basePrice = $this->faker->randomFloat(2, 200, 2000);

        return [
            'num_guests' => $numGuests,
            'total_price' => $basePrice * $numGuests,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'notes' => $this->faker->optional()->sentence(),
            'user_id' => User::factory(),
            'vacation_id' => Vacation::factory(),
        ];
    }

    /**
     * Set booking as confirmed.
     *
     * @return static
     */
    public function confirmed(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Set booking as pending.
     *
     * @return static
     */
    public function pending(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'pending',
        ]);
    }
}
