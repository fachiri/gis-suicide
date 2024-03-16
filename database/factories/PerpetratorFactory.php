<?php

namespace Database\Factories;

use App\Constants\UserGender;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerpetratorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement([UserGender::MALE, UserGender::FEMALE]),
            'age' => $this->faker->numberBetween(18, 80),
            'education' => $this->faker->randomElement(['Tidak Sekolah', 'SD', 'SMP', 'SMA']),
            'address' => $this->faker->address,
            'marital_status' => $this->faker->randomElement(['Belum Menikah', 'Sudah Menikah']),
            'occupation' => $this->faker->jobTitle,
            'incident_date' => $this->faker->dateTimeBetween('2020-01-01', 'now')->format('Y-m-d'),
            'suicide_method' => $this->faker->randomElement(['Hanging', 'Drug overdose', 'Self-poisoning', 'Jumping']),
            'suicide_tool' => $this->faker->randomElement(['Rope', 'Pills', 'Knife', 'Gun']),
            'description' => $this->faker->sentence,
            'latitude' => $this->faker->unique()->randomFloat(8, 0.3, 0.8), // Adjust the range as needed
            'longitude' => $this->faker->unique()->randomFloat(8, 121.8, 123.5), // Adjust the range as needed
        ];
    }
}
