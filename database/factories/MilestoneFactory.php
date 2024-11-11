<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class MilestoneFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(2),
            'deadline' => $this->faker->dateTimeBetween('now', '+1 month'),
            'progress' => $this->faker->numberBetween(0, 100),
            'project_id' => Project::factory(),
        ];
    }
}
