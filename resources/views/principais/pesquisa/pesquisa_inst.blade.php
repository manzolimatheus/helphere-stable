@extends('layouts.main')

@section('titulo', 'Pesquisa')

@section('conteudo')

    <div class="container-fluid shadow rounded">
        <div class="row">
            <div class="col-sm-4 bg-light rounded">
                {{-- Botões de alternar entre pessoas e instituições --}}
                <div class="text-center mt-3">

                    <div class="text-center">
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
                    </div>

                </div>
            </div>
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div class="container bg-white p-3 shadow mb-5 rounded">
                            <h4>
                                <ion-icon name="search-circle-outline" class="me-2"></ion-icon>Você está
                                pesquisando
                                por
                                "{{ $pesquisa }}"
                            </h4>
                            <p>{{ $qtd_institutes }} Resultados encontrados</p>

                            @if (count($institutes) < 1)
                                <div class="container text-center">
                                    <h3 class="mt-3">Nenhuma instituição encontrada com esse termo! 🙁</h3>
                                    <div class="container p-3">
                                        <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_sosleqza.json"
                                            background="transparent" speed="1" style="width: 80%;" class="mx-auto"
                                            loop autoplay></lottie-player>
                                    </div>
                                </div>
                            @else

                                {{-- Listando instituições --}}
                                <div class="row p-3">
                                    @foreach ($institutes as $institute)
                                        <div class="col-sm p-1">
                                            <div class="card shadow" style="width: auto">
                                                <div class="card-img-top background-fix p-3 text-center"
                                                    style="background-image: url('{{ $institute->image }}'); height: fit-content">
                                                    <img src="{{ $institute->image_perfil }}" class="card-image w-100">
                                                </div>
                                                <div class="card-body text-center">
                                                    <h5 class="card-title text-truncate">
                                                        {{ $institute->nome_instituicao }}
                                                    </h5>
                                                    <span class="badge bg-success">{{ $institute->categoria }}</span>
                                                    <p class="text-muted">
                                                        <ion-icon name="eye-outline" class="me-2"></ion-icon>
                                                        {{ $institute->visualizacoes }}
                                                    </p>
                                                    <a href="/instituicao/{{ $institute->id }}"
                                                        class="btn btn-info text-white w-100 rounded-pill">
                                                        <h5>Saiba
                                                            mais</h5>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                        </div>
                        <div class="wrapper">
                            {{ $institutes->appends(['q' => $pesquisa])->links() }}
                        </div>
                        @endif
                    </div>
                    <div class="col-sm-2"></div>
                </div>
            </div>
        </div>
    </div>
    

@endsection
