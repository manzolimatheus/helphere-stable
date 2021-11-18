@extends('layouts.main')

@section('titulo', 'Início')

@section('conteudo')

    {{-- Topo --}}

    <div class="container-fluid text-white">

        <video autoplay loop muted class="bg_video"
            poster="https://images.unsplash.com/photo-1544027993-37dbfe43562a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=750&q=80">
            <source src="/img/assets/video.mp4" type="video/mp4">
        </video>


        <div class="container d-flex justify-content-center p-3">
            <a href="/" class="nav-link text-white h4 mx-2">Início</a>
            <a href="/login" class="nav-link text-white h4 mx-2">Entrar</a>
            <a href="/suporte" class="nav-link text-white h4 mx-2">Suporte</a>
        </div>

        <div class="row text-center aba-dados-inicio">
            <div class="col-sm">
                <h4>Usuários cadastrados</h4>
                <h1 class="display-1">
                    @if ($usuarios > 100000)
                        100.000+
                    @else
                        {{ $usuarios }}
                    @endif
                </h1>
            </div>
            <div class="col-sm">
                <h4>Instituições cadastradas</h4>
                <h1 class="display-1">
                    @if ($institutes > 100000)
                        100.000+
                    @else
                        {{ $institutes }}
                    @endif
                </h1>
            </div>
            <div class="col-sm">
                <h4>Doações realizadas</h4>
                <h1 class="display-1">
                @if ($institutesAjudados > 100000)
                        100.000+
                    @else
                        {{ $institutesAjudados }}
                    @endif
                </h1>
            </div>
        </div>
    </div>
    {{-- FIm topo --}}

    <div class="container-fluid">
        <div class="row bg-white">
            <div class="col-sm-4 g-0">
                <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_9wjm14ni.json" background="transparent"
                    speed="1" loop autoplay></lottie-player>
            </div>
            <div class="col-sm-8 bg-white">
                <div class="container p-3">
                    <h1 class="text-info text-center h1">Sobre nós</h1>
                    <div class="container mt-5">
                        <p class="texto-principal">HelpHere é um projeto voltado para apoiar instituições carentes
                            e conectar
                            pessoas a comunidades!
                            Criado em 2021 em um trabalho de conclusão de curso, agora estamos totalmente voltados para
                            acolher
                            e ajudar a quem precisa.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row bg-primary">
            <div class="col-sm-8 bg-primary">
                <div class="container p-3 text-white">
                    <h1 class="text-info text-center">Como funciona?</h1>
                    <div class="container mt-5">
                        <p class="texto-principal">Para utilizar nossos serviços basta criar uma conta e sair
                            usando! Fácil e
                            rápido. Após isso você
                            decide, ajudar ou ser ajudado. 😇</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 g-0">
                <lottie-player src="https://assets6.lottiefiles.com/packages/lf20_vfuqgv0l.json" background="transparent"
                    speed="1" loop autoplay></lottie-player>
            </div>
        </div>
    </div>
    <div class="container-fluid w-100 text-center bg-roxo-noHover text-white p-3">
        <h2>Nossa filosofia - Os três A's</h2>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm bg-white g-0">
                <div class="row">
                    <lottie-player src="https://assets10.lottiefiles.com/datafiles/d9bc9kYC2VttaKb/data.json"
                        background="transparent" speed="1" loop autoplay style="width: auto; height: 250px"
                        class="mx-auto"></lottie-player>
                </div>
                <div class="row">
                    <div class="container p-3">
                        <h3 class="text-info text-center">Amor</h3>
                        <p class="text-muted texto">Para nós o amor é fundamental para existir! Sem o amor não
                            desenvolveríamos
                            nada e
                            nem nos
                            interessaríamos por nada. Afinal, pense como é ruim fazer algo sem vontade, ruim não?</p>
                    </div>
                </div>
            </div>
            <div class="col-sm bg-lilas g-0">
                <div class="row">
                    <lottie-player src="https://assets2.lottiefiles.com/temp/lf20_QTR8Nb.json" background="transparent"
                        style="width: auto; height: 250px" class="mx-auto" speed="1" loop autoplay></lottie-player>
                </div>
                <div class="row">
                    <div class="container p-3">
                        <h3 class="text-info text-center">Amizade</h3>
                        <p class="text-muted texto">O que seria de nós sem os amigos? Desde quando nos entendemos como gente
                            dependemos
                            uns dos outros, e
                            hoje em dia não seria diferente, todo mundo precisa de uma mão amiga! </p>
                    </div>
                </div>
            </div>
            <div class="col-sm bg-cinzaEscuro g-0">
                <div class="row w-100">
                    <lottie-player src="https://assets10.lottiefiles.com/private_files/lf30_wwq2op12.json"
                        background="transparent" style="width: auto; height: 250px" class="mx-auto" speed="1" loop
                        autoplay></lottie-player>
                    <div class="container p-3">
                    </div>
                    <div class="row">
                        <h3 class="text-info text-center">Ajuda</h3>
                        <p class="text-muted texto">E com a junção do amor e da amizade, chegamos a ajuda! É ajudando que
                            conseguimos
                            atingir corações e
                            transformar vidas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-verde-noHover">
        <div class="container p-5">
            {{-- Início Carrossel --}}
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="/img/assets/destaque-carrossel-01.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/img/assets/destaque-carrossel-02.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="/img/assets/destaque-carrossel-03.png" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            {{-- Fim Carrossel --}}
        </div>
    </div>
    <div class="container-fluid bg-verdeEscuro-noHover">
        <div class="container p-5 text-center">
            <h1 class="display-6">Desenvolvedores</h1>
            <div class="row mt-5">
                <div class="col-sm">
                    <a href="https://www.instagram.com/manzolimatheus/" target="_blank">
                        <img src="/img/assets/matheus.jpg" alt="Matheus Manzoli" class="img-perfil-inicio mx-2 img-fluid"
                            title="Matheus Manzoli">
                    </a>
                    <a href="https://www.instagram.com/denian_lima/" target="_blank">
                        <img src="/img/assets/denian.jpg" alt="Denian Lima" class="img-perfil-inicio mx-2 img-fluid"
                            title="Denian Lima">
                    </a>
                    <a href="https://www.instagram.com/leonardoeliasferreira/" target="_blank">
                        <img src="/img/assets/leo.jpg" alt="Leonardo Elias" class="img-perfil-inicio mx-2 img-fluid"
                            title="Leonardo Elias">
                    </a>
                    <a href="https://www.instagram.com/rainezinha/" target="_blank">
                        <img src="/img/assets/raine.jpg" alt="Raíne Felix" class="img-perfil-inicio mx-2 img-fluid"
                            title="Raíne Felix">
                    </a>
                    <a href="https://www.instagram.com/nathaliia.silva/" target="_blank">
                        <img src="/img/assets/nathalia.jpg" alt="Nathalia Batista" class="img-perfil-inicio mx-2 img-fluid"
                            title="Nathalia Batista">
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
