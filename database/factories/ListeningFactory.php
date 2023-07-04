<?php

namespace Database\Factories;

use App\Models\Enregistrement;
use App\Models\Listening;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListeningFactory extends Factory
{
    protected $model = Listening::class;

    public function definition(): array
    {
        $recordsMaxId = Enregistrement::max('id');

        return [
            'uuid' => $this->faker->uuid(),
            'enregistrement_id' => $this->faker->numberBetween(1, $recordsMaxId),
            'ip_address' => $this->faker->ipv4(),
            'created_at' => $this->faker->dateTimeBetween(now()->subDays(), now()),
            'updated_at' => $this->faker->dateTimeBetween(now()->subDays(), now()),
        ];
    }
}
