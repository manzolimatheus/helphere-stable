<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denuncias_institute;
use App\Models\Denuncias_user;
use App\Models\Post;
use App\Models\Posts_user;
use Illuminate\Support\Facades\File;


class PostsController extends Controller
{
    public function post_user(Request $request)
    {

        // Cria novo instituto
        $post = new Posts_user();

        $usuario = auth()->id();

        // Coleta usuário autenticado para definir o dono
        $post->id_poster = $usuario;

        // Request dos dados do formulários
        $post->data = $request->data;

        // Upload de imagem, se não houver, ele usa uma imagem placeholder
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/users/posts'), $imageName);

            $post->image = "/img/users/posts/" . $imageName;
        }

        $post->save();

        return redirect(url()->previous())->with('msg', 'Post enviado com sucesso!');
    }

    public function post_institute(Request $request, $id)
    {

        // Cria novo instituto
        $post = new Post();

        $usuario = auth()->id();

        // Request dos dados do formulários
        $post->id_institute = $id;
        $post->id_poster = $usuario;
        $post->data = $request->data;

        // Upload de imagem, se não houver, ele usa uma imagem placeholder
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/institutes/posts'), $imageName);

            $post->image = "/img/institutes/posts/" . $imageName;
        }

        $post->save();

        return redirect(url()->previous())->with('msg', 'Post enviado com sucesso!');
    }

    public function post_delete($id)
    {

        // Encontra instituição pelo id
        $post = Post::findOrFail($id);


        if ($post->image != '') {
            // Encontra imagem do post
            File::delete(public_path($post->image));
        }

        $post->delete();

        return redirect(url()->previous())->with('msg', 'Post deletado com sucesso!');
    }

    public function post_user_delete($id)
    {

        // Encontra instituição pelo id
        $post = Posts_user::findOrFail($id);


        if ($post->image != '') {
            // Encontra imagem do post
            File::delete(public_path($post->image));
        }

        $post->delete();

        return redirect(url()->previous())->with('msg', 'Post deletado com sucesso!');
    }

    public function report_post_user($id)
    {
        $post = Posts_user::findOrFail($id);

        $denuncia = new Denuncias_user();

        $reclamante = auth()->id();
        $denunciado = $post->id_poster;

        $denuncia->id_reclamante = $reclamante;
        $denuncia->id_denunciado = $denunciado;
        $denuncia->id_post = $id;

        $denuncia->save();

        return redirect(url()->previous())->with('msg', 'Post reportado com sucesso!');
    }

    public function report_post_institute($id)
    {
        $post = Post::findOrFail($id);

        $denuncia = new Denuncias_institute();

        $reclamante = auth()->id();
        $denunciado = $post->id_poster;

        $denuncia->id_reclamante = $reclamante;
        $denuncia->id_denunciado = $denunciado;
        $denuncia->id_post = $id;

        $denuncia->save();

        return redirect(url()->previous())->with('msg', 'Post reportado com sucesso!');
    }
}