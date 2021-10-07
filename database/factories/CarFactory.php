<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'brand_id' => Brand::factory(),
            'name' => $this->faker->word,
            'created_by' => User::factory()
        ];
    }
}
