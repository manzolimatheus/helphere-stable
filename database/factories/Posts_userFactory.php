<?php

namespace Database\Factories;

use App\Models\Posts_user;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class Posts_userFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Posts_user::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_poster' => random_int(1,User::count()), 
            'data' => $this->faker->paragraph,
        ];
    }
}
