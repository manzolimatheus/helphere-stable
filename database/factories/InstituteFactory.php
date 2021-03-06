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
            'cnpj' => random_int(1,999999999),
            'nome_instituicao' =>  $this->faker->company,
            'id_criador' => random_int(1, User::count()),
            'id_categoria'=> random_int(1, category_institute::count()),
            'telefone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->unique()->companyEmail,
            'municipio' => $this->faker->city(),
            'uf' => $this->faker->stateAbbr(),
            'logradouro' => $this->faker->streetAddress,
            'pixKey' => random_int(1,999999999999999),
            'titular' => $this->faker->name(),
            'image' => "https://source.unsplash.com/featured/?".$this->faker->jobTitle,
            'image_perfil' => "https://source.unsplash.com/featured/?".$this->faker->firstName(),
            'descricao' => $this->faker->realText($maxNbChars = 240, $indexSize = 1),
            'visualizacoes' => 0,
        ];
    }
}
