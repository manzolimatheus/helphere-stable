@extends('layouts.main')

@section('titulo', $institute->nome_instituicao)

@section('conteudo')

    {{-- Modal Doação 1 --}}
    <div class="modal fade" id="ModalDoar" tabindex="-1" aria-labelledby="ModalDoar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Doação para
                        {{ $institute->nome_instituicao }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="/doar" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div hidden>
                            <label for="id_instituicao" class="mt-3">Id Da Instituição</label>
                            <input type="number" name="id_instituicao" id="id_instituicao" value="{{ $institute->id }}"
                                class="form-control">
                        </div>

                        <div hidden>
                            <label for="id_doador" class="mt-3">Id do doador</label>
                            <input type="number" name="id_doador" id="id_doador" value="{{ $usuario->id }}"
                                class="form-control">
                        </div>

                        <div>
                            <label for="valorDoado" class="mt-3">Digite o valor a ser doado:</label>
                        <input type="number" step="0.01" min="0.01" max="1000" name="valorDoado" id="valorDoado" class="form-control"
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
                                        value="{{Request::url()}}" aria-describedby="link"
                                        id="linkToCopy">
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

    {{-- Modal de Recados --}}
    <div class="modal fade" id="ModalMensagem" tabindex="-1" aria-labelledby="ModalMensagem" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalMensagem">Deixar recado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/enviar_mensagem/{{ $criador['id'] }}" method="post">
                        @csrf

                        <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                            aria-controls="collapseExample"><b>O que são os recados?</b>
                            <img src="/img/assets/Message.png" alt="Ícone de mensagem" width="50px">
                        </a>

                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                                <p class="text-muted">Recados são uma forma fácil de enviar uma mensagem como forma de
                                    "aviso" ou comunicado. Você pode deixar alguma forma de contato para uma conversa em
                                    tempo real. Faça bom proveito! 😀</p>
                            </div>
                        </div>
                        <br>
                        <label for="title">Título do recado</label>
                        <input type="text" name="title" id="title" class="form-control" required>

                        <label for="data" class="mt-3">Conteúdo do recado</label>
                        <textarea name="data" id="data" required class="form-control"></textarea>

                        <button type="submit" class="btn btn-success w-100 rounded-pill mt-3">
                            <ion-icon name="send"></ion-icon>
                        </button>
                    </form>
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
                <img src="{{ $institute->image }}" alt="{{ $institute->nome_instituicao }}" class="w-100 rounded-bottom"
                    style="width: 800; height: 300px; object-fit: cover;">
            </div>

            {{-- Imagem de perfil, Nome do perfil e botão de editar --}}
            <div class="container p-3">
                <img src="{{ $institute->image_perfil }}" alt="Imagem de perfil" class="img-perfil rounded-circle">
                <h1>{{ $institute->nome_instituicao }}</h1>
                <p class="text-muted">Instituição</p>
                {{-- Botão de editar --}}
                {{-- Se o id usuário logado for igual ao do id do criador da instituição, então pode editar --}}
                @if (Auth::id() == $institute->id_criador)
                    <div class="container text-center">
                        <a href="/instituicao/edit/{{ $institute->id }}">
                            <ion-icon name="create-outline"></ion-icon>Editar
                        </a>
                    </div>
                @endif
            </div>
            <div class="container p-3">
                <hr>
                <div class="row">
                    {{-- Coluna 1 --}}
                    @if (Auth::id() !== $institute->id_criador)
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
                    {{-- Coluna 3 --}}
                    @if (Auth::id() !== $institute->id_criador)
                    <div class="col-sm p-1">
                        <button class="btn bg-roxo w-100 p-3 text-white rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#ModalMensagem">
                            <b>Deixar recado</b>
                        </button>
                    </div>
                    @endif
                     {{-- COluna 4  --}}
                    @if (Auth::id() === $institute->id_criador)
                    <div class="col-sm p1">
                        <a href="/instituicao/{{ $institute['id'] }}/estatistica">
                            <button class="btn bg-verde-agua w-100 p-3 text-white rounded-pill">
                                <b>Estimativa das doações</b>
                            </button>
                        </a>
                    </div>
                    @endif               
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
                    <ion-icon name="information-circle" class="me-2 text-muted"></ion-icon>
                    <p>{{ $institute->descricao }}</p>

                    <p>
                        <ion-icon name="egg" class="me-2 text-muted"></ion-icon>Criado em
                        {{ date('d/m/Y', strtotime($institute->created_at)) }}
                    </p>
                    <p>
                        <ion-icon name="call" class="me-2 text-muted"></ion-icon>
                        {{ $institute->telefone }}
                    </p>
                    <p>
                        <ion-icon name="mail" class="me-2 text-muted"></ion-icon>
                        <a href="mailto: {{ $institute->email }}"> {{ $institute->email }}</a>
                    </p>
                    <p>
                        <ion-icon name="location" class="me-2 text-muted"></ion-icon>
                        {{ $institute->logradouro }}, {{ $institute->municipio }} - {{ $institute->uf }}
                    </p>

                        

                </div>

                @if (Auth::id() === $institute->id_criador)
                    <div class="col-sm-5 container bg-white rounded shadow p-3 mt-3 w-100 text-center"
                        style="height: fit-content">
                        <p>

                            <ion-icon name="cash-outline" class="me-2 text-muted"></ion-icon> Doações recebidas no último
                            mês!
                        <div class="text-center">

                            <h3><strong>
                                    <ion-icon name="trending-up-outline" class="text-success"></ion-icon> R$
                                    {{ $paymentLastMonth }}
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
                @if (Auth::id() === $institute->id_criador)
                    <div class="container bg-white shadow p-3 mt-3 rounded">

                        {{-- Formulário --}}
                        <form class="mb-3" action="/post_institute/{{ $institute->id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <label for="text">Mensagem</label>
                            <textarea name="data" id="text" class="form-control" required
                                placeholder="O que você deseja compartilhar com a comunidade?"></textarea>
                            <div class="row mt-3">
                                <label for="image">
                                    <ion-icon name="image-outline" class="text-success me-2"></ion-icon>Enviar imagem
                                </label>
                                <div class="col-sm mt-1">
                                    <input type="file" name="image" id="image" class="form-control w-100 rounded-pill"
                                        accept="image/*" onchange="validateImage()">
                                </div>
                                <div class="col-sm mt-1">
                                    <button type="submit" class="btn btn-success w-100 rounded-pill">
                                        <ion-icon name="send"></ion-icon>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <img src="" id="preview" class="img-fluid rounded border shadow" width="100px">
                    </div>
                @endif
                <div class="container bg-white rounded shadow p-3 mt-3">
                    {{-- Posts --}}
                    <h5>Postagens de {{ $institute->nome_instituicao }}</h5>
                </div>
                @if (count($posts) < 1)
                    <div class="container bg-white rounded shadow p-3 mt-3 mb-3">
                        <div class="container text-center">
                            <h5 class="mt-3">Esse perfil não apresenta nenhuma postagem! :(</h5>
                            <div class="container p-3 mt-3 mb-3">
                                <lottie-player src="https://assets4.lottiefiles.com/packages/lf20_ydo1amjm.json"
                                    background="transparent" speed="1" loop autoplay></lottie-player>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($posts as $post)
                        <div class="container bg-white rounded shadow p-3 mt-3 mb-3">
                            <div class="post-foto">
                                <img src="{{ $institute->image_perfil }}" alt="Imagem de perfil">
                                <b>{{ $institute->nome_instituicao }}</b>
                            </div>
                            <div class="w-100">

                                <p>{!! nl2br(e($post->data)) !!}</p>
                                @if ($post->image != '')
                                    <img src="{{ $post->image }}" alt="Imagem" class="w-100 rounded">
                                @endif
                                <div class="row">
                                    <div class="col-sm">
                                        <p class="text-muted me-3">Postado em
                                            {{ date('d/m/Y', strtotime($post->created_at)) }}</p>
                                    </div>
                                    <div class="col-sm mb-1">
                                        @if (Auth::id() === $institute->id_criador)
                                            <form action="/post_delete/{{ $post->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-white"
                                                    onclick="return confirm('Deseja realmente deletar esse post? Essa é uma ação sem volta!');">
                                                    <span class="text-primary">Deletar post</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="col-sm">
                                        <form action="/report_post_institute/{{ $post->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="border-0 bg-white"
                                                onclick="return alert('Post reportado! Nossa equipe verificará o ocorrido o mais rápido possível! 😉');">
                                                <span class="text-primary">Reportar post</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="wrapper">
                        {{ $posts->links() }}
                    </div>
                @endif
                {{-- Fim Posts --}}
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
        function validateImage() {
            var fileName = document.getElementById("image").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile == "jpg" || extFile == "jpeg" || extFile == "png" || extFile == "gif") {
                var output = document.getElementById('preview');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                }
            } else {
                alert("Somente imagens com extensão .jpg, .jpeg, .png e .gif são permitidas!");
                document.getElementById("image").value = '';
            }
        }
    </script>
@endsection