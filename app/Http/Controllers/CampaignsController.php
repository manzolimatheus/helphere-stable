<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Pix\Payload;
use App\Models\Payment_campanha;
use App\Models\User;
use App\Models\category_institute;
use App\Models\Campanha;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

//bacon qrcode
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class CampaignsController extends Controller
{
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

        // Pega o valor doado estipulado pelo doador

        $valorDoado = DB::table('payment_campanhas')
            ->select('valorDoado')
            ->where('id_campanha', '=', $id)
            ->where('id_doador', '=', $usuario->id)
            ->whereRaw('id = (select max(id) from payment_campanhas)')
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
        $obPayload = (new Payload)->setPixKey($campanha->pixKey)
            ->setDescription('Doando para ' . sanitizeString($campanha->nome))
            ->setMerchantName(sanitizeString($campanha->titular))
            ->setMerchantCity(sanitizeString($campanha->cidade))
            ->setAmount($vlr->valorDoado)
            ->setTxid($hash);

        //CODIGO DE PAGAMENTO PIX
        $payloadQrCode = $obPayload->getPayload();

        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);



        return view('principais.campanhas.codeDoarCampanha', ['campanha' => $campanha, 'valorDoado' => $valorDoado, 'payloadQrCode' => $payloadQrCode, 'writer' => $writer]);
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