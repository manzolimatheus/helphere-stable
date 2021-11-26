<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Institute;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_institute' => random_int(1,Institute::count()),
            'id_poster' => random_int(1, User::count()),
            'data'=> $this->faker->paragraph,
        ];
    }
}
