<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $commentableArray = [
            Article::class,
            Project::class,
        ];

        $commentableType = $this->faker->randomElement($commentableArray);

        $commentable = new $commentableType;

        return [
            'user_id' => User::all()->random()->id,
            'content' => $this->faker->text,
            'commentable_type' => $commentableType,
            'commentable_id' => $commentable->all()->random()->id,
            'deleted_at' => $this->faker->boolean(20) ? $this->faker->dateTime : null,
        ];
    }
}
