<?php

namespace Database\Factories;

use App\Models\Institute;
use App\Models\User;
use App\Models\category_institute;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstituteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Institute::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome_instituicao' =>  $this->faker->company,
            'id_criador' => random_int(1, User::count()),
            'id_categoria'=> random_int(1, category_institute::count()),
            'telefone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'endereco' => $this->faker->address,
            'image' => $this->faker->imageUrl($width = 800, $height = 300),
            'image_perfil' => $this->faker->imageUrl($width = 200, $height = 200),
            'descricao' => $this->faker->realText($maxNbChars = 240, $indexSize = 1),
            'visualizacoes' => 0,

        ];
    }
}
