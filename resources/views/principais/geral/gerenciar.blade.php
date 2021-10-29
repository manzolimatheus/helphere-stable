@extends('layouts.main')

@section('titulo', 'Gerenciar')

@section('conteudo')
    <div class="container-fluid">

        {{-- Caso o usuário não tenha instituição, se tiver, listar todas --}}
        @if (count($campanhas) < 1 and count($institutes) < 1)
            <div class="container bg-white shadow p-3 mt-3 mb-3 rounded">
                <div class="container text-center">
                    <h3 class="mt-3">Não há nada para gerenciar! <span
                            class="text-primary">Experimente criar primeiro.</span></h3>
                    <div class="container p-3 mt-3 mb-3">
                        <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_Dtvdde.json"
                            background="transparent" speed="1" loop autoplay style="width: 80%" class="mx-auto"></lottie-player>
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
            {{-- Instituições --}}
            <div class="container bg-white shadow p-3 mt-3 mb-3 rounded">
                <h3 class="mx-3">
                    <ion-icon name="bar-chart-outline" class="mx-2 text-success"></ion-icon>Gerencie suas
                    instituições e campanhas({{ count($institutes) + count($campanhas) }})
                </h3>
                @if (count($institutes) > 0)
                    {{-- Listando instituições que pertencem ao usuário --}}
                    <h3>Instituições</h3>
                    <div class="row">
                        <div class="wrapper">
                            @foreach ($institutes as $institute)
                                <div class="col">
                                    <div class="card mx-2 shadow" style="width: 18rem">
                                        <img src="{{ $institute->image_perfil }}" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $institute->nome_instituicao }}</h5>
                                            <p>Instituição</p>
                                            <a href="/instituicao/{{ $institute->id }}"
                                                class="btn btn-outline-primary w-100 mb-1 rounded-pill"><b>Saiba
                                                    mais</b></a>
                                            <a href="/instituicao/edit/{{ $institute->id }}"
                                                class="btn btn-primary mb-1 w-100 rounded-pill">
                                                <ion-icon name="create-outline" class="mx-2"></ion-icon>Editar
                                            </a>
                                            <form action="/instituicao/{{ $institute->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger delete-btn mb-1 w-100 rounded-pill"
                                                    onclick="return confirm('Deseja realmente deletar essa instituição? Essa é uma ação sem volta!');">
                                                    <ion-icon name="trash-outline" class="mx-2"></ion-icon>Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Campanhas --}}
                {{-- Listando campanhas que pertencem ao usuário --}}
                @if (count($campanhas) > 0)
                    <h3>Campanhas</h3>
                    <div class="row">
                        <div class="wrapper">
                            @foreach ($campanhas as $campanha)
                                <div class="col">
                                    <div class="card mx-2 shadow" style="width: 18rem">
                                        <img src="{{ $campanha->img_path }}" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $campanha->nome }}</h5>
                                            <p>Campanha</p>
                                            <a href="/campanha/{{ $campanha->id }}"
                                                class="btn btn-outline-primary w-100 mb-1 rounded-pill"><b>Saiba
                                                    mais</b></a>
                                            <a href="/campanha/edit/{{ $campanha->id }}"
                                                class="btn btn-primary mb-1 w-100 rounded-pill">
                                                <ion-icon name="create-outline" class="mx-2"></ion-icon>Editar
                                            </a>
                                            <form action="/campanha/{{ $campanha->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger delete-btn mb-1 w-100 rounded-pill"
                                                    onclick="return confirm('Deseja realmente deletar essa campanha? Essa é uma ação sem volta!');">
                                                    <ion-icon name="trash-outline" class="mx-2"></ion-icon>Deletar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

    @endsection
