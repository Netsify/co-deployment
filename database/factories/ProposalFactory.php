<?php

namespace Database\Factories;

use App\Models\Facilities\Proposal;
use App\Models\Facilities\ProposalStatus;
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
            'status_id' => ProposalStatus::all()->random()->id,
            'description' => $this->faker->text,
            'deleted_at' => $this->faker->boolean(20) ? $this->faker->dateTime : null,
        ];
    }
}
