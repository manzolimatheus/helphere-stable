@extends('layouts.main')

@section('titulo', 'Pesquisa')

@section('conteudo')

    <div class="container bg-white shadow mt-3 mb-3 rounded">

        {{-- Botões de alternar entre pessoas e instituições --}}
        <div class="row">
            <div class="col-sm-3 bg-light rounded">
                <div class="text-center mt-3">

                    <a href="/pesquisa?q={{ $pesquisa }}" class="w-100">
                        <ion-icon name="heart" class="me-2"></ion-icon>Instituições
                    </a>
                    <hr>

                    <a href="/pesquisa/campanha?q={{ $pesquisa }}" class="w-100">
                        <ion-icon name="heart" class="me-2"></ion-icon>Campanhas
                    </a>
                    <hr>

                    <a href="/pesquisa/pessoas?q={{ $pesquisa }}" class="w-100">
                        <ion-icon name="people" class="me-2"></ion-icon>Pessoas
                    </a>
                    <hr>
                    <a href="/pesquisa/postsusers?q={{ $pesquisa }}" class="w-100">
                        <ion-icon name="people" class="me-2"></ion-icon>Posts de usuários
                    </a>
                    <hr>
                    <a href="/pesquisa/postsinstitutes?q={{ $pesquisa }}" class="w-100">
                        <ion-icon name="people" class="me-2"></ion-icon>Posts de instituições
                    </a>
                    <hr>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="container bg-white p-3 mt-3 mb-3 rounded">
                    <h4>
                        <ion-icon name="search-circle-outline" class="me-2"></ion-icon>Você está pesquisando por
                        "{{ $pesquisa }}"
                    </h4>
                    <p>{{ $qtd_usuarios }} Resultados encontrados</p>
                    {{-- Sessão da pesquisa onde mostra-se os usuários com o nome pesquisado, linkando para o perfil --}}

                    @if (count($usuarios) < 1)
                        <div class="container text-center">
                            <h3 class="mt-3">Nenhuma instituição encontrada com esse termo! 🙁</h3>
                            <div class="container p-3">
                                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_sosleqza.json"
                                    background="transparent" speed="1" style="width: 80%;" class="mx-auto" loop
                                    autoplay></lottie-player>
                            </div>
                        </div>
                    @else

                        <div class="row p-3">
                            @foreach ($usuarios as $usuario)
                                <div class="coluna-responsive p-1">
                                    <div class="card shadow">
                                        <div class="container text-center p-3">
                                            @if ($usuario->profile_photo_path == '')
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($usuario->name) }}&color=7F9CF5&background=EBF4FF"
                                                    alt="Imagem de perfil" class="card-image">
                                            @else
                                                <img src="/storage/{{ $usuario->profile_photo_path }}"
                                                    alt="Imagem do usuário" class="card-img-top">
                                            @endif
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-truncate">{{ $usuario->name }}</h5>
                                            <a href="/perfil/{{ $usuario->id }}"
                                                class="btn btn-info text-white w-100 rounded-pill">
                                                <h5>Saiba mais</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="wrapper">
                            {{ $usuarios->appends(['q' => $pesquisa])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
