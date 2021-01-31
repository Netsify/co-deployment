<?php

namespace Database\Factories;

use App\Models\Facilities\Proposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProposalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proposal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $users = User::all();

        return [
            'sender_id' => $users->random()->id,
            'receiver_id' => $users->random()->id,
            'accepted' => $this->faker->boolean(50) ? rand(0, 1) : null,
            'description' => $this->faker->text,
            'deleted_at' => $this->faker->boolean(20) ? $this->faker->dateTime : null,
        ];
    }
}
