<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PrincipalController extends Controller
{
    public function index()
    {

        $usuarios_qtd = DB::table('users')->count();
        $institutes_qtd = DB::table('institutes')->count();
        $instituteAjudados = DB::table('payments')->count(DB::raw('DISTINCT id_instituicao'));
        // Retorna view início como página principal
        return view('inicio', ['usuarios' => $usuarios_qtd, 'institutes' => $institutes_qtd, 'institutesAjudados' => $instituteAjudados]);
    }

    public function suporte()
    {
        // Retorna página de suporte
        return view('suporte');
    }

    public function dashboard()
    {

        $usuario = auth()->user(); //Coleta usuário autenticado

        $institutes = DB::table('institutes')
            ->inRandomOrder()
            ->join('category_institutes', 'id_categoria', '=', 'category_institutes.id')
            ->select('institutes.id', 'nome_instituicao', 'image', 'image_perfil', 'visualizacoes', 'categoria', 'id_categoria')
            ->take(10)
            ->get();

        $populares = DB::table('institutes')
            ->join('category_institutes', 'id_categoria', '=', 'category_institutes.id')
            ->select('institutes.id', 'nome_instituicao', 'image', 'image_perfil', 'visualizacoes', 'categoria')
            ->orderBy('visualizacoes', 'desc')
            ->take(6)
            ->get();

        $campanhas_populares = DB::table('campanhas')
            ->join('category_institutes', 'id_categoria', '=', 'category_institutes.id')
            ->select('campanhas.id', 'nome', 'img_path', 'visualizacoes', 'categoria')
            ->orderBy('visualizacoes', 'desc')
            ->take(6)
            ->get();

        $campanhas = DB::table('campanhas')
            ->inRandomOrder()
            ->join('category_institutes', 'id_categoria', '=', 'category_institutes.id')
            ->select('campanhas.id', 'nome', 'img_path', 'visualizacoes', 'categoria', 'id_categoria')
            ->take(10)
            ->get();

        $categorias_populares = DB::table('category_institutes')
            ->select('id', 'categoria', 'categoria_ingles')
            ->orderBy('visualizacoes_categoria', 'desc')
            ->take(10)
            ->get();


        // Retorna view dashboard
        return view('principais.geral.dashboard', ['usuario' => $usuario, 'institutes' => $institutes, 'populares' => $populares, 'categorias_populares' => $categorias_populares, 'campanhas_populares' => $campanhas_populares, 'campanhas' => $campanhas]);
    }

    public function gerenciar()
    {
        // Pega usuário autenticado
        $usuario = auth()->user();

        // Lista instituições onde o usuário autenticado é dono
        $institutes = DB::table('institutes')
            ->join('category_institutes', 'id_categoria', '=', 'category_institutes.id')
            ->select('institutes.id', 'nome_instituicao', 'image', 'image_perfil', 'visualizacoes', 'categoria', 'id_categoria')
            ->where('id_criador', '=', $usuario->id)
            ->orderBy('visualizacoes', 'desc')
            ->get();

        $campanhas = DB::table('campanhas')
            ->join('category_institutes', 'id_categoria', '=', 'category_institutes.id')
            ->select('campanhas.id', 'nome', 'img_path', 'visualizacoes', 'categoria', 'id_categoria')
            ->where('id_criador', '=', $usuario->id)
            ->orderBy('visualizacoes', 'desc')
            ->get();

        return view('principais.geral.gerenciar', ['institutes' => $institutes, 'campanhas' => $campanhas]);
    }

    public function config()
    {
        return view('profile.show');
    }
}
