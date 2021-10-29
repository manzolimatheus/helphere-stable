@extends('layouts.main')

@section('titulo', 'Pesquisa')

@section('conteudo')

    <div class="container bg-white shadow mt-3 mb-3 rounded">

        <div class="row">
            <div class="col-sm-3 bg-light rounded">
                {{-- Botões de alternar entre pessoas e instituições --}}
                <div class="text-center mt-3">

                    <div class="text-center">
                        <a href="/pesquisa?q={{ $pesquisa }}" class="w-100">
                            <ion-icon name="heart" class="me-2"></ion-icon>Instituições
                        </a>
                        <hr>

                        <a href="/pesquisa?q={{ $pesquisa }}" class="w-100">
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
                    </div>

                </div>
            </div>
            <div class="col-sm-9">
                {{-- Verificação se encontrou instituições --}}
                <div class="container mt-3">
                    <h4>
                        <ion-icon name="search-circle-outline" class="me-2"></ion-icon>Você está pesquisando
                        por
                        "{{ $pesquisa }}"
                    </h4>
                    <p>{{ $qtd_campanhas }} Resultados encontrados</p>

                    @if (count($campanhas) < 1)
                        <div class="container text-center">
                            <h3 class="mt-3">Nenhuma campanha encontrada com esse termo! 🙁</h3>
                            <div class="container p-3">
                                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_sosleqza.json"
                                    background="transparent" speed="1" style="width: 80%;" class="mx-auto" loop
                                    autoplay></lottie-player>
                            </div>
                        </div>
                    @else

                        {{-- Listando campanhas --}}
                        <div class="row p-3">
                            @foreach ($campanhas as $campanha)
                                <div class="coluna-responsive p-1">
                                    <div class="card shadow" style="width: auto">
                                            <img src="{{ $campanha->img_path }}" class="card-img-top">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-truncate">{{ $campanha->nome }}
                                            </h5>
                                            <span class="badge bg-success">{{ $campanha->categoria }}</span>
                                            <p class="text-muted">
                                                <ion-icon name="eye-outline" class="me-2"></ion-icon>
                                                {{ $campanha->visualizacoes }}
                                            </p>
                                            <a href="/campanha/{{ $campanha->id }}"
                                                class="btn btn-info text-white w-100 rounded-pill">
                                                <h5>Saiba
                                                    mais</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="wrapper">
                            {{ $campanhas->appends(['q' => $pesquisa])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
