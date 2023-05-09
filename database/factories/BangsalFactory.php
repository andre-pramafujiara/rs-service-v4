<?php

namespace Database\Factories;

use App\Models\Bangsal;
use Illuminate\Database\Eloquent\Factories\Factory;

class BangsalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bangsal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'user_id' => rand(1, 150),
        ];
    }
}
