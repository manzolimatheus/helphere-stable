@extends('layouts.main')

@section('titulo', 'Categoria')

@section('conteudo')
    {{-- Imagem de destaque --}}
    <div class="container">
        <div class="container bg-white shadow rounded">
            <img src="https://source.unsplash.com/1350x500/?{{ $nome_categoria->categoria_ingles }}"
                alt="{{ $nome_categoria->categoria }}" class="w-100 rounded-bottom">
            <div class="container p-3">
                <h3 class="mt-3 ms-2">
                    <ion-icon name="navigate-circle-outline" class="me-2" style="color: #4ad8cc"></ion-icon>Você
                    está na
                    categoria {{ $nome_categoria->categoria }}
                </h3>
            </div>
        </div>
    </div>
    {{-- Listando instituições --}}

    <div class="container mb-5">
        <div class="row">
            <div class="col-sm-9">

                @if (count($institutes) < 1 and count($campanhas) < 1)


                    <div class="container bg-white shadow p-5 rounded mt-3 text-center">
                        <h3>Instituições e campanhas ({{ count($institutes) }})</h3>
                        <p>Poxa, que triste! Não há instituições nem campanhas com essa categoria ainda! :(</p>
                        <div class="container p-3">
                            <lottie-player src="https://assets3.lottiefiles.com/packages/lf20_CGPHc4.json"
                                background="transparent" speed="1" style="width: 80%;" class="mx-auto" loop
                                autoplay></lottie-player>
                        </div>
                    </div>

                @else
                    @if (count($institutes) > 0)
                        <div class="container bg-white shadow p-3 rounded mt-3">
                            <h3>Instituições ({{ $qtd_institutes }})</h3>
                            <div class="row p-3">
                                @foreach ($institutes as $institute)
                                    <div class="coluna-responsive p-2">
                                        <div class="card shadow" style="width: auto">
                                            <div class="card-img-top background-fix p-3"
                                                style="background-image: url('{{ $institute->image }}');">
                                                <img src="{{ $institute->image_perfil }}" class="card-image w-100">
                                            </div>
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-truncate">
                                                    {{ $institute->nome_instituicao }}
                                                </h5>
                                                <span class="badge bg-success">
                                                    <ion-icon name="extension-puzzle-outline" class="me-2">
                                                    </ion-icon>
                                                    {{ $institute->categoria }}
                                                </span>
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
                            <div class="wrapper">
                                {{-- Paginação --}}
                                {{ $institutes->links() }}
                            </div>
                        </div>
                    @endif

                    @if (count($campanhas) > 0)
                        <div class="container bg-white shadow p-3 rounded mt-3">
                            <h3>Campanhas ({{ $qtd_campanhas }})</h3>
                            <div class="row p-3">
                                @foreach ($campanhas as $campanha)
                                    <div class="coluna-responsive p-2">
                                        <div class="card shadow" style="width: auto">
                                            <img src="{{ $campanha->img_path }}" class="card-img-top">
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-truncate">
                                                    {{ $campanha->nome }}
                                                </h5>
                                                <span class="badge bg-success">
                                                    <ion-icon name="extension-puzzle-outline" class="me-2">
                                                    </ion-icon>
                                                    {{ $campanha->categoria }}
                                                </span>
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
                                {{-- Paginação --}}
                                {{ $campanhas->links() }}
                            </div>
                        </div>
                    @endif
                @endif

            </div>
            <div class="col-sm-3">

                {{-- Mais categorias --}}
                <div class="container bg-white shadow p-3 rounded mt-3 mb-3">
                    <h5 class="mt-3 ms-2">
                        <ion-icon name="grid-outline" class="me-2" style="color: lightskyblue"></ion-icon>Mais
                        categorias
                    </h5>
                    <div class="row align-items-start">
                        @foreach ($outras_categorias as $cat)
                            <div class="col-sm-12 w-100">
                                <div class="container p-3">
                                    <div class="bloco bloco-categoria w-100"
                                        style="background-image: linear-gradient(rgba(0, 0, 0, 0.527),rgba(0, 0, 0, 0.5)) ,url('https://source.unsplash.com/300x300/?{{ $cat->categoria_ingles }}'); background-size: cover; background-repeat: no-repeat; ">
                                        <a href="/categoria/{{ $cat->id }}">
                                            <h3 class="mt-3">
                                                <ion-icon name="extension-puzzle-outline"></ion-icon>
                                                {{ $cat->categoria }}
                                            </h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>



            </div>
        </div>


    @endsection
