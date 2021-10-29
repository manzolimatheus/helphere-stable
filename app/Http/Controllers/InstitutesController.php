<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Pix\Payload;
use App\Models\Institute;
use App\Models\Payment;
use App\Models\User;
use App\Models\category_institute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

//bacon qrcode
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class InstitutesController extends Controller
{
    public function criar()
    {
        // Coleta todas as categorias para lista dropdown do cadastro
        $categorias = category_institute::all();

        return view('principais.institutes.criar', ['categorias' => $categorias]);
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

        // Pega o valor estipulado pelo doador

        $valorDoado = DB::table('payments')
            ->select('valorDoado')
            ->where('id_instituicao', '=', $id)
            ->where('id_doador', '=', $usuario->id)
            ->whereRaw('id = (select max(id) from payments)')
            ->get();

        foreach ($valorDoado as $vlr)

            // GERA O VALOR DO TXID
            $aleatorio = rand(25, 25);
        $hash = substr(str_shuffle("AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz0123456789"), 0, $aleatorio);

        //SUBSTITUI ACENTOS E CARACTERES ESPECIAIS
        function sanitizeString($string)
        {

            // matriz de entrada
            $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

            // matriz de saída
            $by   = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

            // devolver a string
            return str_replace($what, $by, $string);
        }

        // INSTANCIA PRINCIPAL DO PAYLOAD DO PIX
        $obPayload = (new Payload)->setPixKey($institute->pixKey)
            ->setDescription('Doando para ' . sanitizeString($institute->nome_instituicao))
            ->setMerchantName(sanitizeString($institute->titular))
            ->setMerchantCity(sanitizeString($institute->municipio))
            ->setAmount($vlr->valorDoado)
            ->setTxid($hash);

        //CODIGO DE PAGAMENTO PIX
        $payloadQrCode = $obPayload->getPayload();

        //Transforma o codigo do payloado em uma imagem qrcode
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);



        return view('principais.institutes.codeDoar', ['institute' => $institute, 'valorDoado' => $valorDoado, 'payloadQrCode' => $payloadQrCode, 'writer' => $writer]);
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

        return view('principais.institutes.estatisticas', [
            'institute' => $institute, 'payments' => $payment, 'paymentLastMonth' => $paymentLastMonth, 'paymentLastYear' => $paymentLastYear,
            'janeiro' => $janeiro, 'fevereiro' => $fevereiro, 'marco' => $marco, 'abril' => $abril, 'maio' => $maio, 'junho' => $junho, 'julho' => $julho, 'agosto' => $agosto, 'setembro' => $setembro,
            'outubro' => $outubro, 'novembro' => $novembro, 'dezembro' => $dezembro, 'usuario' => $usuario
        ]);
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

        return view('principais.institutes.institute', ['institute' => $institute, 'criador' => $criador, 'categoria' => $categoria, 'posts' => $posts, 'usuario' => $usuario, 'paymentLastMonth' => $paymentLastMonth]);
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
            return view('principais.institutes.editar', ['institute' => $institute, 'categorias' => $categorias]);
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
}
