<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\category_institute;
use Illuminate\Support\Facades\DB;

class OthersController extends Controller
{
    public function categoria($id)
    {
        // Selecionado de acordo com categoria
        $nome_categoria = category_institute::findOrFail($id);

        $qtd_institutes = DB::table('institutes')->where('id_categoria', '=', $id)->count();
        $qtd_campanhas = DB::table('campanhas')->where('id_categoria', '=', $id)->count();

        $institutes = DB::table('institutes')
            ->join('category_institutes', 'id_categoria', '=', 'category_institutes.id')
            ->select('nome_instituicao', 'image', 'image_perfil', 'categoria', 'visualizacoes', 'institutes.id')
            ->where('id_categoria', '=', $id)
            ->orderBy('visualizacoes', 'desc')
            ->paginate(20);

        $campanhas = DB::table('campanhas')
            ->join('category_institutes', 'id_categoria', '=', 'category_institutes.id')
            ->select('nome', 'img_path', 'categoria', 'visualizacoes', 'campanhas.id')
            ->where('id_categoria', '=', $id)
            ->orderBy('visualizacoes', 'desc')
            ->paginate(20);

        $outras_categorias = DB::table('category_institutes')
            ->inRandomOrder()
            ->select('id', 'categoria', 'categoria_ingles')
            ->where('id', '<>', $id)
            ->get();

        //+1 visualização para a categoria
        DB::table('category_institutes')->where('id', '=', $id)->increment('visualizacoes_categoria');

        return view('principais.geral.categoria', ['institutes' => $institutes, 'nome_categoria' => $nome_categoria, 'outras_categorias' => $outras_categorias, 'qtd_institutes' => $qtd_institutes, 'qtd_campanhas' => $qtd_campanhas, 'campanhas' => $campanhas]);
    }

    public function perfil($id)
    {

        // Puxa os dados do perfil
        $perfil = User::findOrFail($id);

        // Puxa as instituições do usuário
        $institutes = DB::table('institutes')
            ->where('id_criador', '=', $id)
            ->get();

        $campanhas = DB::table('campanhas')
            ->where('id_criador', '=', $id)
            ->get();

        $posts = DB::table('posts_users')
            ->where('id_poster', '=', $perfil->id)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return view('principais.usuario.perfil', ['perfil' => $perfil, 'institutes' => $institutes, 'posts' => $posts, 'campanhas' => $campanhas]);
    }
}
