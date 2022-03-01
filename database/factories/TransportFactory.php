<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $car = ['ferari', 'mustang', 'carera'];
        $color = ['merah', 'kuning', 'hijau'];
        return [
            'merk' => $car[$this->faker->numberBetween(0, 2)],
            'warna' => $color[$this->faker->numberBetween(0, 2)],
            'jadwal_service' => $this->faker->date(),
            'konsumsi_bbm' => $this->faker->numberBetween(0, 5),
        ];
    }
}
