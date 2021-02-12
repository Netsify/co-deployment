<?php

namespace Database\Factories;

use App\Models\Facilities\Proposal;
use App\Models\Project;
use App\Models\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(70),
            'description' => $this->faker->text,
            'identifier' => Str::random(8),
            'status_id' => ProjectStatus::all()->random()->id,
        ];
    }
}
