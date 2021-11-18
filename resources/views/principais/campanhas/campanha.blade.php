@extends('layouts.main')

@section('titulo', $campanha->nome)

@section('conteudo')

    {{-- Modal Doação Campanha --}}
    <div class="modal fade" id="ModalDoar" tabindex="-1" aria-labelledby="ModalDoar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Doação para
                        {{ $campanha->nome }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="/doarCampanha" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div hidden>
                            <label for="id_campanha" class="mt-3">Id Da campanha</label>
                            <input type="number" name="id_campanha" id="id_campanha" value="{{ $campanha->id }}"
                                class="form-control">
                        </div>

                        <div hidden>
                            <label for="id_doador" class="mt-3">Id do doador</label>
                            <input type="number" name="id_doador" id="id_doador" value="{{ $usuario->id }}"
                                class="form-control">
                        </div>

                        <div>
                            <label for="valorDoado" class="mt-3">Digite o valor a ser doado:</label>
                            <input type="number" name="valorDoado" id="valorDoado" class="form-control"
                                placeholder="Separe o real dos centavos utilizando '.'">
                        </div>
                        <br>

                        <button type="submit" class="btn bg-verde-agua w-100 text-white mt-3 rounded-pill"><b>Gerar Código
                                Pix</b></button>

                    </form>

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    {{-- Fim Modal Doação 1 --}}

    {{-- Modal de compartilhar --}}
    <div class="modal fade" id="ModalCompartilhar" tabindex="-1" aria-labelledby="ModalCompartilhar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalCompartilhar">Compartilhar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2">
                            <button class="btn bg-light border" onclick="copy()">
                                <ion-icon name="clipboard-outline" class="h2"></ion-icon>
                            </button>
                        </div>
                        <div class="col-10">
                            <div class="container">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="link">
                                        <ion-icon name="link-outline" class="h3"></ion-icon>
                                    </span>
                                    <input type="text" class="form-control text-muted bg-white" readonly
                                        value="{{Request::url()}}"
                                        aria-describedby="link" id="linkToCopy">
                                </div>
                                <h6>Compartilhe também nas redes sociais!</h6>
                                <a class="btn bg-cinzaEscuro rounded-pill" target="_blank"
                                    href="https://twitter.com/intent/tweet?text=Olá! Estou utilizando o HelpHere para ajudar pessoas e ser ajudado. Venha fazer o bem você também! 😊HelpHere&hashtags=HelpHere">
                                    <ion-icon name="logo-twitter" class="me-2 text-info"></ion-icon><b>Tweet</b>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Fim Modal --}}

    <div class="container mb-5">

        {{-- Topo perfil do usuário --}}
        <div class="container bg-white rounded shadow w-100 text-center">

            {{-- Imagem de capa do perfil --}}
            <div class="container">
                <img src="{{ $campanha->img_path }}" alt="{{ $campanha->nome }}" class="w-100 rounded-bottom"
                    style="width: 800; height: 300px; object-fit: cover;">
            </div>

            {{-- Imagem de perfil, Nome do perfil e botão de editar --}}
            <div class="container p-3">
                <h1>{{ $campanha->nome }}</h1>
                <p class="text-muted">Campanha</p>
                {{-- Botão de editar --}}
                {{-- Se o id usuário logado for igual ao do id do criador da campanha, então pode editar --}}
                @if (Auth::id() == $campanha->id_criador)
                    <div class="container text-center">
                        <a href="/campanha/edit/{{ $campanha->id }}">
                            <ion-icon name="create-outline"></ion-icon>Editar
                        </a>
                    </div>
                @endif
            </div>
            <div class="container p-3">
                <hr>
                <div class="row">
                    {{-- Coluna 1 --}}
                    @if (Auth::id() !== $campanha->id_criador)
                        <div class="col-sm p-1">
                            <button class="btn bg-verde-agua w-100 p-3 text-white rounded-pill" data-bs-toggle="modal"
                                data-bs-target="#ModalDoar">
                                <b>Apoiar causa</b>
                            </button>
                        </div>
                    @endif
                    {{-- Coluna 2 --}}
                    <div class="col-sm p-1">
                        <button class="btn btn-info w-100 p-3 text-white rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#ModalCompartilhar">
                            <b>Compartilhar</b>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fim topo do perfil --}}


        {{-- Linha de conteudo --}}
        <div class="row">
            {{-- Coluna sobre --}}
            <div class="col-sm-5">
                {{-- Dados do perfil --}}
                <div class="container bg-white rounded shadow p-3 mt-3 w-100" style="height: fit-content">
                    <h5>
                        Sobre
                    </h5>
                    <br>

                    <p>
                        <ion-icon name="egg" class="me-2 text-muted"></ion-icon>Criado em
                        {{ date('d/m/Y', strtotime($campanha->created_at)) }}
                    </p>
                    <p>
                        <ion-icon name="call" class="me-2 text-muted"></ion-icon>
                        {{ $campanha->telefone }}
                    </p>
                    <p>
                        <ion-icon name="mail" class="me-2 text-muted"></ion-icon>
                        <a href="mailto: {{ $campanha->email }}"> {{ $campanha->email }}</a>
                    </p>
                    @if ($campanha->endereco !== null)
                        <strong class="text-success">Precisa-se de voluntários no local!</strong>
                        <p>
                            <ion-icon name="location" class="me-2 text-muted"></ion-icon>
                            {{ $campanha->endereco }}
                        </p>
                    @endif
                    <p>
                        <ion-icon name="calendar" class="me-2 text-muted"></ion-icon>
                        Essa instituição se encerra em {{ date('d/m/Y', strtotime($campanha->data_fim)) }}
                    </p>
                </div>

                @if (Auth::id() === $campanha->id_criador)
                    <div class="col-sm-5 container bg-white rounded shadow p-3 mt-3 w-100 text-center"
                        style="height: fit-content">
                        <p>

                            <ion-icon name="cash-outline" class="me-2 text-muted"></ion-icon> Doações recebidas até agora!
                        <div class="text-center">

                            <h3><strong>
                                    <ion-icon name="trending-up-outline" class="text-success"></ion-icon> R$
                                    {{ $paymentSum }}
                                </strong></h3>
                            </a>
                        </div>


                        </p>
                    </div>
                @endif

                <div class="row">
                    <div class="col">
                        <div class="container bg-white rounded shadow p-3 mt-3 w-100 text-center"
                            style="height: fit-content">
                            <b>Administrador</b>
                            <br>
                            <a href="/perfil/{{ $criador['id'] }}">
                                @if ($criador['profile_photo_path'] == '')
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($criador['name']) }}&color=7F9CF5&background=EBF4FF"
                                        alt="Imagem de perfil" class="img-perfil rounded-circle mini-bloco">
                                @else
                                    <img src="/storage/{{ $criador['profile_photo_path'] }}" alt="Imagem de perfil"
                                        class="img-perfil rounded-circle mini-bloco">
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        <div class="container bg-white rounded shadow p-3 mt-3 w-100 text-center"
                            style="height: fit-content;">
                            <b>Categoria</b>
                            <br>
                            <div class="text-center rounded mini-bloco w-100"
                                style="background-image: linear-gradient(rgba(0, 0, 0, 0.527),rgba(0, 0, 0, 0.5)) ,url('https://source.unsplash.com/200x100/?{{ $categoria['categoria_ingles'] }}'); background-size:cover;">
                                <a href="/categoria/{{ $categoria['id'] }}">
                                    <h5>
                                        <ion-icon name="extension-puzzle-outline"></ion-icon>
                                        {{ $categoria['categoria'] }}
                                    </h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="container bg-white rounded shadow w-100 mt-3 p-3">
                    <h3>Descrição da campanha</h3>
                    <p>{!! nl2br(e($campanha->descricao)) !!}</p>

                </div>
            </div>
        </div>
    </div>


    <script>
        function copy() {
            /* Get the text field */
            var copyText = document.getElementById("linkToCopy");
            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            /* Copy the text inside the text field */
            document.execCommand("copy");
            /* Alert the copied text */
            alert("Texto copiado para a área de transferência!");
        }
    </script>
@endsection
