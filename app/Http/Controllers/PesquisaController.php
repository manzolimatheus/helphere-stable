<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use App\Models\User;
use App\Models\Post;
use App\Models\Posts_user;
use App\Models\Campanha;


class PesquisaController extends Controller
{

    public function pesquisar_institutes()
    {

        $pesquisa = request('q');

        $qtd_institutes = Institute::where([
            ['nome_instituicao', 'like', '%' . $pesquisa . '%']
        ])->count();

        $institutes = Institute::where([
            ['nome_instituicao', 'like', '%' . $pesquisa . '%']
        ])->paginate(20);


        // Retorna dashboard
        return view('principais.pesquisa.pesquisa_inst', ['institutes' => $institutes, 'pesquisa' => $pesquisa, 'qtd_institutes' => $qtd_institutes]);
    }

    public function pesquisar_campanha()
    {

        $pesquisa = request('q');

        $qtd_campanhas = Campanha::where([
            ['nome', 'like', '%' . $pesquisa . '%']
        ])->count();

        $campanhas = Campanha::where([
            ['nome', 'like', '%' . $pesquisa . '%']
        ])->paginate(20);


        // Retorna dashboard
        return view('principais.pesquisa.pesquisa_camp', ['campanhas' => $campanhas, 'pesquisa' => $pesquisa, 'qtd_campanhas' => $qtd_campanhas]);
    }

    public function pesquisar_pessoas()
    {

        $pesquisa = request('q');

        $qtd_usuarios = User::where([
            ['name', 'like', '%' . $pesquisa . '%']
        ])->count();

        $usuarios = User::where([
            ['name', 'like', '%' . $pesquisa . '%']
        ])->paginate(20);

        // Retorna dashboard
        return view('principais.pesquisa.pesquisa_pess', ['usuarios' => $usuarios, 'pesquisa' => $pesquisa, 'qtd_usuarios' => $qtd_usuarios]);
    }

    public function pesquisar_posts_users()
    {

        $pesquisa = request('q');

        $qtd_posts = Posts_user::where([
            ['data', 'like', '%' . $pesquisa . '%']
        ])->count();

        $posts_users = Posts_user::where([
            ['data', 'like', '%' . $pesquisa . '%']
        ])
            ->join('users', 'users.id', '=', 'posts_users.id_poster')
            ->select('posts_users.id_poster', 'users.name', 'users.profile_photo_path', 'posts_users.data', 'posts_users.id', 'posts_users.image', 'posts_users.created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        // Retorna dashboard
        return view('principais.pesquisa.pesquisa_posts_users', ['posts_users' => $posts_users, 'pesquisa' => $pesquisa, 'qtd_posts' => $qtd_posts]);
    }

    public function pesquisar_posts_institutes()
    {

        $pesquisa = request('q');

        $qtd_posts = Post::where([
            ['data', 'like', '%' . $pesquisa . '%']
        ])->count();

        $posts_institutes = Post::where([
            ['data', 'like', '%' . $pesquisa . '%']
        ])
            ->join('institutes', 'institutes.id', '=', 'id_institute')
            ->select('institutes.id', 'nome_instituicao', 'institutes.id_criador', 'institutes.image_perfil', 'posts.id', 'posts.data', 'posts.image', 'posts.created_at')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(30);

        // Retorna dashboard
        return view('principais.pesquisa.pesquisa_posts_institutes', ['posts_institutes' => $posts_institutes, 'pesquisa' => $pesquisa, 'qtd_posts' => $qtd_posts]);
    }

}
