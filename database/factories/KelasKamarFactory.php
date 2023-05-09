<?php

namespace Database\Factories;

use App\Models\KelasKamar;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasKamarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = KelasKamar::class;

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
            'harga' => $this->faker->randomFloat,
            'BPJS' => 'BPJS',
            'SIRANAP' => 'SIRANAP',
            'SPGDT' => 'SPGDT',
            'user_id' => rand(1, 150),
        ];
    }
}