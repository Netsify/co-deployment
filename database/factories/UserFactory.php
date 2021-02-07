<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $email = $this->faker->unique()->safeEmail;

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role_id' => rand(2, 4),
            'email' => $email,
            'photo_path' => null,
            'phone' => $this->faker->phoneNumber,
            'organization' => $this->faker->company,
            'summary' => $this->faker->text,
            'email_verified_at' => now(),
            'password' => Hash::make($email),
            'remember_token' => Str::random(10),
            'last_activity_at' => $this->faker->boolean(20) ? $this->faker->dateTime : null,
            'active' => $this->faker->boolean(20) ? 0 : 1,
            'deleted_at' => $this->faker->boolean(20) ? $this->faker->dateTime : null,
        ];
    }
}
