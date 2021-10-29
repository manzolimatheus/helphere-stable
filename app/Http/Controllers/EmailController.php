<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\entradaMensagem;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    
    public function caixa_entrada()
    {
        $usuario = auth()->id();

        $mensagens = DB::table('entrada_mensagems')
            ->join('users', 'id_enviou', '=', 'users.id')
            ->select('data', 'title', 'name', 'profile_photo_path', 'id_enviou', 'entrada_mensagems.created_at', 'id_recebeu', 'entrada_mensagems.id')
            ->orderBy('entrada_mensagems.created_at', 'desc')
            ->where('id_recebeu', '=', $usuario)
            ->paginate(30);

        return view('principais.usuario.caixa_entrada', ['mensagens' => $mensagens]);
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

}
