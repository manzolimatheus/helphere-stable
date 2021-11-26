<?php

namespace Database\Factories;

use App\Models\Campanha;
use App\Models\User;
use App\Models\category_institute;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampanhaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campanha::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_criador' => random_int(1, User::count()),
            'nome' =>  $this->faker->company,
            'id_categoria'=> random_int(1, category_institute::count()),
            'telefone' => $this->faker->e164PhoneNumber,
            'email' => $this->faker->unique()->companyEmail,
            'endereco' => $this->faker->streetAddress,
            'data_fim' => $this->faker->date(),
            'img_path' => "https://source.unsplash.com/featured/?".$this->faker->jobTitle,
            'cidade' => $this->faker->city(),
            'pixKey' => random_int(1,9999999),
            'titular' => $this->faker->name(),
            'descricao' => $this->faker->realText($maxNbChars = 240, $indexSize = 1),
            'visualizacoes' => 0,
        ];
    }
}
