@extends('layouts.main')

@section('titulo', 'Caixa de entrada')

@section('conteudo')

    <div class="container bg-white rounded shadow w-100 mt-3 mb-3 p-3 text-center">
        <div class="row">

            <h3>
                <ion-icon name="mail-unread-outline" class="me-2"></ion-icon>Caixa de entrada<span
                    class="badge rounded-pill bg-danger ms-3">
                    {{ count($mensagens) }}
                </span>
            </h3>


            <form action="/delete_all_message" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mt-3"
                    onclick="return confirm('Deseja realmente deletar TODAS suas mensagens? Essa é uma ação sem volta!');">
                    <span class="text-white">
                        <ion-icon name="warning" class="me-2"></ion-icon>
                        </ion-icon>Limpar caixa de recados
                    </span>
                </button>
            </form>

        </div>
    </div>

    <div class="container bg-white rounded shadow w-100 mt-3 mb-3 p-3">
        @if (count($mensagens) < 1)
            <div class="container text-center">
                <h5>Sua caixa de entrada está vazia! 😢</h5>
                <div class="container p-3 mt-3 mb-3">
                    <lottie-player src="https://assets4.lottiefiles.com/datafiles/vhvOcuUkH41HdrL/data.json"
                        background="transparent" speed="1" loop autoplay style="width: 70%" class="mx-auto">
                    </lottie-player>
                </div>
            </div>
        @else
            @foreach ($mensagens as $mensagem)
                <div class="container bg-white p-3 mt-3 mb-3">
                    <div class="post-foto">
                        @if ($mensagem->profile_photo_path == '')
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($mensagem->name) }}&color=7F9CF5&background=EBF4FF"
                                alt="Imagem de perfil">
                        @else
                            <img src="/storage/{{ $mensagem->profile_photo_path }}" alt="Imagem de perfil">
                        @endif
                        <a href="/perfil/{{$mensagem->id_enviou}}">
                            <b>{{ $mensagem->name }}</b>
                        </a>
                    </div>
                    <div class="w-100">

                        <p>{!! nl2br(e($mensagem->data)) !!}</p>

                        <div class="row">
                            <div class="col-sm">
                                <p class="text-muted me-3">Postado em
                                    {{ date('d/m/Y', strtotime($mensagem->created_at)) }}</p>
                            </div>
                            <div class="col-sm">
                                <form action="/delete_message/{{ $mensagem->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-white text-primary"
                                        onclick="return confirm('Deseja realmente deletar essa mensagem? Essa é uma ação sem volta!');">
                                        <span>
                                            Deletar post
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            @endforeach
        @endif
    </div>


@endsection
