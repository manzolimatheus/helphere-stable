<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            [
                'categoria' => 'Animais',
                'categoria_ingles' => 'Animals',
            ],
            [
                'categoria' => 'Moradores de rua',
                'categoria_ingles' => 'Homeless',
            ],
            [
                'categoria' => 'Idosos',
                'categoria_ingles' => 'Elderly',
            ],
            [
                'categoria' => 'LGBT',
                'categoria_ingles' => 'lgbt',
            ],
            [
                'categoria' => 'Outros',
                'categoria_ingles' => 'Other',
            ]
        ];

        DB::table('category_institutes')->insert($categorias);

        /*
        \App\Models\User::factory(100)->create();
        \App\Models\Institute::factory(100)->create();
        \App\Models\Post::factory(500)->create();
        \App\Models\Posts_user::factory(100)->create();
        */
    }
}
