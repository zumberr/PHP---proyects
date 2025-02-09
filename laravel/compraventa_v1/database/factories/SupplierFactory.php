<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Supplier::class;

    public function definition(): array
    {
        return [
            'ruc' => $this->faker->unique()->numerify('###########'),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'photo' => $this->faker->imageUrl(100,100,'people'),
            'status' => $this->faker->randomElement(['active','inactive']),
        ];
    }
}
