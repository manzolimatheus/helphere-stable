@extends('layouts.main')

@section('titulo', 'Dashboard')

@section('conteudo')

    {{-- Modal --}}
    <div class="modal fade" id="ModalDoarHelpHere" tabindex="-1" aria-labelledby="ModalDoarHelpHere" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Doação para
                        HelpHere</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <p>Doando para o HelpHere você nos ajuda a mantermos nosso site, alcançando assim mais
                            pessoas com nossos serviços!</p>
                        <img src="/img/assets/qrcode-pix.png" alt="Pix" class="w-100 p-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo%E2%80%94pix_powered_by_Banco_Central_%28Brazil%2C_2020%29.svg/2560px-Logo%E2%80%94pix_powered_by_Banco_Central_%28Brazil%2C_2020%29.svg.png"
                            alt="Pix" class="w-50 p-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Fim Modal --}}


    {{-- Mensagem de bem vindo e botoes --}}
    <div class="container p-3 bg-white shadow">

        {{-- Mensagem de bem-vindo --}}
        <div class="container text-center">
            <div class="row">
                <div class="col-sm">
                    <lottie-player src="https://assets1.lottiefiles.com/packages/lf20_z9ed2jna.json"
                        background="transparent" speed="1" loop autoplay></lottie-player>
                </div>
                <div class="col-sm">
                        <h4 class="display-4 align-self-center bem-vindo">
                            <b>Bem-vindo</b>, <span class="text-info">{{ $usuario->name }}</span>!
                        </h4>
                </div>
            </div>
        </div>

        {{-- Botões de funcionalidades --}}
        <div class="container-fluid text-center mt-1">
            <div class="row">
                <div class="col-sm">
                    <a href="/criar" class="btn bg-verde-agua p-4 text-white w-100 h3 rounded-pill">
                        <ion-icon name="add-circle-outline" class="me-2"></ion-icon>

                        <b>Criar instituição</b>
                    </a>
                </div>
                <div class="col-sm">
                    <a href="/criar_campanha" class="btn btn-primary p-4 text-white w-100 h3 rounded-pill">
                        <ion-icon name="add-circle-outline" class="me-2"></ion-icon>

                        <b>Criar campanha</b>
                    </a>
                </div>
                <div class="col-sm">
                    <a href="/gerenciar" class="btn bg-roxo p-4 text-white w-100 h3 rounded-pill">
                        <ion-icon name="apps-outline" class="me-2"></ion-icon><span>
                            <b>Gerenciar</b>
                    </a>
                </div>
                <div class="col-sm">
                    <button class="btn bg-roxo-vivo p-4 w-100 h3 text-white rounded-pill" data-bs-toggle="modal"
                        data-bs-target="#ModalDoarHelpHere">
                        <ion-icon name="cafe-outline" class="me-2"></ion-icon>
                        <b>Apoiar HelpHere</b>
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Fim mensagem de bem vindo e botoes --}}

    {{-- Verificação de instituições --}}
    {{-- Caso não encontre nenhuma instituição cadastrada --}}
    @if (count($institutes) < 1 and count($campanhas) < 1)
        <div class="container bg-white shadow p-3 mt-3 mb-3 rounded">
            <div class="container text-center">
                <h3 class="mt-3">👋 Está meio vazio por aqui...<span class="text-primary">Experimente
                        criar! </span></h3>
                        <div class="container p-3 mt-3 mb-3">
                            <lottie-player src="https://assets4.lottiefiles.com/private_files/lf30_bn5winlb.json"
                            background="transparent" speed="1" loop autoplay></lottie-player>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="/criar"><button type="button" class="btn bg-verde-agua p-3 rounded-pill w-100 text-white"><b>Criar
                                    instituição</b></button></a>
                            </div>
                            <div class="col">
                                <a href="/criar_campanha"><button type="button" class="btn btn-primary p-3 text-white w-100 rounded-pill"><b>Criar
                                    campanha</b></button></a>
                            </div>
                        </div>
                
            </div>

        </div>
    @else

        {{-- Sessão de mais populares --}}
        @if (count($institutes) > 0)
            <div class="container bg-white shadow p-5 mt-5 rounded">
                <h3>
                    <ion-icon name="flame-outline" class="me-2 text-warning"></ion-icon>Instituições mais populares
                </h3>
                <div class="row">
                    <div class="wrapper">
                        @foreach ($populares as $popular)
                            <div class="col">
                                <div class="card mx-2 shadow" style="width: 18rem">
                                    <div class="card-img-top background-fix p-3"
                                        style="background-image: url('{{ $popular->image }}');">
                                        <img src="{{ $popular->image_perfil }}" class="card-image w-100">
                                    </div>
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-truncate">{{ $popular->nome_instituicao }}</h5>
                                        <span class="badge bg-success">
                                            <ion-icon name="extension-puzzle-outline" class="me-2"></ion-icon>
                                            {{ $popular->categoria }}
                                        </span>
                                        <p class="text-muted">
                                            <ion-icon name="eye-outline" class="me-2"></ion-icon>
                                            {{ $popular->visualizacoes }}
                                        </p>
                                        <a href="/instituicao/{{ $popular->id }}"
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
            </div>
        @endif

        {{-- Sessão das categorias mais populares --}}
        <div class="container bg-white shadow p-5 mt-5 rounded">
            <h3>
                <ion-icon name="grid-outline" class="me-2" style="color: lightskyblue"></ion-icon>Categorias
            </h3>

            <div class="row align-items-start mt-3 mb-3">
                <div class="wrapper">
                    @foreach ($categorias_populares as $cat)
                        <div class="col-sm-6" style="width: auto">
                            <div class="bloco mx-3 bloco-categoria"
                                style="background-image: linear-gradient(rgba(0, 0, 0, 0.527),rgba(0, 0, 0, 0.5)) ,url('https://source.unsplash.com/200x200/?{{ $cat->categoria_ingles }}');">
                                <a href="/categoria/{{ $cat->id }}">
                                    <h3 class="mt-3">
                                        <ion-icon name="extension-puzzle-outline"></ion-icon>{{ $cat->categoria }}
                                    </h3>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- Listando instituições no geral --}}
        @if (count($institutes) > 0)
            <div class="container bg-white shadow p-5 mt-5 mb-3 rounded">
                <h3>
                    <ion-icon name="search-outline" class="me-2" style="color: #cc00ff"></ion-icon> Descobrir
                    instituições
                </h3>
                <div class="row">
                    <div class="wrapper">
                        @foreach ($institutes as $institute)
                            <div class="col">
                                <div class="card shadow mx-2" style="width: 18rem">
                                    <div class="card-img-top background-fix p-3"
                                        style="background-image: url('{{ $institute->image }}');">
                                        <img src="{{ $institute->image_perfil }}" class="card-image w-100">
                                    </div>
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-truncate">{{ $institute->nome_instituicao }}</h5>
                                        <span class="badge bg-success">
                                            <ion-icon name="extension-puzzle-outline" class="me-2"></ion-icon>
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
                </div>
            </div>
        @endif

        @if (count($campanhas) > 0)
            <div class="container bg-white shadow p-5 mt-5 rounded">
                <h3>
                    <ion-icon name="flame-outline" class="me-2 text-warning"></ion-icon>Campanhas mais populares
                </h3>
                <div class="row">
                    <div class="wrapper">
                        @foreach ($campanhas_populares as $campanha)
                            <div class="col">
                                <div class="card mx-2 shadow" style="width: 18rem">
                                    <img src="{{ $campanha->img_path }}" class="card-img-top">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-truncate">{{ $campanha->nome }}</h5>
                                        <span class="badge bg-success">
                                            <ion-icon name="extension-puzzle-outline" class="me-2"></ion-icon>
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
                </div>
            </div>
        @endif

        @if (count($campanhas) > 0)
            <div class="container bg-white shadow p-5 mt-5 mb-5 rounded">
                <h3>
                    <ion-icon name="search-outline" class="me-2" style="color: #cc00ff"></ion-icon> Descobrir
                    campanhas
                </h3>
                <div class="row">
                    <div class="wrapper">
                        @foreach ($campanhas as $campanha)
                            <div class="col">
                                <div class="card shadow mx-2" style="width: 18rem">
                                    <img src="{{ $campanha->img_path }}" class="card-img-top">
                                    <div class="card-body text-center">
                                        <h5 class="card-title text-truncate">{{ $campanha->nome }}</h5>
                                        <span class="badge bg-success">
                                            <ion-icon name="extension-puzzle-outline" class="me-2"></ion-icon>
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
                </div>
            </div>
        @endif
    @endif

@endsection
