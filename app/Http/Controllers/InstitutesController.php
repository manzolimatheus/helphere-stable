<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Institute;
use App\Models\Payment;
use App\Models\Payment_campanha;
use App\Models\User;
use App\Models\Denuncias_institute;
use App\Models\Denuncias_user;
use App\Models\category_institute;
use App\Models\entradaMensagem;
use App\Models\Post;
use App\Models\Posts_user;
use App\Models\Campanha;
use BaconQrCode\Renderer\Color\Rgb;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class InstitutesController extends Controller
{
    public function index()
    {

        $usuarios_qtd = DB::table('users')->count();
        $institutes_qtd = DB::table('institutes')->count();
        // Retorna view início como página principal
        return view('inicio', ['usuarios' => $usuarios_qtd, 'institutes' => $institutes_qtd]);
    }

    public function suporte()
    {
        // Retorna página de suporte
        return view('suporte');
    }

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
        return view('principais.pesquisa_inst', ['institutes' => $institutes, 'pesquisa' => $pesquisa, 'qtd_institutes' => $qtd_institutes]);
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
        return view('principais.pesquisa_camp', ['campanhas' => $campanhas, 'pesquisa' => $pesquisa, 'qtd_campanhas' => $qtd_campanhas]);
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
        return view('principais.pesquisa_pess', ['usuarios' => $usuarios, 'pesquisa' => $pesquisa, 'qtd_usuarios' => $qtd_usuarios]);
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
            ->select('users.id', 'users.name', 'users.profile_photo_path', 'posts_users.data', 'posts_users.image', 'posts_users.created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        // Retorna dashboard
        return view('principais.pesquisa_posts_users', ['posts_users' => $posts_users, 'pesquisa' => $pesquisa, 'qtd_posts' => $qtd_posts]);
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
            ->select('institutes.id', 'nome_instituicao', 'institutes.image_perfil', 'posts.data', 'posts.image', 'posts.created_at')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(30);

        // Retorna dashboard
        return view('principais.pesquisa_posts_institutes', ['posts_institutes' => $posts_institutes, 'pesquisa' => $pesquisa, 'qtd_posts' => $qtd_posts]);
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
        return view('principais.dashboard', ['usuario' => $usuario, 'institutes' => $institutes, 'populares' => $populares, 'categorias_populares' => $categorias_populares, 'campanhas_populares' => $campanhas_populares, 'campanhas' => $campanhas]);
    }

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

        return view('principais.categoria', ['institutes' => $institutes, 'nome_categoria' => $nome_categoria, 'outras_categorias' => $outras_categorias, 'qtd_institutes' => $qtd_institutes, 'qtd_campanhas' => $qtd_campanhas, 'campanhas' => $campanhas]);
    }

    public function criar()
    {
        // Coleta todas as categorias para lista dropdown do cadastro
        $categorias = category_institute::all();

        return view('principais.criar', ['categorias' => $categorias]);
    }

    public function criarInstitutes(Request $request)
    {
        // Cria novo instituto
        $institute = new Institute;

        // Coleta usuário autenticado para definir o dono
        $usuario = auth()->user();

        // Request dos dados do formulários
        $institute->cnpj = $request->cnpj;
        $institute->nome_instituicao = $request->nome;
        $institute->id_criador = $usuario->id;
        $institute->id_categoria = $request->categoria;
        $institute->telefone = $request->telefone;
        $institute->email = $request->email;
        $institute->municipio = $request->municipio;
        $institute->uf = $request->uf;
        $institute->logradouro = $request->logradouro;
        $institute->pixKey = $request->pixKey;
        $institute->titular = $request->titular;
        $institute->descricao = $request->descricao;

        // Upload de imagem, se não houver, ele usa uma imagem placeholder
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('/img/institutes/' . $usuario->id . '_' . $request->nome . '/capa'), $imageName);

            $institute->image = '/img/institutes/' . $usuario->id . '_' . $request->nome . "/capa/" . $imageName;
        } else {
            $institute->image = "https://ui-avatars.com/api/?name=" . urlencode($institute->nome_instituicao) . "&color=7F9CF5&background=EBF4FF";
        }

        // Upload de imagem, se não houver, ele usa uma imagem placeholder
        if ($request->hasFile('image_perfil') && $request->file('image_perfil')->isValid()) {

            $requestImage = $request->image_perfil;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('/img/institutes/' . $usuario->id . '_' . $request->nome . '/img_perfil'), $imageName);

            $institute->image_perfil = '/img/institutes/' . $usuario->id . '_' . $request->nome . '/img_perfil/' . $imageName;
        } else {
            $institute->image_perfil = "https://ui-avatars.com/api/?name=" . urlencode($institute->nome_instituicao) . "&color=7F9CF5&background=EBF4FF";
        }

        // Salva no banco
        $institute->save();

        // Redireciona para a dashboard
        return redirect('/dashboard')->with('msg', 'Instituição criada com sucesso!');
    }

    public function doar(Request $request)
    {

        $payment = new Payment;

        // Request dos dados do formulários

        $payment->id_instituicao = $request->id_instituicao;
        $payment->valorDoado = $request->valorDoado;
        $payment->id_doador = $request->id_doador;

        // Salva no banco
        $payment->save();

        // Redireciona para a pagina com o qrcode
        return redirect("/instituicao/{$request->id_instituicao}/codeDoar");
    }

    public function codeDoar($id)
    {
        $usuario = auth()->user();
        // Encontra instituição pelo id
        $institute = Institute::findOrFail($id);

        // Pega o payment

        $valorDoado = DB::table('payments')
            ->select('valorDoado')
            ->where('id_instituicao', '=', $id)
            ->where('id_doador', '=', $usuario->id)
            ->whereRaw('id = (select max(id) from payments)')
            ->get();



        return view('principais.codeDoar',['institute' => $institute, 'valorDoado' => $valorDoado]);
    }

    public function estatistica($id)
    {

        // Encontra instituição pelo id
        $institute = Institute::findOrFail($id);

        // Pega o usuario autenticado
        $usuario = auth()->user();

        // Pega o payment

        $payment = DB::table('payments')
            ->where('id_institute', '=', $id);

        $paymentLastMonth = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->where('created_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 30 DAY)'))
            ->sum("valorDoado");

        $paymentLastYear = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->where('created_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 1 YEAR)'))
            ->sum("valorDoado");

        $janeiro = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '1')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $fevereiro = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '2')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $marco = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '3')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $abril = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '4')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $maio = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '5')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $junho = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '6')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $julho = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '7')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $agosto = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '8')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $setembro = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '9')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $outubro = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '10')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $novembro = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '11')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        $dezembro = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->whereMonth('created_at', '=', '12')
            ->whereYear('created_at', '=', NOW())
            ->sum('valorDoado');

        return view('principais.estatisticas', [
            'institute' => $institute, 'payments' => $payment, 'paymentLastMonth' => $paymentLastMonth, 'paymentLastYear' => $paymentLastYear,
            'janeiro' => $janeiro, 'fevereiro' => $fevereiro, 'marco' => $marco, 'abril' => $abril, 'maio' => $maio, 'junho' => $junho, 'julho' => $julho, 'agosto' => $agosto, 'setembro' => $setembro,
            'outubro' => $outubro, 'novembro' => $novembro, 'dezembro' => $dezembro, 'usuario' => $usuario
        ]);
    }
    public function doarCampanha(Request $request)
    {

        $payment_campanha = new Payment_campanha();

        // Request dos dados do formulários

        $payment_campanha->id_campanha = $request->id_campanha;
        $payment_campanha->valorDoado = $request->valorDoado;
        $payment_campanha->id_doador = $request->id_doador;

        // Salva no banco
        $payment_campanha->save();

        // Redireciona para a pagina com o qrcode
        return redirect("/campanha/{$request->id_campanha}/codeDoarCampanha");
    }

    public function codeDoarCampanha($id)
    {
        $usuario = auth()->user();
        // Encontra instituição pelo id
        $campanha = Campanha::findOrFail($id);

        // Pega o payment

        $valorDoado = DB::table('payment_campanhas')
            ->select('valorDoado')
            ->where('id_campanha', '=', $id)
            ->where('id_doador', '=', $usuario->id)
            ->whereRaw('id = (select max(id) from payment_campanhas)')
            ->get();



        return view('principais.codeDoarCampanha',['campanha' => $campanha, 'valorDoado' => $valorDoado]);
    }

    public function mostrar($id)
    {
        $usuario = auth()->user();
        // +1 visualização para a instituição que o usuário clicar
        DB::table('institutes')->where('id', '=', $id)->increment('visualizacoes');

        // Encontra instituição pelo id
        $institute = Institute::findOrFail($id);

        // Pega o criador da instituição
        $criador = User::where('id', $institute->id_criador)->first()->toArray();

        // Pega a categoria
        $categoria = category_institute::where('id', $institute->id_categoria)->first()->toArray();

        $paymentLastMonth = DB::table('payments')
            ->where('id_instituicao', '=', $id)
            ->where('created_at', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 30 DAY)'))
            ->sum("valorDoado");

        $posts = DB::table('posts')
            ->where('id_institute', '=', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        // +1 visualização para a categoria da instituição
        DB::table('category_institutes')->where('id', '=', $categoria['id'])->increment('visualizacoes_categoria');

        return view('principais.institute', ['institute' => $institute, 'criador' => $criador, 'categoria' => $categoria, 'posts' => $posts, 'usuario' => $usuario, 'paymentLastMonth' => $paymentLastMonth]);
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

        return view('principais.perfil', ['perfil' => $perfil, 'institutes' => $institutes, 'posts' => $posts, 'campanhas' => $campanhas]);
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

        return view('principais.gerenciar', ['institutes' => $institutes, 'campanhas' => $campanhas]);
    }

    public function deletar($id)
    {

        // Encontra instituição pelo id
        $institute = Institute::findOrFail($id);
        // Encontra imagem da instituição


        File::delete(public_path($institute->image));
        File::delete(public_path($institute->image_perfil));
        $institute->delete();


        // Redireciona para a página de gerencia
        return redirect('/gerenciar')->with('msg', 'Instituição deletada com sucesso!');
    }

    public function editar($id)
    {
        // Usuário autenticado
        $usuario = auth()->user();
        // Encontra instituição
        $institute = Institute::findOrFail($id);
        // Puxa categorias do banco
        $categorias = category_institute::all();

        // Caso o id do usuário seja diferente do do criador, redireciona para dashboard
        if ($usuario->id != $institute->id_criador) {
            return redirect('/dashboard');
        } else {
            return view('principais.editar', ['institute' => $institute, 'categorias' => $categorias]);
        }
    }

    public function update(Request $request)
    {
        // Coleta todos os dados inseridos na página de instituição
        $dados = $request->all();

        $usuario = auth()->user();

        $institute = Institute::findOrFail($request->id);

        // Upload de imagem
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            File::delete(public_path($institute->image));

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $request->image->move(public_path('/img/institutes/' . $usuario->id . '_' . $request->nome . '/capa'), $imageName);

            $dados['image'] = '/img/institutes/' . $usuario->id . '_' . $request->nome . '/capa/' . $imageName;
        }

        // Upload de imagem
        if ($request->hasFile('image_perfil') && $request->file('image_perfil')->isValid()) {

            File::delete(public_path($institute->image_perfil));

            $requestImage = $request->image_perfil;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $request->image_perfil->move(public_path('/img/institutes/' . $usuario->id . '_' . $request->nome . '/img_perfil'), $imageName);

            $dados['image_perfil'] = '/img/institutes/' . $usuario->id . '_' . $request->nome . '/img_perfil/' . $imageName;
        }

        $institute->update($dados);

        return redirect('/gerenciar')->with('msg', 'Instituição atualizada com sucesso!');
    }

    public function config()
    {
        return view('profile.show');
    }

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

    public function caixa_entrada()
    {
        $usuario = auth()->id();

        $mensagens = DB::table('entrada_mensagems')
            ->join('users', 'id_enviou', '=', 'users.id')
            ->select('data', 'title', 'name', 'profile_photo_path', 'id_enviou', 'entrada_mensagems.created_at', 'id_recebeu', 'entrada_mensagems.id')
            ->orderBy('entrada_mensagems.created_at', 'desc')
            ->where('id_recebeu', '=', $usuario)
            ->paginate(30);

        return view('principais.caixa_entrada', ['mensagens' => $mensagens]);
    }

    public function enviar_mensagem(Request $request, $id)
    {
        $usuario = auth()->id();

        $mensagem =  new entradaMensagem();

        $mensagem->id_enviou = $usuario;
        $mensagem->id_recebeu = $id;
        $mensagem->title = $request->title;
        $mensagem->data = $request->data;

        $mensagem->save();

        return redirect(url()->previous())->with('msg', 'Recado enviado com sucesso!');
    }

    public function deletar_mensagem($id)
    {

        $mensagem = entradaMensagem::findOrFail($id);

        $mensagem->delete();

        return redirect(url()->previous())->with('msg', 'Recado deletado com sucesso!');
    }

    public function deletar_todas_mensagens()
    {

        $usuario = auth()->id();

        $mensagens_count = entradaMensagem::where('id_recebeu', '=', $usuario)->count();
        entradaMensagem::where('id_recebeu', '=', $usuario)->delete();

        return redirect(url()->previous())->with('msg', $mensagens_count . ' Recado(s) deletado(s) com sucesso!');
    }

    public function criar_campanha()
    {

        $categorias = category_institute::all();

        return view('principais.campanhas.criar_campanha', ['categorias' => $categorias]);
    }

    public function post_campanha(Request $request)
    {

        $usuario_logado = auth()->id();

        $campanha = new Campanha();

        $campanha->id_criador = $usuario_logado;
        $campanha->nome = $request->nome;
        $campanha->id_categoria = $request->categoria;
        $campanha->telefone = $request->tel;
        $campanha->email = $request->email;
        $campanha->endereco = $request->endereco;
        $campanha->descricao = $request->descricao;
        $campanha->cidade = $request->cidade;
        $campanha->pixKey = $request->pixKey;
        $campanha->titular = $request->titular;
        $campanha->data_fim = $request->data_fim;

        // Upload de imagem, se não houver, ele usa uma imagem placeholder
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path("/img/campanhas/" . $usuario_logado . '_' . $campanha->nome), $imageName);

            $campanha->img_path = "/img/campanhas/" . $usuario_logado . '_' . $campanha->nome . '/' . $imageName;
        } else {
            $campanha->img_path = "https://ui-avatars.com/api/?name=" . urlencode($campanha->nome) . "&color=7F9CF5&background=EBF4FF";
        }

        $campanha->save();

        return redirect('dashboard')->with('msg', 'Campanha criada com sucesso!');
    }

    public function show_campanha($id)
    {
        $usuario = auth()->user();

        $paymentSum = DB::table('payment_campanhas')
        ->where('id_campanha', '=', $id)
        ->sum("valorDoado");

        DB::table('campanhas')->where('id', '=', $id)->increment('visualizacoes');
        $campanha = Campanha::findOrFail($id);
        $criador = User::where('id', $campanha->id_criador)->first()->toArray();
        $categoria = category_institute::where('id', $campanha->id_categoria)->first()->toArray();

        return view('principais.campanhas.campanha', ['campanha' => $campanha, 'criador' => $criador, 'categoria' => $categoria, 'usuario' => $usuario, 'paymentSum' => $paymentSum]);
    }

    public function delete_campanha($id)
    {
        Campanha::findOrFail($id)->delete();

        return redirect(url()->previous())->with('msg', 'Campanha deletada com sucesso!');
    }

    public function editar_campanha($id)
    {
        // Usuário autenticado
        $usuario = auth()->user();
        // Encontra a campanha
        $campanha = Campanha::findOrFail($id);
        // Puxa categorias do banco
        $categorias = category_institute::all();

        // Caso o id do usuário seja diferente do do criador, redireciona para dashboard
        if ($usuario->id != $campanha->id_criador) {
            return redirect('/dashboard');
        } else {
            return view('principais.campanhas.editar_campanha', ['campanha' => $campanha, 'categorias' => $categorias]);
        }
    }

    public function update_campanha(Request $request)
    {
        // Coleta todos os dados inseridos na página de instituição
        $dados = $request->all();

        $usuario_logado = auth()->id();

        $campanha = Campanha::findOrFail($request->id);

        // Upload de imagem
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            File::delete(public_path($campanha->img_path));

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $request->image->move(public_path("/img/campanhas/" . $usuario_logado . '_' . $campanha->nome), $imageName);

            $dados['img_path'] = "/img/campanhas/" . $usuario_logado . '_' . $campanha->nome . '/' . $imageName;
        }


        $campanha->update($dados);

        return redirect('/gerenciar')->with('msg', 'Instituição atualizada com sucesso!');
    }
}
