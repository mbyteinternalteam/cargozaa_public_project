<?php

namespace Database\Factories;

use App\Models\Insurance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Insurance>
 */
class InsuranceFactory extends Factory
{
    protected $model = Insurance::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true).' Coverage',
            'slug' => $this->faker->unique()->slug(2),
            'description' => $this->faker->sentence(),
            'daily_rate' => $this->faker->randomFloat(2, 5, 50),
            'coverage_details' => [$this->faker->sentence()],
            'sort_order' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
